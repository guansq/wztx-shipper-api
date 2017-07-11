<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/7/7
 * Time: 9:57
 */
namespace app\api\controller;

class Recommend extends BaseController{
    /**
     * @api {GET}   recommend/showMyRecommInfo      显示我的推荐信息
     * @apiName     showMyRecommInfo
     * @apiGroup    Recommend
     * @apiHeader   {String}    authorization-token         token.
     * @apiSuccess  {String}    code            推荐码
     *
     */
    public function showMyRecommInfo(){

    }


    /**
     * @api {GET}   recommend/showMyRecommList      显示我的推荐列表
     * @apiName     showMyRecommList
     * @apiGroup    Recommend
     * @apiHeader   {String}    authorization-token         token.
     * @apiSuccess  {Array}     list                        列表
     * @apiSuccess  {String}    list.avatar                 被推荐人头像
     * @apiSuccess  {String}    list.name                   被推荐人名称
     * @apiSuccess  {String}    list.bonus                 奖励金
     */
    public function showMyRecommList(){

    }
}