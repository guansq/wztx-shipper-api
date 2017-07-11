<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/7/11
 * Time: 16:51
 */
namespace app\api\controller;

use think\Request;

class Comment extends BaseController{
    /**
     * @api {GET}   /comment/commentInfo
     * @apiName     commentInfo
     * @apiGroup    Comment
     * @apiHeader   {String}    authorization-token     token.
     * @apiSuccess  {Number}    order_id                订单ID
     * @apiSuccess  {Number}    sp_id                   评论人ID
     * @apiSuccess  {String}    sp_name                 评价人的姓名
     * @apiSuccess  {Number}    dr_id                   司机ID
     * @apiSuccess  {String}    dr_name                 司机姓名
     * @apiSuccess  {String}    post_time               提交时间
     * @apiSuccess  {String}    limit_ship              发货时效几星
     * @apiSuccess  {String}    attitude                服务态度几星
     * @apiSuccess  {String}    satisfaction            满意度 几星
     * @apiSuccess  {String}    content                 评论文字
     * @apiSuccess  {Int}    status                  0=正常显示，1=不显示给司机
     */
    public function commentInfo(){

    }

    /**
     * @api {GET}   /comment/sendCommentInfo
     * @apiName     sendCommentInfo
     * @apiGroup    Comment
     * @apiHeader   {String}    authorization-token     token.
     * @apiParam    {Number}    sp_id                   评论人ID
     * @apiParam  {String}    sp_name                 评价人的姓名
     * @apiParam  {Number}    dr_id                   司机ID
     * @apiParam  {String}    dr_name                 司机姓名
     * @apiParam  {String}    post_time               提交时间
     * @apiParam  {String}    limit_ship              发货时效几星
     * @apiParam  {String}    attitude                服务态度几星
     * @apiParam  {String}    satisfaction            满意度 几星
     * @apiParam  {String}    content                 评论文字
     * @apiParam  {Int}    status                  0=正常显示，1=不显示给司机
     */
    public function sendCommentInfo(){

    }
}