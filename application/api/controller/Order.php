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
     * @apiParam  {String}  org_city                      出发地省市区
     * @apiParam  {String}  org_address_name              出发地名称+出发地详细名称
     * @apiParam  {String}  start_address_name            出发地-地点名称
     * @apiParam  {String}  start_address_detail          出发地-详细名称
     * @apiParam  {String}  start_name                    出发地-发货人
     * @apiParam  {String}  start_phone                   出发地-手机号
     * @apiParam  {String}  start_telephone               出发地-电话号码
     * @apiParam  {String}  dest_address_maps             目的地地址的坐标 如116.480881,39.989410
     * @apiParam  {String}  dest_city                     目的地省市区
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
     * @apiParam  {String}  is_receipt                    货物回单1-是-默认，2-否
     */
    public function add(){

    }


    /**
     * @api {POST}  /order/showOrderInfo      显示订单详情
     * @apiName     showOrderInfo
     * @apiGroup    Order
     * @apiParam    {Int}    order_id           订单ID
     * @apiSuccess  {String} status             init 初始状态（未分发订单前）quote报价中（分发订单后）quoted已报价-未配送（装货中）distribute配送中（在配送-未拍照）发货中 photo 拍照完毕（订单已完成）pay_failed（支付失败）/pay_success（支付成功）comment（已评论）
     * @apiSuccess  {String} order_code         订单号
     * @apiSuccess  {String} goods_name         货品名称
     * @apiSuccess  {String} weight             重量
     * @apiSuccess  {String} org_address_name   起始地
     * @apiSuccess  {String} dest_address_name  目的地
     * @apiSuccess  {String} dest_receive_name  收货人姓名
     * @apiSuccess  {String} dest_phone         收货人电话
     * @apiSuccess  {String} dest_address       收货人地址
     * @apiSuccess  {String} org_send_name      寄件人姓名
     * @apiSuccess  {String} org_phone          寄件人电话
     * @apiSuccess  {String} org_address        寄件人地址
     * @apiSuccess  {String} usecar_time        用车时间
     * @apiSuccess  {String} send_time          发货时间
     * @apiSuccess  {String} arr_time           到达时间
     * @apiSuccess  {String} real_name          车主姓名
     * @apiSuccess  {String} phone              联系电话
     * @apiParam    {String} is_receipt          货物回单1-是-默认，2-否
     * @apiSuccess  {String} final_price        总运费
     */
    public function showOrderInfo(){

    }

    /**
     * @api {POST}  /order/showOrderList      显示订单列表
     * @apiName     showOrderList
     * @apiGroup    Order
     * @apiParam   {String} type        订单状态（quote报价中，quoted已报价，待发货 distribute配送中（在配送-未拍照）发货中 photo 拍照完毕（订单已完成））
     * @apiSuccess {Array}  list        订单列表
     * @apiSuccess {String} list.org_address_name        出发地名称
     * @apiSuccess {String} list.dest_address_name       目的地名称
     * @apiSuccess {String} list.weight                  货物重量
     * @apiSuccess {String} list.goods_name              货物名称
     * @apiSuccess {String} list.status init 初始状态（未分发订单前）quote报价中（分发订单后）quoted已报价-未配送（装货中）distribute配送中（在配送-未拍照）发货中 photo 拍照完毕（订单已完成）pay_failed（支付失败）/pay_success（支付成功）comment（已评论）
     */
    public function showOrderList(){

    }
    /**
     * @api {POST}  /order/showOrderList      显示司机报价列表
     * @apiName     showDriverQuoteList
     * @apiGroup    Order
     * @apiParam    {Int}    order_id        订单ID
     * @apiSuccess  {Array}  list            报价列表
     * @apiSuccess  {String} avatar          司机头像
     * @apiSuccess  {String} score           司机评分
     * @apiSuccess  {String} car_type        司机车型
     * @apiSuccess  {String} car_length      司机车长
     * @apiSuccess  {String} card_number     车牌号码
     * @apiSuccess  {String} quote_price     报价
     */
    public function showDriverQuoteList(){

    }

    /**
     * @api {POST}  /order/showCerPic      查看凭证
     * @apiName     showCerPic
     * @apiGroup    Order
     * @apiParam    {Int}    order_id        订单ID
     * @apiSuccess  {Array}  list            凭证列表
     */
    public function showCerPic(){

    }
}