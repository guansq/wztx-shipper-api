<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/7/14
 * Time: 15:26
 */

namespace app\api\logic;

class TransportOrder extends BaseLogic {

    /**
     * Auther: guanshaoqiu <94600115@qq.com>
     * Describe: 保存订单信息
     */
    public function saveTransportOrder($param) {
        //$param['system_price'] = '2017.02';
        $param['order_code'] = order_num();
        $ret = $this->allowField(true)->save($param);
        if ($ret > 0) {
            $order_id = $this->getLastInsID();
            return resultArray(2000, '成功', ['order_id' => $order_id]);
        }
        return resultArray(4000, '保存订单失败');
    }

    /**
     * Auther: guanshaoqiu <94600115@qq.com>
     * Describe: * @param $where
     * 得到单个订单信息
     */
    public function getTransportOrderInfo($where) {
        $ret = $this->where($where)->find();
        return $ret;
    }

    /**
     * Auther: guanshaoqiu <94600115@qq.com>
     * Describe: * @param $where
     * @param $data
     * 更改订单信息
     */
    public function updateTransport($where, $data) {
        $ret = $this->where($where)->update($data);
        if ($ret === false) {
            return resultArray(4000, '更改订单状态失败');
        }
        return resultArray(2000, '更改订单状态成功');
    }

    //获取订单详情
    public function getTransportOrderList($where, $pageParam) {
        $dataTotal = $this->where($where)->order('create_at desc')->count();
        if (empty($dataTotal)) {
            return resultArray(4004);
        }
        $list = $this->where($where)->order('create_at desc')->page($pageParam['page'], $pageParam['pageSize'])->field('org_city,dest_city,weight,goods_name,status,car_style_length,car_style_type')->select();
        foreach ($list as $k =>$v){
            $v['weight'] =strval($v['weight']);
        }
        $ret = [
            'list' => $list,
            'page' => $pageParam['page'],
            'pageSize' => $pageParam['pageSize'],
            'dataTotal' => $dataTotal,
            'pageTotal' => intval(($dataTotal + $pageParam['pageSize'] - 1) / $pageParam['pageSize']),
        ];
        return $ret;
    }

}