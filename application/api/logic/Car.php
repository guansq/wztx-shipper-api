<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/7/13
 * Time: 15:28
 */
namespace app\api\logic;
use think\Db;
class Car extends BaseLogic{
    protected $table = 'rt_car_style';

    /**
     * Auther: guanshaoqiu <94600115@qq.com>
     * Describe:获取车型信息
     */
    public function getCarInfo($type){
        $where = [
            "type" => $type,
            "status" => 0
        ];
        $field = $type == 1 ? 'id,name' : 'id,name,over_metres_price,weight_price,init_kilometres,init_price';
        $ret = $this->field($field)->where($where)->select();
        if(!$ret){
            return resultArray('4000','数据为空');
        }
        return resultArray('2000','成功',$ret);
    }
}