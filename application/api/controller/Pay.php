<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/7/7
 * Time: 9:59
 */

namespace app\api\controller;

use EasyWeChat\Foundation\Application;
use EasyWeChat\Payment\Order;
use Payment\Client\Charge;
use Payment\Common\PayException;
use Payment\Config;

class Pay extends BaseController{

    /**
     * @api      {GET} /pay 我的钱包done
     * @apiName  index
     * @apiGroup Pay
     * @apiHeader {String} authorization-token      token.
     * @apiSuccess {String} balance         账户余额
     * @apiSuccess {String} bonus         我的推荐奖励
     */
    public function index(){
        $spBaseInfo = model('SpBaseInfo', 'logic')->findInfoByUserId($this->loginUser['id']);
        returnJson('2000', '成功', [
            'balance' => wztxMoney($spBaseInfo['balance']),
            'bonus' => wztxMoney($spBaseInfo['bonus'])
        ]);
    }



    /**
     * @api      {POST}  /pay/showPayRecord 查看账单done
     * @apiName  showPayRecord
     * @apiGroup Pay
     * @apiHeader {String} authorization-token          token.
     * @apiParam {Number} [page=1]                      页码.
     * @apiParam {Number} [pageSize=20]                 每页数据量.
     * @apiParam    {Int}    is_pay                     是否支付1为已支付 0为未支付
     * @apiSuccess {Array}   list                       账单列表
     * @apiSuccess {String}   list.order_id             订单ID
     * @apiSuccess {String}   list.dr_name              司机姓名
     * @apiSuccess {String}   list.org_city             发货地址
     * @apiSuccess {String}   list.dest_city            收货地址
     * @apiSuccess {String}   list.final_price          运价
     * @apiSuccess {String}   list.pay_time             订单完成时间
     * @apiSuccess {String}   list.usecar_time          用车时间
     * @apiSuccess  {Int}     list.is_pay               是否支付1为已支付 0为未支付
     * @apiSuccess  {String}  list.status               photo 拍照完毕（订单已完成） sucess(完成后的所有状态)pay_failed（支付失败）/pay_success（支付成功）comment（已评论）
     * @apiSuccess {Number} page                        页码.
     * @apiSuccess {Number} pageSize                    每页数据量.
     * @apiSuccess {Number} dataTotal                   数据总数.
     * @apiSuccess {Number} pageTotal                   总页码数.
     */
    public function showPayRecord(){
        $paramAll = $this->getReqParams([
            'is_pay',
        ]);
        $rule = [
            'is_pay' => ['require', '/^(0|1)$/'],
        ];

        validateData($paramAll, $rule);
        $where['status'] = ['in', ['photo', 'pay_failed', 'pay_success', 'comment']];
        $where['is_pay'] = $paramAll['is_pay'];
        $where['sp_id'] = $this->loginUser['id'];
        $pageParam = $this->getPagingParams();
        $orderInfo = model('TransportOrder', 'logic')->getTransportOrderList($where, $pageParam);
        if(empty($orderInfo)){
            returnJson('4004', '暂无订单信息');
        }
        $list = [];
        foreach($orderInfo['list'] as $k => $v){
            $list[$k]['order_id'] = $v['id'];
            $list[$k]['org_city'] = $v['org_city'];
            $list[$k]['dest_city'] = $v['dest_city'];
            if(!empty($v['dr_id'])){
                $drBaseInfo = model('DrBaseInfo', 'logic')->findInfoByUserId($v['dr_id']);
                $dr_real_name = $drBaseInfo['real_name'];
            }else{
                $dr_real_name = '';
            }
            $list[$k]['dr_name'] = $dr_real_name;
            $list[$k]['final_price'] = wztxMoney($v['final_price']);
            $list[$k]['pay_time'] = wztxDate($v['pay_time']);
            $list[$k]['usecar_time'] = wztxDate($v['usecar_time']);
            $list[$k]['is_pay'] = $v['is_pay'];
            $list[$k]['status'] = $v['status'];
        }
        $orderInfo['list'] = $list;
        returnJson('2000', '成功', $orderInfo);
    }

