<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/7/30
 * Time: 10:30
 */

namespace app\api\logic;

class SpMarginOrder extends BaseLogic{

    /**
     * Auther: guanshaoqiu <94600115@qq.com>
     * Describe:保存保证金订单
     */
    public function saveMarginOrder($data){
        $result = $this->allowField(true)->save($data);
        if($result > 0){
            return resultArray(2000,'添加成功');
        }else{
            return resultArray(4000,'添加失败');
        }
    }
}