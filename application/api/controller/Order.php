<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/7/7
 * Time: 10:30
 */
namespace app\api\controller;

class Order extends BaseController{

    /**
     * @api {POST}  /order/add      提交订单
     * @apiName     addOrder
     * @apiGroup    Order
     *
     * @apiHeader {String}  authorization-token     token
     * @apiParam  {String}  type=often                    often-实时 urgent-加急 appoint-预约
     * @apiParam  {String}  [appoint_at]                  预约时间
     * @apiParam  {String}  org_address_maps              出发地地址的坐标 如116.480881,39.989410
     * @apiParam  {String}  org_address_name              出发地名称+出发地详细名称
     * @apiParam  {String}  start_address_name            出发地-地点名称
     * @apiParam  {String}  start_address_detail          出发地-详细名称
     * @apiParam  {String}  start_name                    出发地-发货人
     * @apiParam  {String}  start_phone                   出发地-手机号
     * @apiParam  {String}  start_telephone               出发地-电话号码
     * @apiParam  {String}  dest_address_maps             目的地地址的坐标 如116.480881,39.989410
     * @apiParam  {String}  dest_address_name             目的地名称+目的地详细名称
     * @apiParam  {String}  arr_address_name              目的地-地点名称
     * @apiParam  {String}  arr_address_detail            目的地-详细名称
     * @apiParam  {String}  arr_name                      目的地-发货人
     * @apiParam  {String}  arr_phone                     目的地-手机号
     * @apiParam  {String}  arr_telephone                 目的地-电话号码
     * @apiParam  {String}  goods_name                    货物名称
     * @apiParam  {Float}   weight                        总重量（吨）保留3位小数点
     * @apiParam  {Float}   volume                        总体积（立方米）保留3位小数点
     * @apiParam  {String}  car_style_length              车辆要求-车长
     * @apiParam  {String}  car_style_type                车辆要求-车型
     * @apiParam  {String}  car_style_type                车辆要求-车型
     * @apiParam  {Float}   insured_amount                货物保险-投保金额 保留2位小数点
     * @apiParam  {Float}   premium_amount                货物保险-保费金额 保留2位小数点
     * @apiParam  {Int}     effective_time                在途时效,统一换算成分钟
     * @apiParam  {Float}   system_price                  系统价 保留2位小数点
     * @apiParam  {Float}   [mind_price]                  心理价位 保留2位小数点
     * @apiParam  {String}  [remark]                      备注
     */
    public function add(){

    }


    /**
     * @api {POST}  /order/showOrderInfo      显示订单详情
     * @apiName     showOrderInfo
     * @apiGroup    Order
     */
    public function showOrderInfo(){

    }

    /**
     * @api {POST}  /order/showOrderList      显示订单列表
     * @apiName     showOrderList
     * @apiGroup    Order
     */
    public function showOrderList(){

    }
}