    /**
     * @api      {POST} /pay/rechargeRecord  充值记录done
     * @apiName  rechargeRecord
     * @apiGroup Pay
     * @apiHeader {String} authorization-token      token.
     * @apiParam {Number} [page=1]                  页码.
     * @apiParam {Number} [pageSize=20]             每页数据量.
     * @apiSuccess  {Array}     list                     充值记录列表
     * @apiSuccess  {String}    list.real_amount              充值金额
     * @apiSuccess  {Int}       list.pay_way                  支付方式 1=支付宝，2=微信
     * @apiSuccess  {String}    list.pay_time                  支付时间
     * @apiSuccess  {Int}       list.pay_status               支付状态 0=未支付，1=支付成功，2=支付失败
     * @apiSuccess {Number} page                页码.
     * @apiSuccess {Number} pageSize            每页数据量.
     * @apiSuccess {Number} dataTotal           数据总数.
     * @apiSuccess {Number} pageTotal           总页码数.
     */
    public function rechargeRecord(){
        $where['sp_id'] = $this->loginUser['id'];
        $where['type'] = $this->loginUser['type'];
        $pageParam = $this->getPagingParams();
        $recordInfo = model('Pay', 'logic')->getRechargeRecordList($where, $pageParam);
        if(empty($recordInfo)){
            returnJson('4004', '暂无订单信息');
        }
        $list = $recordInfo['list'];

        foreach($list as $k => $v){
            $list[$k]['real_amount'] = wztxMoney($v['real_amount']);
            $list[$k]['balance'] = wztxMoney($v['balance']);
            $list[$k]['pay_time'] = wztxDate($v['pay_time']);
        }
        $recordInfo['list'] = $list;
        returnJson('2000', '成功', $recordInfo);
    }

    /**
     * @api      {POST} /pay/alipay  支付宝订单支付done
     * @apiName  alipay
     * @apiGroup Pay
     * @apiHeader {String} authorization-token      token.
     * @apiParam  {Number}  order_id                订单ID
     * @apiParam  {Number}  total_amount            支付金额
     */
    public function alipay(){
        $ispass = ispassAuth($this->loginUser);
        if(!$ispass){
            returnJson(4000,'您未认证或未缴纳保证金');
        }
        $paramAll = $this->getReqParams(['order_id']);
        $rule = [
            'order_id' => 'require'
        ];
        validateData($paramAll,$rule);
        $order_info = model('TransportOrder','logic')->getTransportOrderInfo(['id'=>$paramAll['order_id'],'sp_id'=>$this->loginUser['id'],'status'=>'photo']);//需要拍照后的状态
        if(empty($order_info)){
            returnJson(4000,'暂无待付款订单信息');
        }

        $partner_public_key = getenv('ALIPAY_PARTNER_PUBLIC_KEY');
        $alipay_public_key = getenv('ALIPAY_ALI_PUBLIC_KEY');
        //公用变量
        $appId = getenv("ALIPAY_APPID");

        $partner_private_key = getenv('ALIPAY_PARTNER_PRIVATE_KEY');

        include(APP_PATH.'/alipay/AopSdk.php');
        $aop = new \AopClient();
        $aop->gatewayUrl =  getenv('ALIPAY_IS_USE_SANDBOX')?'https://openapi.alipaydev.com/gateway.do':'https://openapi.alipay.com/gateway.do';
        $aop->appId = $appId;
        $aop->rsaPrivateKey = $partner_private_key;
        $aop->format = "json";
        $aop->charset = "utf-8";
        $aop->signType = "RSA2";
        $aop->debugInfo = true;
        $aop->alipayrsaPublicKey = $alipay_public_key;
        //实例化具体API对应的request类,类名称和接口名称对应,当前调用接口名称：alipay.trade.app.pay
        $request = new \AlipayTradeAppPayRequest();
        //SDK已经封装掉了公共参数，这里只需要传入业务参数
        $bizData =[
            'body'=>$order_info['id'],
            "subject"=>"订单支付",
            "out_trade_no"=>$order_info['order_code'],
            "timeout_express"=>"90m",
            "total_amount"=>"1",
            "product_code"=>"QUICK_MSECURITY_PAY",
            "passback_params" => "transport"//传入额外的参数
        ];
        $bizcontent = json_encode($bizData);
        $request->setNotifyUrl(getenv("ALIPAY_CALLBACK_URL"));
        $request->setBizContent($bizcontent);
        //这里和普通的接口调用不同，使用的是sdkExecute
        $response = $aop->sdkExecute($request);
        //returnJson(2000,'成功',$response);die;
        //htmlspecialchars是为了输出到页面时防止被浏览器将关键参数html转义，实际打印到日志以及http传输不会有这个问题
        //$orderString = htmlspecialchars($response);//就是orderString 可以直接给客户端请求，无需再做处理。
        returnJson(2000, '成功', ['orderString'=>$response,'isUseSandbox' =>getenv('ALIPAY_IS_USE_SANDBOX')]);
    }

