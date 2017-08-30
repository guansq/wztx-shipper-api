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
            'org_address_maps' => 'require|max:60',
            'org_city' => 'require|max:30',
            'org_address_name' => 'require|max:100',
            'org_address_detail' => 'max:100',
            'org_send_name' => 'require|max:30',
            'org_phone' => ['require', 'regex' => '/^[1]{1}[3|5|7|8]{1}[0-9]{9}$/'],
            'org_telphone' => 'max:30',
            'dest_receive_name' => 'require|max:30',
            'dest_address_maps' => 'require|max:60',
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
    /**
     * @api     {POST}  goods/goodsList             显示货源列表
     * @apiName     goodsList
     * @apiGroup    Goods
     * @apiHeader   {String} authorization-token    token
     * @apiParam  {String}  type                  货源类型 quote报价中 quoted已报价
     */
    public function goodsList(){
        $paramAll = $this->getReqParams(['type']);
        $rule = [
            'type' => ['require', '/^(all|quote|quoted)$/'],
        ];
        validateData($paramAll, $rule);

        if(!ispassAuth($this->loginUser)){//判断用户是否缴纳保证金
            returnJson([4000,'抱歉您还未缴纳保证金，或认证通过']);
        }
        $where = [
            'sp_id' => $this->loginUser['id'],
            'is_cancel' => 0
        ];
        if ($paramAll['type'] != 'all') {
            $where['status'] = $paramAll['type'];
        }
        $pageParam = $this->getPagingParams();

        $goodsList = model('Goods','logic')->getGoodsList($where,$pageParam);

        if (empty($goodsList)) {
            returnJson(4004, '暂无货源信息');
        }
        $list = [];
        foreach ($goodsList['list'] as $k =>$v){
            $list[$k]['goods_id'] = $v['id'];
            $list[$k]['org_city'] = $v['org_city'];
            $list[$k]['dest_city'] = $v['dest_city'];
            $list[$k]['weight'] =strval($v['weight']);
            $list[$k]['goods_name'] = $v['goods_name'];
            $list[$k]['status'] = $v['status'];
            $list[$k]['car_style_length'] = $v['car_style_length'];
            $list[$k]['car_style_type'] =$v['car_style_type'];
            $list[$k]['is_quote'] = isQuote($v['id']);
        }
        $goodsList['list'] = $list;
        returnJson(2000, '成功', $goodsList);
    }

    /**
     * @api {POST}  goods/cancelGoods       取消货源功能
     * @apiName     cancelGoods
     * @apiGroup    Goods
     *
     * @apiHeader   {String}    authorization-token    token
     * @apiParam    {Number}    goods_id        货源ID
     */
    public function cancelGoods(){
        $paramAll = $this->getReqParams(['goods_id']);
        $rule = [
            'goods_id' => 'require'
        ];
        validateData($paramAll,$rule);
        $ret = model('Goods','logic')->cancelGoods(['id'=>$paramAll['goods_id'],'sp_id'=>$this->loginUser['id']]);
        if(!$ret){
            returnJson(4000,'取消货源状态失败');
        }
        returnJson(2000,'成功');
    }

    /**
     * @api     {GET}  /goods/detail            货源详情done
     * @apiName detail
     * @apiGroup Goods
     * @apiHeader {String} authorization-token           token.
     * @apiParam    {Int}    id                 货源ID
     * @apiSuccess  {String} goods_name         货品名称
     * @apiSuccess  {String} weight             重量
     * @apiSuccess  {String} org_city           起始地
     * @apiSuccess  {String} dest_city          目的地
     * @apiSuccess  {String} dest_receive_name  收货人姓名
     * @apiSuccess  {String} dest_phone         收货人电话
     * @apiSuccess  {String} dest_address_name  收货人地址
     * @apiSuccess  {String} dest_address_detail收货人地址详情
     * @apiSuccess  {String} org_send_name      寄件人姓名
     * @apiSuccess  {String} org_phone          寄件人电话
     * @apiSuccess  {String} org_address_name   寄件人地址
     * @apiSuccess  {String} org_address_datail 寄件人地址详情
     * @apiSuccess  {String} usecar_time        用车时间
     * @apiSuccess  {String} send_time          发货时间
     * @apiSuccess  {String} arr_time           到达时间
     * @apiSuccess  {String} real_name          车主姓名
     * @apiSuccess  {String} phone              联系电话
     * @apiSuccess  {String} policy_code        保单编号
     * @apiSuccess  {Int} is_pay                是否支付1为已支付 0为未支付
     * @apiSuccess  {String} is_receipt         货物回单1-是-默认，2-否
     * @apiSuccess  {String} system_price       系统出价
     * @apiSuccess  {String} mind_price         货主出价
     * @apiSuccess  {String} final_price        总运费
     * @apiSuccess  {String} effective_time      在途时效
     * @apiSuccess  {String} remark              备注
     */
    public function detail() {
        $paramAll = $this->getReqParams([
            'id',
        ]);
        $rule = [
            'id' => ['require', 'regex' => '^[0-9]*$'],
        ];

        validateData($paramAll, $rule);
        //'dr_id' => $this->loginUser['id'],
        $goodsInfo = model('Goods', 'logic')->getGoodsInfo([ 'id' => $paramAll['id']]);
        if (empty($goodsInfo)) {
            returnJson('4004', '未获取到货源信息');
        }
        if ($goodsInfo['dr_id']) {
            $drBaseInfo = model('DrBaseInfo', 'logic')->findInfoByUserId($this->loginUser['id']);
            $dr_phone = $drBaseInfo['phone'];
            $dr_real_name = $drBaseInfo['real_name'];
        } else {
            $dr_phone = '';
            $dr_real_name = '';
        }

        $detail = [
            'status' => $goodsInfo['status'],
            'goods_name' => $goodsInfo['goods_name'],
            'weight' => strval($goodsInfo['weight']),
            'org_city' => $goodsInfo['org_city'],
            'dest_city' => $goodsInfo['dest_city'],
            'dest_receive_name' => $goodsInfo['dest_receive_name'],
            'dest_phone' => $goodsInfo['dest_phone'],
            'dest_address_name' => $goodsInfo['dest_address_name'],
            'dest_address_detail' => $goodsInfo['dest_address_detail'],
            'org_send_name' => $goodsInfo['org_send_name'],
            'org_phone' => $goodsInfo['org_phone'],
            'org_address_name' => $goodsInfo['org_address_name'],
            'org_address_detail' => $goodsInfo['org_address_detail'],
            'usecar_time' => wztxDate($goodsInfo['usecar_time']),
            'real_name' => $dr_real_name,
            'phone' => $dr_phone,
            'policy_code' => $goodsInfo['policy_code'],
            'is_pay' => $goodsInfo['is_pay'],
            'is_receipt' => $goodsInfo['is_receipt'],
            'system_price' => wztxMoney($goodsInfo['system_price']),
            'mind_price' => wztxMoney($goodsInfo['mind_price']),
            'final_price' => wztxMoney($goodsInfo['final_price']),
            'effective_time' => $goodsInfo['effective_time'],
            'remark' => $goodsInfo['remark']
        ];
        returnJson('2000', '成功', $detail);
    }
}