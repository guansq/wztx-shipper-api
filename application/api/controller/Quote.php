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
    /**
     * @api {POST}  /order/showDriverQuoteList      显示司机报价列表
     * @apiName     showDriverQuoteList
     * @apiGroup    Quote
     * @apiHeader   {String}    authorization-token     token.
     * @apiParam    {Int}    order_id        订单ID
     * @apiSuccess  {Array}  list            报价列表
     * @apiSuccess  {String} list.quote_id        报价ID
     * @apiSuccess  {String} list.driver_id       司机ID
     * @apiSuccess  {String} list.avatar          司机头像
     * @apiSuccess  {String} list.score           司机评分
     * @apiSuccess  {String} list.car_type        司机车型
     * @apiSuccess  {String} list.car_length      司机车长
     * @apiSuccess  {String} list.card_number     车牌号码
     * @apiSuccess  {String} list.quote_price     报价
     */
    public function showDriverQuoteList(){

    }

    /**
     * @api {POST}  /order/sendOrder      派单给司机
     * @apiName     sendOrder
     * @apiGroup    Quote
     * @apiHeader   {String}    authorization-token     token.
     * @apiParam  {String} order_id        订单ID
     * @apiParam  {String} maps              坐标 如   '120.733833,31.253328'
     */
    public function sendOrder(){
        $maps = '120.733833,31.253328';//模拟的坐标
        //取出合适的司机列表
        $list = $this->getDriverList($maps);
        //获取订单id
        $paramAll = $this->getReqParams(['order_id','maps']);
        $rule = [
            'order_id' => 'require',
            'maps' => 'require'
        ];
        //获得订单信息
        $orderInfo = model('TransportOrder','logic')->getTransportOrderInfo(['id'=>$paramAll['order_id']]);
        if(empty($orderInfo)){
           returnJson('4000','获取订单信息失败');
        }
        //写入询价表
        $quoteLogic = model('Quote','logic');
        //更改订单为询价中
        model('TransportOrder','logic')->updateTransport(['id'=>$paramAll['order_id']],['status'=>'quote']);//更改订单为询价中
        foreach($list as $k => $v){
            $info['goods_name'] = $orderInfo['goods_name'];
            $info['weight'] = $orderInfo['weight'];
            $info['order_id'] = $orderInfo['id'];
            $info['dr_id'] = $v['id'];
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
            $quoteId = $quoteLogic->saveQuoteInfo($info);
            //发送系统消息给司机
            sendMsg($info['dr_id'],self::TITLE,self::CONTENT,1);
            //发送推送消息
            $push_token = getPushToken($info['dr_id']);//得到推送token
            if(!empty($push_token)){
                pushInfo($push_token,self::TITLE,self::CONTENT);
            }
        }
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
        $ids = array_unique($ids);
        $where = [
            'id' => ['in',$ids],
            'online' => 0
        ];
        $driver = model('DrBaseInfo','logic')->getEnableDriver($where);
        if(empty($driver)){
            returnJson('4000','附近没有找到司机');
        }
        return $driver;//返回司机列表
    }


    public function test(Request $request){
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

}