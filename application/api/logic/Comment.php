<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/7/14
 * Time: 15:26
 */

namespace app\api\logic;

class Comment extends BaseLogic{

    /**
     * Describe: 保存订单评论信息
     */
    public function saveOrderComment($param){
        $ret = $this->allowField(true)->save($param);
        if($ret > 0){
            $comment_id = $this->getLastInsID();
            return resultArray(2000,'成功',['comment_id'=>$comment_id]);
        }
        return resultArray(4000,'保存订单评论失败');
    }

    /**
     * 得到单个订单评论信息
     */
    public function getOrderCommentInfo($where){
        $ret = $this->where($where)->field("order_id,sp_id,sp_name,dr_id,dr_name,post_time,limit_ship,attitude,satisfaction,content,status")->find();
        if($ret){
            return resultArray(2000,'成功',$ret);
        }
        return resultArray(4000,'未获取到订单信息');
    }
}