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
    /**
     * Auther: guanshaoqiu <94600115@qq.com>
     * Describe:通过用户ID获取相关信息
     */
    public function findInfoByUserId($user_id){
        return $this->where("user_id",$user_id)->find();
    }


}