    /**
     * @api      {POST} /pay/alipayCash  支付宝保证金支付done
     * @apiName  alipay
     * @apiGroup Pay
     * @apiHeader {String} authorization-token      token.
     */
    public function alipayCash(){
        $ispass = ispassAuth($this->loginUser);
        if($ispass){
            returnJson(4000,'您已认证过，无需重复缴纳保证金');
        }
        if($this->loginUser['type'] == 'person'){
            $amount = getSysconf('bond_person_amount');
        }elseif($this->loginUser['type'] == 'company'){
            $amount = getSysconf('bond_company_amount');
        }
        $partner_public_key = getenv('ALIPAY_PARTNER_PUBLIC_KEY');
        $alipay_public_key = getenv('ALIPAY_ALI_PUBLIC_KEY');
        //公用变量
        $appId = getenv("ALIPAY_APPID");
        $partner_private_key = getenv('ALIPAY_PARTNER_PRIVATE_KEY');

        include(APP_PATH.'/alipay/AopSdk.php');
        $aop = new \AopClient();
        $aop->gatewayUrl =  getenv('ALIPAY_IS_USE_SANDBOX')?'https://openapi.alipaydev.com/gateway.do':'https://openapi.alipay.com/gateway.do';
        $aop->appId = $appId;
        $aop->rsaPrivateKey = $partner_private_key;
        $aop->format = "json";
        $aop->charset = "utf-8";
        $aop->signType = "RSA2";
        $aop->debugInfo = true;
        $aop->alipayrsaPublicKey = $alipay_public_key;
        //实例化具体API对应的request类,类名称和接口名称对应,当前调用接口名称：alipay.trade.app.pay
        $request = new \AlipayTradeAppPayRequest();
        //SDK已经封装掉了公共参数，这里只需要传入业务参数 sp_margin_order
        $order_code = order_num();
        //dump($this->loginUser);die;
        $marginData = [
            'sp_id' => $this->loginUser['id'],
            'type' => $this->loginUser['type'],
            'name' => $this->loginUser['real_name'],
            'phone' => $this->loginUser['user_name'],
            'total_amount' => $amount,
            'order_code' => $order_code,
            'pay_time' => time(),
            'pay_way' => 1,//支付宝
            'pay_status' => 0,//未支付
        ];
        model('SpMarginOrder','logic')->saveMarginOrder($marginData);
        $bizData =[
            'body'=>$this->loginUser['user_name'].'支付保证金',
            "subject"=>"保证金支付",
            "out_trade_no"=>$order_code,
            "timeout_express"=>"90m",
            "total_amount"=>$amount,//保证金金额
            "product_code"=>"QUICK_MSECURITY_PAY",
            "passback_params" => "bond"//传入额外的参数
        ];
        $bizcontent = json_encode($bizData);
        $request->setNotifyUrl(getenv("ALIPAY_CALLBACK_URL"));
        $request->setBizContent($bizcontent);
        //这里和普通的接口调用不同，使用的是sdkExecute
        $response = $aop->sdkExecute($request);
        //returnJson(2000,'成功',$response);die;
        //htmlspecialchars是为了输出到页面时防止被浏览器将关键参数html转义，实际打印到日志以及http传输不会有这个问题
        //$orderString = htmlspecialchars($response);//就是orderString 可以直接给客户端请求，无需再做处理。
        returnJson(2000, '成功', ['orderString'=>$response,'isUseSandbox' =>getenv('ALIPAY_IS_USE_SANDBOX')]);
    }





