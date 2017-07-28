<?php
/**
 * Created by PhpStorm.
 * User: xun
 * Date: 2016/9/29
 * Time: 10:15
 */

namespace app\api\controller;


use think\Controller;
use pay\alipay_mobile;
use EasyWeChat\Foundation\Application;
class Callback extends Controller
{
    public function alipay_callback(){
        include(APP_PATH.'/alipay/AopSdk.php');
        $aop = new \AopClient();
        $aop->alipayrsaPublicKey = 'MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAx57k5O9rmVm3WyYXuL5JVQ9PhyGe7ih3AJL/FySC9fas6InkoBtoo+kXsZWTn9rxhOFkMl0mmL7TSDZCWZLX6KNs5cmZh+6yTm++LhPaFsYZnwOsaZlmD6P57g9rJhvfY0LPKZ4I5qdMUQ9uYsaNp4vf7rg9VS1d1KS9I9Qpen0WYsp3zPM/B+ivQk6GpLaR3Q+60dusLc/P7STiIUl8GlfK9efE5h0Ajs5NVES+MmY2Ez1ouoTbnjiZ5ls110zBHLSubeEEB6IIAbsJJdG5L6EiimNsXrTm73QJO0ij31kkb7BsNisb8SuXcdlbdYklfVdY9qT7PshfS8FglxbC5wIDAQAB';
        $flag = $aop->rsaCheckV2($_POST, NULL, "RSA");die;
        $data=input('param.');
        if(empty($data)){
            returnJson(4000,'支付失败');
        }
//        $json='{"total_amount":"0.01","buyer_id":"2088612334436741","trade_no":"2016093021001004740240031489","body":"441524","notify_time":"2016-09-30 16:29:43","subject":"fdsa","sign_type":"RSA","notify_type":"trade_status_sync","out_trade_no":"2016093052531015","trade_status":"TRADE_SUCCESS","gmt_payment":"2016-09-30 16:25:52","sign":"E8T\/SRw4TRjamiPI7RyfSHWEJCKwFAbEtfI88Z8TXa+YDhvuqzkrFb8eQT\/1nRWa156QTD7Q6Lp4ug0+aMjsFyGv7TnWB2scrCQGUDYC\/MXCZrr0o0u+g87Od5MMN+u4f5yQqlb7jOLHkExwjuMxO\/fCrAx8QzZpQcPsEWrZ4ME=","gmt_create":"2016-09-30 16:25:52","app_id":"2016082901818372","seller_id":"2088421610505604","notify_id":"642078cfdefe79319a857018157eb54lpm"}';
//        $data=json_decode($json,true);
//        dump($data);exit;
        $pay=new alipay_mobile();
        // 生成签名结果
        $is_sign = $pay->getSignVeryfy($data, $data['sign']);
        $transportLogic = model('TransportOrder','logic');
        if($is_sign){

            if($data['trade_status'] == 'TRADE_SUCCESS'){
                $order_num=$data['out_trade_no'];//自家的订单CODE
                $where = ['order_code'=>$order_num];
                $statusdata = [
                    'status' => 'pay_success',
                    'payway' => 3,//0=未支付，1=余额，2=微信，3=支付宝，4-凭证通过
                    'is_pay' =>1,
                ];
                $result = $transportLogic->updateTransport($where,$statusdata);
                $order_info = getTransportOrderInfo($where);//得到订单信息
                $this->payRecord(1,$order_info,$data);//1支付成功->保存支付记录
                if($result['code'] == 2000){
                    //进行负责给推荐人分发奖金
                    returnJson(2000,'支付成功');
                }else{
                    returnJson(4000,'支付成功，更改订单支付状态失败');
                }
            }else{
                //$this->payRecord(0,$order_info);//0支付失败
                returnJson(4000,'支付失败');
            }
        }else{
            //$this->payRecord(0,$order_info);//0支付失败
            returnJson(4000,'支付失败');
        }

    }


    public function wxpay_callback(){
        $options = [
            // 前面的appid什么的也得保留哦
            'app_id' => 'wx6470b69abdf65e06',
            // payment
            'payment' => [
                'merchant_id'        => '1383659202',
                'key'                => '2D2C5B0CDFA135D8FAB37227B0F569E5',
                'cert_path'          => '/wxpayment/apiclient_cert.pem', // XXX: 绝对路径！！！！
                'key_path'           => '/wxpayment/apiclient_key.pem',      // XXX: 绝对路径！！！！
                'notify_url'         => 'http://wztx.shp.api.ruitukeji.com/callback/wxpay_callback',       // 你也可以在下单时单独设置来想覆盖它
            ],
        ];
        $app = new Application($options);

        $response = $app->payment->handleNotify(function($notify, $successful){
            // 用户是否支付成功
            if ($successful) {
                $order_num=$notify['out_trade_no'];
                $where = ['order_code'=>$order_num];
                $statusdata = [
                    'status' => 'pay_success',
                    'payway' => 3,//0=未支付，1=余额，2=微信，3=支付宝，4-凭证通过
                    'is_pay' =>1,
                ];
                $transportLogic = model('TransportOrder','logic');
                $result = $transportLogic->updateTransport($where,$statusdata);
                $order_info = getTransportOrderInfo($where);//得到订单信息
                $this->payRecord(1,$order_info,$notify);//1支付成功->保存支付记录
                if($result['code'] == 2000){
                    //进行负责给推荐人分发奖金
                    returnJson(2000,'支付成功');
                }else{
                    returnJson(4000,'支付失败');
                }
            } else { // 用户支付失败
                returnJson(4000,'支付失败');
            }
        });
        $response->send();
    }

    /**
     * 验证消息是否是支付宝发出的合法消息
     * @param $data
     * @return bool
     */
    public function verify($data)
    {
        $pay=new alipay_mobile();

        // 生成签名结果
        $is_sign = $pay->getSignVeryfy($data, $data['sign']);

        // 获取支付宝远程服务器ATN结果（验证是否是支付宝发来的消息）
        $response_txt = 'true';

        if (!empty($data['notify_id'])) {
            $response_txt = $pay->getResponse($data['notify_id']);
        }
        // 验证
        // $response_txt的结果不是true，与服务器设置问题、合作身份者ID、notify_id一分钟失效有关
        // isSign的结果不是true，与安全校验码、请求时的参数格式（如：带自定义参数等）、编码格式有关
        if (preg_match('/true$/i', $response_txt) && $is_sign) {
            return true;
        } else {
            return false;
        }
    }

    /*
     * 进行存入sp_pay_order表里 付款记录
     */
    public function payRecord($status,$order_info,$data){
        //需要进行存入sp_pay_order表里
        $data = [
            'sp_id' =>$order_info['sp_id'],
            'order_id' => $order_info['order_id'],
            'trade_no' =>$data['trade_no'],//支付宝交易号
            'total_amount' =>$data['total_amount'],
            'real_amount' =>$data['receipt_amount'],
            'merchant_orderid' =>$data['out_trade_no'],//当前的订单code
            'pay_orderid' =>order_num(),
            'pay_time' =>time(),
            'pay_way' =>1,//1=支付宝，2=微信
            'pay_status' =>$status,
        ];
        //进行保存
        $result = model('SpPayOrder','logic')->savePayOrder($data);
        if($result['code'] == 4000){
            returnJson($result);
        }
    }
}