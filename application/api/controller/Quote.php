<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/7/11
 * Time: 17:14
 */
namespace app\api\controller;

use think\Request;

class Quote extends BaseController{
    /**
     * @api {POST}  /order/showDriverQuoteList      显示司机报价列表
     * @apiName     showDriverQuoteList
     * @apiGroup    Quote
     * @apiHeader   {String}    authorization-token     token.
     * @apiParam    {Int}    order_id        订单ID
     * @apiSuccess  {Array}  list            报价列表
     * @apiSuccess  {String} list.quote_id        报价ID
     * @apiSuccess  {String} list.driver_id       司机ID
     * @apiSuccess  {String} list.avatar          司机头像
     * @apiSuccess  {String} list.score           司机评分
     * @apiSuccess  {String} list.car_type        司机车型
     * @apiSuccess  {String} list.car_length      司机车长
     * @apiSuccess  {String} list.card_number     车牌号码
     * @apiSuccess  {String} list.quote_price     报价
     */
    public function showDriverQuoteList(){

    }

    /**
     * @api {POST}  /order/sendDriverPrice      提交司机报价
     * @apiName     sendDriverPrice
     * @apiGroup    Quote
     * @apiHeader   {String}    authorization-token     token.
     * @apiParam  {String} quote_id        报价ID
     * @apiParam  {String} driver_id       司机ID
     * @apiParam  {String} order_id        订单ID
     * @apiParam  {String} quote_price     报价
     */
    public function sendDriverPrice(){

    }

}