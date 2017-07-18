<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/7/17
 * Time: 14:58
 */

namespace app\api\logic;
class DrBaseInfo extends BaseLogic{
    protected $table = 'rt_dr_base_info';
    public function getEnableDriver($where){
        return $this->where($where)->select();
    }
}