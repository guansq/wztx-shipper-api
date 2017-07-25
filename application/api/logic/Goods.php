<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/7/23
 * Time: 12:18
 */
namespace app\api\logic;

class Goods extends BaseLogic {

    protected $table = 'rt_goods';
    /**
     * Auther: guanshaoqiu <94600115@qq.com>
     * Describe: 保存货源信息
     */
    public function saveGoodsInfo($param) {
        //$param['system_price'] = '2017.02';
        //$param['order_code'] = order_num();
        $ret = $this->allowField(true)->save($param);
        if ($ret > 0) {
            $goods_id = $this->getLastInsID();
            return resultArray(2000, '成功', ['goods_id' => $goods_id]);
        }
        return resultArray(4000, '保存订单失败');
    }

    /**
     * Auther: guanshaoqiu <94600115@qq.com>
     * Describe: * @param $where
     * @param $data
     * 更改订单信息
     */
    public function updateGoodsInfo($where, $data) {
        $ret = $this->where($where)->update($data);
        if ($ret === false) {
            return resultArray(4000, '更改货源状态失败');
        }
        return resultArray(2000, '更改货源状态成功');
    }

}