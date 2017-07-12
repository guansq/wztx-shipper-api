<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/7/12
 * Time: 9:42
 */
namespace app\api\logic;

use jwt\JwtHelper;
use think\Db;

class SpBaseInfo extends BaseLogic{
    protected $table = 'rt_sp_base_info';

    /**
     * Auther: guanshaoqiu <94600115@qq.com>
     * Describe:通过用户ID获取相关信息
     */
    public function findInfoByUserId($user_id){
        return $this->where("user_id",$user_id)->find();
    }

    /**
     * Auther: guanshaoqiu <94600115@qq.com>
     * Describe:得到认证状态
     */
    public function getAuthStatus($user_id){
        return $this->where("user_id",$user_id)->value('auth_status');
    }

    /**
     * Auther: guanshaoqiu <94600115@qq.com>
     * Describe:保存个人验证信息
     */
    public function savePersonAuth($where,$data){
        $ret = $this->where($where)->update($data);
        if($ret === false){
            return resultArray('4020', '更新失败');
        }
        return resultArray('2000','更新成功');
    }

    /**
     * Auther: guanshaoqiu <94600115@qq.com>
     * Describe:
     */
    public function saveBusinessAuth(){

    }
}