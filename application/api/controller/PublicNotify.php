<?php

use Payment\Notify\PayNotifyInterface;
use Payment\Config;
/**
 * @author: helei
 * @createTime: 2016-07-20 18:31
 * @description:
 */

/**
 * 客户端需要继承该接口，并实现这个方法，在其中实现对应的业务逻辑
 * Class TestNotify
 * anthor helei
 */
class PublicNotify implements PayNotifyInterface
{
    public function notifyProcess(array $data)
    {
        $channel = $data['channel'];
        if ($channel === Config::ALI_CHARGE) {// 支付宝支付

        } elseif ($channel === Config::WX_CHARGE) {// 微信支付
            if($data['return_param'] == 'wx_recharge'){
                trace("进行微信充值操作记录");
                $pay_type_order = 'recharge';
                $order_num=$data['order_no'];//自家的订单CODE

                $where = ['order_code'=>$order_num];//
                $statusdata = [
                    'trade_no' => $data['transaction_id'],//第三方交易流水号
                    'pay_time'=>time(),
                    'pay_way' => 2,//0=未支付，1=支付宝，2=微信
                    'real_amount' => $data['amount'],
                    'pay_status' => 1,
                ];

                model('SpRechargeOrder','logic')->updateOrder($where,$statusdata);
                $order_info = model('SpRechargeOrder','logic')->getOrderInfo($where);
                //更新充值金额
                $baseInfo = getBaseSpUserInfo($order_info['sp_id']);
                trace(date('Y-m-d H:i:s',time()));
                trace($baseInfo);
                $balance = $baseInfo['balance'] + $data['amount'];//充值金额
                model('SpBaseInfo','logic')->updateUserBalance(['id'=>$order_info['sp_id']],['balance'=>$balance]);//更新账户信息
                //需要进行存入sp_pay_order表里
                $data = [
                    'sp_id' =>$order_info['sp_id'],
                    'order_id' => $order_info['order_code'],
                    'trade_no' =>$data['transaction_id'],//第三方交易号
                    'total_amount' =>$data['amount'],
                    'real_amount' =>$data['amount'],
                    'out_trade_no' =>$data['order_no'],//当前的订单code
                    'pay_action' =>$pay_type_order,
                    'pay_time' =>time(),
                    'pay_way' =>2,//1=支付宝，2=微信
                    'pay_status' =>1,
                ];
                //进行保存
                model('SpPayOrder','logic')->savePayOrder($data);
                return true;
            }
            //trace($data);

        } elseif ($channel === Config::CMB_CHARGE) {// 招商支付

        } elseif ($channel === Config::CMB_BIND) {// 招商签约

        } else {
            // 其它类型的通知
        }

        // 执行业务逻辑，成功后返回true
        return true;
    }

}
