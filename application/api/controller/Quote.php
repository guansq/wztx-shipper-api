<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/7/11
 * Time: 17:14
 */
namespace app\api\controller;

use think\Request;

use service\MapService;
use DesUtils\DesUtils;
class Quote extends BaseController{
    const MSG = '您有一条新的订单';
    const TITLE = '订单信息';
    const CONTENT = '您有一条新的订单';
    const DRMSG = '您的报价已被货主接收';
    const DRTITLE = '您的报价已被货主接收';
    const DRCONTENT = '您的报价已被货主接收';
    /**
     * @api {POST}  /quote/showDriverQuoteList      显示司机报价列表 done
     * @apiName     showDriverQuoteList
     * @apiGroup    Quote
     * @apiHeader   {String}    authorization-token     token.
     * @apiParam    {Int}    goods_id        货源ID
     * @apiParam    {Number} [page=1]                  页码.
     * @apiParam    {Number} [pageSize=20]             每页数据量.
     * @apiSuccess  {Array}  list            报价列表
     * @apiSuccess  {String} list.id        报价ID
     * @apiSuccess  {String} list.dr_id       司机ID
     * @apiSuccess  {String} list.avatar          司机头像
     * @apiSuccess  {String} list.score           司机评分
     * @apiSuccess  {String} list.car_style_type        司机车型
     * @apiSuccess  {String} list.car_style_length      司机车长
     * @apiSuccess  {String} list.card_number     车牌号码
     * @apiSuccess  {String} list.dr_price     报价
     */
    public function showDriverQuoteList(){
        $pageParam = $this->getPagingParams();
        $paramAll = $this->getReqParams(['goods_id']);
        $rule = ['goods_id'=>'require'];
        validateData($paramAll,$rule);
        $where = [
            'goods_id' => $paramAll['goods_id'],
            'sp_id' => $this->loginUser['id'],
            'status' => 'quote',//司机已报价
        ];
        $ret = model('Quote','logic')->showQuoteList($where,$pageParam);//显示我的报价列表
        returnJson($ret);
    }

    /**
     * @api {POST}  /quote/sendOrder      派单给司机done
     * @apiName     sendOrder
     * @apiGroup    Quote
     * @apiHeader   {String}    authorization-token     token.
     * @apiParam  {String} order_id        订单ID
     * @apiParam  {String} maps              坐标 如   '120.733833,31.253328'
     */
    public function sendOrder(){
//        $paramAll = $this->getReqParams(['order_id','maps']);
//        $rule = ['order_id'=>'require','maps'=>'require'];
        $maps = '120.733833,31.253328';//模拟的坐标

        //获取订单id
        $paramAll = $this->getReqParams(['order_id','maps']);
        $rule = [
            'order_id' => 'require',
            'maps' => 'require'
        ];
        validateData($paramAll,$rule);
        //获得订单信息
        $orderInfo = model('TransportOrder','logic')->getTransportOrderInfo(['id'=>$paramAll['order_id'],'sp_id'=>$this->loginUser['id'],'status'=>'init']);
        if(empty($orderInfo)){
           returnJson(4000,'获取订单信息失败');
        }
        //取出合适的司机列表
        $list = $this->getDriverList($paramAll['maps']);
        //dump($list);die;
        //写入询价表
        $quoteLogic = model('Quote','logic');
        //更改订单为询价中
        model('TransportOrder','logic')->updateTransport(['id'=>$paramAll['order_id']],['status'=>'quote']);//更改订单为询价中
        foreach($list as $k => $v){
            $info['goods_name'] = $orderInfo['goods_name'];
            $info['weight'] = $orderInfo['weight'];
            $info['order_id'] = $orderInfo['id'];
            $info['dr_id'] = $v['id'];
            $info['sp_id'] = $this->loginUser['id'];
            $info['system_price'] = $orderInfo['system_price'];
            $info['sp_price'] = $orderInfo['mind_price'];
            $info['usecar_time'] = $orderInfo['usecar_time'];
            $info['car_style_length'] = $orderInfo['car_style_length'];
            $info['car_style_type'] = $orderInfo['car_style_type'];
            $info['org_city'] = $orderInfo['org_city'];
            $info['dest_city'] = $orderInfo['dest_city'];
            $info['org_address_name'] = $orderInfo['org_address_name'];
            $info['dest_address_name'] = $orderInfo['dest_address_name'];
            $info['org_address_detail'] = $orderInfo['org_address_detail'];
            $info['dest_address_detail'] = $orderInfo['dest_address_detail'];
            //dump($info);
            //$quoteId = $quoteLogic->saveQuoteInfo($info);不生成询价单
            //发送系统消息给司机
            sendMsg($info['dr_id'],self::TITLE,self::CONTENT,1);
            //发送推送消息
            $push_token = getPushToken($info['dr_id']);//得到推送token
            if(!empty($push_token)){
                pushInfo($push_token,self::TITLE,self::CONTENT,'wztx_driver');//推送给司机
            }
        }
        returnJson(2000,'派单成功');
    }


