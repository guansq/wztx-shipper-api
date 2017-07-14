<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/7/14
 * Time: 15:26
 */

namespace app\api\logic;

class TransportOrder extends BaseLogic{

    /**
     * Auther: guanshaoqiu <94600115@qq.com>
     * Describe:
     */
    public function saveTransportOrder($param){
        //$param['system_price'] = '2017.02';
        $ret = $this->allowField(true)->save($param);
        if($ret > 0){
            $order_id = $this->getLastInsID();
            return resultArray(2000,'成功',['order_id'=>$order_id]);
        }
        return resultArray(4000,'保存订单失败');
    }
}