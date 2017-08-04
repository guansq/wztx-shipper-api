<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/7/23
 * Time: 12:15
 */
namespace app\api\controller;
use think\Request;

use service\MapService;
use DesUtils\DesUtils;

class Goods extends BaseController{
    /**
     * @api {POST}  /goods/addGoods      提交货源信息done
     * @apiName     addGoods
     * @apiGroup    Goods
     *
     * @apiHeader {String}  authorization-token     token
     * @apiParam  {String}  type=often                    often-实时 urgent-加急 appoint-预约
     * @apiParam  {String}  [appoint_at]                  预约时间
     * @apiParam  {String}  [premium_amount]                  保费金额
     * @apiParam  {String}  [insured_amount]                  保险金额
     * @apiParam  {String}  org_address_maps              出发地地址的坐标 如116.480881,39.989410
     * @apiParam  {String}  org_city                      出发地省市区
     * @apiParam  {String}  org_address_name              出发地名称
     * @apiParam  {String}  [org_address_detail]          出发地详情
     * @apiParam  {String}  org_send_name                 发货人姓名
     * @apiParam  {String}  org_phone                     发货人手机
     * @apiParam  {String}  [org_telphone]                  发货人电话
     * @apiParam  {String}  dest_receive_name             收货人姓名
     * @apiParam  {String}  dest_address_maps             目的地址的坐标 如116.480881,39.989410
     * @apiParam  {String}  dest_city                     到达城市
     * @apiParam  {String}  dest_address_name             目的地名称
     * @apiParam  {String}  dest_address_detail           目的地详情
     * @apiParam  {String}  dest_phone                    收货人手机
     * @apiParam  {String}  [dest_telphone]                 收货人电话
     * @apiParam  {String}  goods_name                    货物名称
     * @apiParam  {String}  volume                        总体积（立方米）
     * @apiParam  {String}  weight                        总重量（吨）
     * @apiParam  {String}  car_style_type                车型名称-对应car_style里name
     * @apiParam  {String}  car_style_type_id             车型-对应car_style里id
     * @apiParam  {String}  car_style_length              车长-对应car_style里name
     * @apiParam  {String}  car_style_length_id           车长-对应car_style里id
     * @apiParam  {String}  [effective_time]              在途时效（分钟）
     * @apiParam  {String}  is_receipt                    货物回单1-是-默认，2-否
     * @apiParam  {String}  [mind_price]                  心理价位
     * @apiParam  {String}  system_price                  系统价
     * @apiParam  {String}  remark                        备注
     * @apiParam  {String}  tran_type                     0=短途1=长途
     * @apiParam  {String}  kilometres                    公里数
     * @apiParam  {String}  [usecar_time]                 用车时间
     * @apiSuccess {String} goods_id                      货源ID
     */
    public function addGoods() {
        $paramAll = $this->getReqParams([
            'type',
            'appoint_at',
            'premium_amount',
            'insured_amount',
            'org_address_maps',
            'org_city',
            'org_address_name',
            'org_address_detail',
            'org_send_name',
            'org_phone',
            'org_telphone',
            'dest_receive_name',
            'dest_address_maps',
            'dest_city',
            'dest_address_name',
            'dest_address_detail',
            'dest_phone',
            'dest_telphone',
            'goods_name',
            'volume',
            'weight',
            'car_style_type',
            'car_style_type_id',
            'car_style_length',
            'car_style_length_id',
            'effective_time',
            'is_receipt',
            'mind_price',
            'system_price',
            'remark',
            'tran_type',
            'kilometres',
            'usecar_time'
        ]);
        $rule = [
            'type' => ['require', '/^(often|urgent|appoint)$/'],
            'appoint_at' => 'max:30',
            'premium_amount' => 'max:30',
            'insured_amount' => 'max:30',
            'org_address_maps' => 'require|max:30',
            'org_city' => 'require|max:30',
            'org_address_name' => 'require|max:100',
            'org_address_detail' => 'max:100',
            'org_send_name' => 'require|max:30',
            'org_phone' => ['require', 'regex' => '/^[1]{1}[3|5|7|8]{1}[0-9]{9}$/'],
            'org_telphone' => 'max:30',
            'dest_receive_name' => 'require|max:30',
            'dest_address_maps' => 'require|max:30',
            'dest_city' => 'require|max:30',
            'dest_address_name' => 'require|max:100',
            'dest_address_detail' => 'max:100',
            'dest_phone' => ['require', 'regex' => '/^[1]{1}[1|3|5|7|8]{1}[0-9]{9}$/'],
            'dest_telphone' => 'max:30',
            'goods_name' => 'require|max:30',
            'volume' => 'require|max:20',
            'weight' => 'require|max:20',
            'car_style_type' => 'require|max:30',
            'car_style_type_id' => 'require|max:30',
            'car_style_length' => 'require|max:30',
            'car_style_length_id' => 'require|max:30',
            'effective_time' => 'max:30',
            'is_receipt' => ['require', 'regex' => '/^(1|2)$/'],
            'mind_price' => 'max:20',
            'system_price' => 'require|max:30',
            'remark' => 'max:200',
            'kilometres' => 'require|max:50',
            'tran_type' => ['require', 'regex' => '/^(0|1)$/'],
            'usecar_time' => 'max:30'
        ];
        validateData($paramAll, $rule);
        //验证是否缴纳保证金
        $baseUserInfo = model('SpBaseInfo', 'logic')->getBaseUserInfo($this->loginUser);
        //保证金状态(init=未缴纳，checked=已缴纳,frozen=冻结) bond_status
        //认证状态（init=未认证，check=认证中，pass=认证通过，refuse=认证失败，delete=后台删除） auth_status
        if ($baseUserInfo['bond_status'] != 'checked' || $baseUserInfo['auth_status'] != 'pass') {
            returnJson(4000, '认证状态或保证金状态不合法');
        }

        //计算保费金额
        if (isset($paramAll['premium_amount']) && !empty($paramAll['premium_amount'])) {
            $paramAll['premium_amount'] = wztxMoney($paramAll['premium_amount']);
            $insured_amount = wztxMoney($paramAll['premium_amount'] / (getSysconf('premium_rate') / 100));//得到总保额
            $paramAll['insured_amount'] = wztxMoney($paramAll['insured_amount']);
            if ($insured_amount != $paramAll['insured_amount']) {
                returnJson(4022, '投保金额不一致');
            }
        }

        //计算系统价  如果公里数在起步价内 按起步价来算 如果超出公里数 起步价格+(当前公里-起步公里)*超出每公里价格数+重量*公里数*运费 车长ID（取出）
        $carInfo = model('Car', 'logic')->findCarInfoById($paramAll['car_style_length_id']);
        if ($paramAll['kilometres'] <= $carInfo['init_kilometres']) {
            $systemPrice = $carInfo['init_price'];
        } else {
            $init_price = $carInfo['init_price'];//起步价

            $beyond_kilo = $paramAll['kilometres'] - $carInfo['init_kilometres'];//超出公里

            $beyond_price = $beyond_kilo * $carInfo['over_metres_price'] + $paramAll['weight'] * $carInfo['weight_price'] * $beyond_kilo;//超出公里价格
            $systemPrice = $init_price + $beyond_price;
        }
        //echo $systemPrice.'<br>';
        //echo $paramAll['system_price'];
        //die;
        //echo $paramAll['system_price'];
        //echo '<br>';
        //echo wztxMoney($paramAll['system_price']);die;
        $systemPrice = wztxMoney($systemPrice);
        $paramAll['system_price'] = wztxMoney($paramAll['system_price']);
        if ($systemPrice != $paramAll['system_price']) {
            returnJson(4022, '系统价格不一致');
        }
        //完善个人信息填写  sp_id
        $paramAll['sp_id'] = $baseUserInfo['id'];
        $paramAll['real_name'] = $baseUserInfo['real_name'];
        $paramAll['company_name'] = getCompanyName($this->loginUser);
        $paramAll['customer_type'] = $baseUserInfo['type'];
        $address = explode(',',$paramAll['org_address_maps']);
        $paramAll['org_longitude'] = $address[0];
        $paramAll['org_latitude'] = $address[1];
        $address = explode(',',$paramAll['dest_address_maps']);
        $paramAll['dest_longitude'] = $address[0];
        $paramAll['dest_latitude'] = $address[1];
        //没有问题存入数据库
        $ret = model('Goods', 'logic')->saveGoodsInfo($paramAll);
        if($ret['code'] == 4000){
            returnJson($ret);
        }
        //进行派单
        action('Quote/sendOrder',[$ret['result']['goods_id'],$paramAll['org_address_maps']]);
    }
}