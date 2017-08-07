<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/7/26
 * Time: 15:55
 */
namespace app\api\logic;
use think\Db;

class SpPayOrder extends BaseLogic{
    /**
     * Auther: guanshaoqiu <94600115@qq.com>
     * Describe: 保存付款订单列表
     */
    public function savePayOrder($param) {
        $ret = $this->allowField(true)->save($param);
        if ($ret > 0) {
            $order_id = $this->getLastInsID();
            return resultArray(2000, '成功');
        }
        return resultArray(4000, '保存订单失败');
    }
}