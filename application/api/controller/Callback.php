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
        $data=input('param.');
        if(empty($data)){
            exit('error');
        }
//        $json='{"total_amount":"0.01","buyer_id":"2088612334436741","trade_no":"2016093021001004740240031489","body":"441524","notify_time":"2016-09-30 16:29:43","subject":"fdsa","sign_type":"RSA","notify_type":"trade_status_sync","out_trade_no":"2016093052531015","trade_status":"TRADE_SUCCESS","gmt_payment":"2016-09-30 16:25:52","sign":"E8T\/SRw4TRjamiPI7RyfSHWEJCKwFAbEtfI88Z8TXa+YDhvuqzkrFb8eQT\/1nRWa156QTD7Q6Lp4ug0+aMjsFyGv7TnWB2scrCQGUDYC\/MXCZrr0o0u+g87Od5MMN+u4f5yQqlb7jOLHkExwjuMxO\/fCrAx8QzZpQcPsEWrZ4ME=","gmt_create":"2016-09-30 16:25:52","app_id":"2016082901818372","seller_id":"2088421610505604","notify_id":"642078cfdefe79319a857018157eb54lpm"}';
//        $data=json_decode($json,true);
//        dump($data);exit;
        $pay=new alipay_mobile();
        // 生成签名结果
        $is_sign = $pay->getSignVeryfy($data, $data['sign']);
        if($is_sign){
            if($data['trade_status'] == 'TRADE_SUCCESS'){
                $order_num=$data['out_trade_no'];
                $model=model('common/Order');
                if($model->pay_order($order_num,1)){
                    exit('success');
                }else{
                    exit('error');
                }
            }else{
                exit('error');
            }
        }else{
            exit('error');
        }

//        logResult(json_encode($data));
//        logResult(input('param.sign'));
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
                'notify_url'         => 'http://api.lvjicut.com/callback/wxpay_callback',       // 你也可以在下单时单独设置来想覆盖它
            ],
        ];
        $app = new Application($options);
        $response = $app->payment->handleNotify(function($notify, $successful){
            // 用户是否支付成功
            if ($successful) {
                $order_num=$notify['out_trade_no'];
                $model=model('common/Order');
                if($model->pay_order($order_num,2)){
                    return true;
                }else{
                    return 'error';
                }
            } else { // 用户支付失败
                return 'error';
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
}