    /**
     *取出附近的上班中的司机列表
     */
    public function getDriverList($maps){
        //先取高德地图上附近的人
        $datas = MapService::aroundDriver($maps);
        //echo getSysconf('grab_range');
        //然后从数据库把司机给
        if(empty($datas)){
            returnJson('4000','附近没有找到司机');
        }

        foreach($datas as $k => $v){
            $ids[] = $v['_name'];
        }
        //dump($datas);die;
        $ids = array_unique($ids);
        //认证通过的司机
        $where = [
            'id' => ['in',$ids],
            'auth_status' => 'pass',
            'online' => 0
        ];
        $driver = model('DrBaseInfo','logic')->getEnableDriver($where);
        if(empty($driver)){
            returnJson('4000','附近没有找到司机');
        }
        return $driver;//返回司机列表
    }


    public function test(Request $request){
        dump($this->loginUser);die;
        $appKey = input('rt_appkey');
        $reqTime = input('req_time');
        $action = input('req_action');
        $secret = config('app_access_key');
        $secretArr = explode('_',$secret);
        $params = [$appKey, $action ,$reqTime ];

        $des = new DesUtils();
        $naturalOrdering = $des->naturalOrdering($params);

        $sign = $des->strEnc($naturalOrdering,$secretArr[0],$secretArr[1],$secretArr[2]);
        if($request->isGet()){
            $this->assign('action', $action);
            $this->assign('appKey', $appKey);
            $this->assign('secret', $secret);
            $this->assign('naturalOrdering', $naturalOrdering);
            $this->assign('sign', $sign);
            return view();
        }

        if($request->isPost()){
            returnJson(2000,$sign);
        }

    }

    /**
     * @api {POST}  /quote/confirmQuotePrice      确认报价价格done
     * @apiName     confirmQuotePrice
     * @apiGroup    Quote
     * @apiHeader   {String}    authorization-token     token.
     * @apiParam  {String} quote_id        报价ID
     */
    public function confirmQuotePrice(){
        //最终价格确定 final_price（不含保费） 司机确定 dr_id status quoted
        //查询订单信息是否合法 确定后更改报价状态订单状态，发送推送信息给司机让司机去执行订单
        $paramAll = $this->getReqParams(['quote_id']);
        $rule = ['quote_id'=>'require'];
        validateData($paramAll,$rule);
        $where = [
            'id' => $paramAll['quote_id'],
            'sp_id' => $this->loginUser['id'],
        ];
        $ret = model('Quote','logic')->getQuoteInfo($where);//得到报价信息
        if($ret['code'] == 4000){
            returnJson($ret);
        }
        /*$count = model('Quote','logic')->getQuoteCount($where);
        if($count == 0){
            returnJson(4000,'抱歉该条信息已报价过了，或没有改报价信息');
        }*/
        model('Quote','logic')->changeQuote(['id'=>$paramAll['quote_id']],['is_receive'=>1]);//货主确认该报价
        $quoteInfo = $ret['result'];
        $final_price = $quoteInfo['dr_price'];
        //获得司机报价的价格
        $data = [
            'status' => 'quoted',
            'final_price' => $final_price,
            'dr_id' => $quoteInfo['dr_id'],
        ];
        //保存订单

        //更改订单状态
        //$result = model('TransportOrder','logic')->updateTransport(['id'=>$paramAll['order_id'],'sp_id'=>$this->loginUser['id'],'status'=>'quote'],$data);
        $result = saveOrderBygoodsInfo();
        if($result['code'] == 4000){
            returnJson($result);
        }
        //发送消息给司机
        sendMsg($quoteInfo['dr_id'],self::DRTITLE,self::DRCONTENT,1);
        //发送推送消息
        $push_token = getPushToken($quoteInfo['dr_id']);//得到推送token
        if(!empty($push_token)){
            pushInfo($push_token,self::DRTITLE,self::DRCONTENT,'wztx_driver');//推送给司机
        }
        //发送短信给司机

        sendSMS(getDrPhone($quoteInfo['dr_id']),self::DRCONTENT,'wztx_driver');
        returnJson(2000,'订单成功确定');
    }