    /**
     * @api      {POST} /pay/wxpay  微信支付
     * @apiName  wxpay
     * @apiGroup Pay
     * @apiHeader {String} authorization-token      token.
     * @apiParam  {Number}  order_id                订单ID
     * @apiParam  {Number}  total_amount            支付金额
     */
    public function wxpay(){
        $wxConfig = require_once APP_PATH.'wxconfig.php';
        $orderNo = time().rand(1000, 9999);
        // 订单信息
        $payData = [
            'body' => 'test body',
            'subject' => 'test subject',
            'order_no' => $orderNo,
            'timeout_express' => time() + 600,// 表示必须 600s 内付款
            'amount' => '0.01',// 微信沙箱模式，需要金额固定为3.01
            'return_param' => '123',
            'client_ip' => isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '127.0.0.1',// 客户地址
        ];

        try{
            $ret = Charge::run(Config::WX_CHANNEL_APP, $wxConfig, $payData);
        }catch(PayException $e){
            echo $e->errorMessage();
            exit;
        }

        //$str = json_encode($ret, JSON_UNESCAPED_UNICODE);
        returnJson(2000, '成功', $ret);
        die;

        $ispass = ispassAuth($this->loginUser);
        if(!$ispass){
            returnJson(4000, '您未认证或未缴纳保证金');
        }
        $paramAll = $this->getReqParams(['order_id']);
        $rule = [
            'order_id' => 'require'
        ];
        validateData($paramAll, $rule);

    }

    /**
     * 生成微信sign
     * @param array  $attributes
     * @param        $key
     * @param string $encryptMethod
     * @return string
     */
    public function generate_sign(array $attributes, $key, $encryptMethod = 'md5'){
        ksort($attributes);

        $attributes['key'] = $key;

        return strtoupper(call_user_func_array($encryptMethod, [urldecode(http_build_query($attributes))]));
    }

    /**
     * @api      {POST} /pay/scorePay  通过余额支付（订单）done
     * @apiName  scorePay
     * @apiGroup Pay
     * @apiHeader {String} authorization-token      token.
     * @apiParam  {String} order_id 订单ID
     *
     */
    public function scorePay(){
        $ispass = ispassAuth($this->loginUser);
        if(!$ispass){
            returnJson(4000,'您未认证或未缴纳保证金');
        }
        $paramAll = $this->getReqParams(['order_id']);
        $rule = [
            'order_id' => 'require'
        ];
        validateData($paramAll,$rule);
        $order_info = model('TransportOrder','logic')->getTransportOrderInfo(['id'=>$paramAll['order_id'],'sp_id'=>$this->loginUser['id'],'status'=>'photo']);//需要拍照后的状态
        if(empty($order_info)){
            returnJson(4000,'暂无待付款订单信息');
        }
        //得到我的余额
        $baseInfo = getBaseSpUserInfo($this->loginUser['id']);
        if($baseInfo['balance'] < $order_info['final_price']){
            returnJson(4000,'抱歉，您的余额不足');
        }
        //更新个人余额信息
        $newBalance = $baseInfo['balance'] - $order_info['final_price'];
        model('SpBaseInfo','logic')->updateUserBalance(['id'=>$this->loginUser['id']],['balance'=>$newBalance]);//更新账户信息
        //更新订单信息
        $transportLogic = model('TransportOrder','logic');
        $where = ['id'=>$order_info['id']];
        $statusdata = [
            'status' => 'pay_success',
            'payway' => 1,//0=未支付，1=余额，2=微信，3=支付宝，4-凭证通过
            'is_pay' =>1,
            'pay_time'=>time()
        ];
        saveOrderShare($order_info['id']);//存入推荐列表

        $transportLogic->updateTransport($where,$statusdata);
        $pay_type_order = 'transport';
        //需要进行存入sp_pay_order表里
        $data = [
            'sp_id' =>$order_info['sp_id'],
            'order_id' => $order_info['order_code'],
            'trade_no' =>'',//第三方交易号
            'total_amount' =>$order_info['final_price'],
            'real_amount' =>$order_info['final_price'],
            'out_trade_no' =>'',//当前的订单code
            //'pay_orderid' =>$data['trade_no'],
            'pay_type_order' =>$pay_type_order,
            'pay_time' =>time(),
            'pay_way' =>1,//1=支付宝，2=微信
            'pay_status' =>1,
        ];
        //trace($data);
        $ret = model('SpPayOrder','logic')->savePayOrder($data);
        returnJson($ret);
    }

