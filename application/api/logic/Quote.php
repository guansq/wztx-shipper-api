<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/7/17
 * Time: 18:22
 */

namespace app\api\logic;

class Quote extends BaseLogic{
    protected $table = 'rt_quote';

    /**
     * Auther: guanshaoqiu <94600115@qq.com>
     * Describe:保存报价信息
     */
    public function saveQuoteInfo($data){
        $ret = $this->allowField(true)->save($data);
        if($ret === false){
            returnJson('4020', '更新失败');
        }
        return $this->getLastInsID();
    }

    /**
     * Auther: guanshaoqiu <94600115@qq.com>
     * Describe:显示当前个人的报价列表
     */
    public function showQuoteList(){

    }
}