    /**
     * Auther: guanshaoqiu <94600115@qq.com>
     * Describe:根据货源信息保存订单
     */
    private function saveOrderBygoodsInfo($goods_id){
        //根据$goods_id取出信息
        $goodsInfo = model('Goods','logic')->getGoodsInfo(['id'=>$goods_id]);
        //生成订单
        $orderInfo['order_code'] = order_num();
        $orderInfo['sp_id'] = $goodsInfo['sp_id'];
        $orderInfo['type'] = $goodsInfo['type'];
        $orderInfo['appoint_at'] = $goodsInfo['appoint_at'];
        $orderInfo['insured_amount'] = $goodsInfo['insured_amount'];
        $orderInfo['premium_amount'] = $goodsInfo['premium_amount'];
        $orderInfo['org_send_name'] = $goodsInfo['org_send_name'];
        $orderInfo['org_address_maps'] = $goodsInfo['org_address_maps'];
        $orderInfo['org_city'] = $goodsInfo['org_city'];
        $orderInfo['org_address_name'] = $goodsInfo['org_address_name'];
        $orderInfo['org_address_detail'] = $goodsInfo['org_address_detail'];
        $orderInfo['org_phone'] = $goodsInfo['org_phone'];
        $orderInfo['org_telphone'] = $goodsInfo['org_telphone'];
        $orderInfo['dest_receive_name'] = $goodsInfo['dest_receive_name'];
        $orderInfo['dest_address_maps'] = $goodsInfo['dest_address_maps'];
        $orderInfo['dest_city'] = $goodsInfo['dest_city'];
        $orderInfo['dest_address_name'] = $goodsInfo['dest_address_name'];
        $orderInfo['dest_address_detail'] = $goodsInfo['dest_address_detail'];
        $orderInfo['dest_phone'] = $goodsInfo['dest_phone'];
        $orderInfo['dest_telphone'] = $goodsInfo['dest_telphone'];
        $orderInfo['goods_name'] = $goodsInfo['goods_name'];
        $orderInfo['volume'] = $goodsInfo['volume'];
        $orderInfo['weight'] = $goodsInfo['weight'];
        $orderInfo['car_style_type'] = $goodsInfo['car_style_type'];
        $orderInfo['car_style_type_id'] = $goodsInfo['car_style_type_id'];
        $orderInfo['car_style_length'] = $goodsInfo['car_style_length'];
        $orderInfo['car_style_length_id'] = $goodsInfo['car_style_length_id'];
        $orderInfo['effective_time'] = $goodsInfo['effective_time'];
        $orderInfo['mind_price'] = $goodsInfo['mind_price'];
        $orderInfo['final_price'] = $goodsInfo['final_price'];
        $orderInfo['system_price'] = $goodsInfo['system_price'];
        $orderInfo['payway'] = $goodsInfo['payway'];
        $orderInfo['is_pay'] = $goodsInfo['is_pay'];
        $orderInfo['remark'] = $goodsInfo['remark'];
        $orderInfo['tran_type'] = $goodsInfo['tran_type'];
        $orderInfo['usecar_time'] = $goodsInfo['usecar_time'];
        $orderInfo['kilometres'] = $goodsInfo['kilometres'];
        $orderInfo['status'] = 'quoted';
        //完善个人信息填写  sp_id
        $baseUserInfo = getBaseSpUserInfo($goodsInfo['sp_id']);
        $orderInfo['real_name'] = $baseUserInfo['real_name'];
        $orderInfo['company_name'] = getCompanyName($baseUserInfo);
        $orderInfo['customer_type'] = $baseUserInfo['type'];
        $address = explode(',',$goodsInfo['org_address_maps']);
        $orderInfo['org_longitude'] = $address[0];
        $orderInfo['org_latitude'] = $address[1];
        $address = explode(',',$goodsInfo['dest_address_maps']);
        $orderInfo['dest_longitude'] = $address[0];
        $orderInfo['dest_latitude'] = $address[1];
        $result = model('TransportOrder','logic')->saveTransportOrder($orderInfo);
        return $result;
    }
}