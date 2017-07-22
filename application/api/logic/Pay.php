<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/7/14
 * Time: 15:26
 */

namespace app\api\logic;

use think\Db;

class Pay extends BaseLogic {
    //获取订单详情
    public function getRechargeRecordList($where, $pageParam) {
        $dataTotal = Db::name('SpRechargeOrder')->where($where)->order('create_at desc')->count();
        if (empty($dataTotal)) {
            return false;
        }
        $list = Db::name('SpRechargeOrder')->where($where)->order('create_at desc')->page($pageParam['page'], $pageParam['pageSize'])
            ->field('id,sp_id,type,name,phone,real_amount,balance,pay_time,pay_way,pay_status')->select();
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