    /**
     * @api      {POST} /pay/rechargeByAlipay  充值余额通过支付宝充值done
     * @apiName  rechargeByAlipay
     * @apiGroup Pay
     * @apiHeader {String} authorization-token      token.
     * @apiParam  {String} money 充值金额
     */
    public function rechargeByAlipay(){
        $paramAll = $this->getReqParams(['money']);
        $rule = [
            'money' => 'require'
        ];
        validateData($paramAll,$rule);

        $partner_public_key = getenv('ALIPAY_PARTNER_PUBLIC_KEY');
        $alipay_public_key = getenv('ALIPAY_ALI_PUBLIC_KEY');
        //公用变量
        $appId = getenv("ALIPAY_APPID");
        $partner_private_key = getenv('ALIPAY_PARTNER_PRIVATE_KEY');

        include(APP_PATH.'/alipay/AopSdk.php');
        $aop = new \AopClient();
        $aop->gatewayUrl =  getenv('ALIPAY_IS_USE_SANDBOX')?'https://openapi.alipaydev.com/gateway.do':'https://openapi.alipay.com/gateway.do';
        $aop->appId = $appId;
        $aop->rsaPrivateKey = $partner_private_key;
        $aop->format = "json";
        $aop->charset = "utf-8";
        $aop->signType = "RSA2";
        $aop->debugInfo = true;
        $aop->alipayrsaPublicKey = $alipay_public_key;
        //实例化具体API对应的request类,类名称和接口名称对应,当前调用接口名称：alipay.trade.app.pay
        $request = new \AlipayTradeAppPayRequest();
        //SDK已经封装掉了公共参数，这里只需要传入业务参数 sp_margin_order
        $order_code = order_num();
        $marginData = [
            'sp_id' => $this->loginUser['id'],
            'total_amount' => wztxMoney($paramAll['money']),
            'pay_orderid' => $order_code,
            'pay_time' => time(),
            'pay_way' => 1,//支付宝
            'pay_status' => 0,//未支付
        ];
        model('SpRechargeOrder','logic')->saveRechargeOrder($marginData);
        $bizData =[
            'body'=>$this->loginUser['user_name'].'充值',
            "subject"=>"充值",
            "out_trade_no"=>$order_code,
            "timeout_express"=>"90m",
            "total_amount"=>wztxMoney($paramAll['money']),//保证金金额
            "product_code"=>"QUICK_MSECURITY_PAY",
            "passback_params" => "recharge"//传入额外的参数充值
        ];
        $bizcontent = json_encode($bizData);
        $request->setNotifyUrl(getenv("ALIPAY_CALLBACK_URL_URL"));
        $request->setBizContent($bizcontent);
        //这里和普通的接口调用不同，使用的是sdkExecute
        $response = $aop->sdkExecute($request);
        //returnJson(2000,'成功',$response);die;
        //htmlspecialchars是为了输出到页面时防止被浏览器将关键参数html转义，实际打印到日志以及http传输不会有这个问题
        //$orderString = htmlspecialchars($response);//就是orderString 可以直接给客户端请求，无需再做处理。
        returnJson(2000, '成功', ['orderString'=>$response,'isUseSandbox' =>getenv('ALIPAY_IS_USE_SANDBOX')]);
    }

    /**
     * @api      {POST} /pay/rechargeByWexin  充值余额通过微信充值
     * @apiName  rechargeByWexin
     * @apiGroup Pay
     * @apiHeader {String} authorization-token      token.
     * @apiParam  {String} money    充值金额
     */
    public function rechargeByWexin(){
        $paramAll = $this->getReqParams(['money']);
        $rule = [
            'money' => 'require'
        ];
        validateData($paramAll,$rule);

        $wxConfig = require_once APP_PATH.'wxconfig.php';
        $order_code = order_num();
        $marginData = [
            'sp_id' => $this->loginUser['id'],
            'total_amount' => wztxMoney($paramAll['money']),
            'pay_orderid' => $order_code,
            'pay_time' => time(),
            'pay_way' => 2,//微信
            'pay_status' => 0,//未支付
        ];
        model('SpRechargeOrder','logic')->saveRechargeOrder($marginData);
        // 订单信息
        $payData = [
            'body' => $this->loginUser['user_name'].'微信充值',
            'subject' => '微信充值',
            'order_no' => $order_code,
            'timeout_express' => time() + 600,// 表示必须 600s 内付款
            'amount' => '0.01',// 微信沙箱模式，需要金额固定为3.01
            'return_param' => '123',
            'attach' => '11111',
            'client_ip' => isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '127.0.0.1',// 客户地址
        ];

        try{
            $ret = Charge::run(Config::WX_CHANNEL_APP, $wxConfig, $payData);
        }catch(PayException $e){
            //echo $e->errorMessage();
            returnJson(2000, $e->errorMessage(), '');
            exit;
        }
        //$str = json_encode($ret, JSON_UNESCAPED_UNICODE);
        returnJson(2000, '成功', $ret);
    }
}