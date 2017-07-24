<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/7/7
 * Time: 9:59
 */

namespace app\api\controller;

class Pay extends BaseController {
    /**
     * @api {GET} /pay 我的钱包done
     * @apiName index
     * @apiGroup Pay
     * @apiHeader {String} authorization-token      token.
     * @apiSuccess {String} balance         账户余额
     * @apiSuccess {String} bonus         我的推荐奖励
     */
    public function index() {
        $spBaseInfo = model('SpBaseInfo', 'logic')->findInfoByUserId($this->loginUser['id']);
        returnJson('2000', '成功', ['balance' => wztxMoney($spBaseInfo['balance']), 'bonus' => wztxMoney($spBaseInfo['bonus'])]);
    }

    /*
     * @api {POST} /pay/payBond  缴纳保证金
     * @apiName payBond
     * @apiGroup Pay
     * @apiHeader {String} authorization-token      token.
     * @apiParam  {String}      amount                     提现金额
     * @apiParam  {Int}         deposit_name                  银行名称
     * @apiSuccess {String}     account               收款账号
     * @apiSuccess {String}     real_name            开户名称
     */
    public function payBond() {

    }

    /**
     * @api {POST} /pay/recharge  充值
     * @apiName recharge
     * @apiGroup Pay
     * @apiHeader {String} authorization-token      token.
     * @apiParam  {String}  real_amount              充值金额
     * @apiParam  {Int}    pay_way                  支付方式 1=支付宝，2=微信
     * @apiSuccess {Array} pay_info                 支付返回信息
     */
    public function recharge() {

    }

    /**
     * @api {POST}  /pay/showPayRecord 查看账单done
     * @apiName showPayRecord
     * @apiGroup Pay
     * @apiHeader {String} authorization-token          token.
     * @apiParam {Number} [page=1]                      页码.
     * @apiParam {Number} [pageSize=20]                 每页数据量.
     * @apiParam    {Int}    is_pay                     是否支付1为已支付 0为未支付
     * @apiSuccess {Array}   list                       账单列表
     * @apiSuccess {String}   list.order_id             订单ID
     * @apiSuccess {String}   list.dr_name              司机姓名
     * @apiSuccess {String}   list.org_city             发货地址
     * @apiSuccess {String}   list.dest_city            收货地址
     * @apiSuccess {String}   list.final_price          运价
     * @apiSuccess {String}   list.pay_time             订单完成时间
     * @apiSuccess {String}   list.usecar_time          用车时间
     * @apiSuccess  {Int}     list.is_pay               是否支付1为已支付 0为未支付
     * @apiSuccess  {String}  list.status               photo 拍照完毕（订单已完成） sucess(完成后的所有状态)pay_failed（支付失败）/pay_success（支付成功）comment（已评论）
     * @apiSuccess {Number} page                        页码.
     * @apiSuccess {Number} pageSize                    每页数据量.
     * @apiSuccess {Number} dataTotal                   数据总数.
     * @apiSuccess {Number} pageTotal                   总页码数.
     */
    public function showPayRecord() {
        $paramAll = $this->getReqParams([
            'is_pay',
        ]);
        $rule = [
            'is_pay' => ['require', '/^(0|1)$/'],
        ];

        validateData($paramAll, $rule);
        $where['status'] = ['in', ['photo', 'pay_failed', 'pay_success', 'comment']];
        $where['is_pay'] = $paramAll['is_pay'];
        $where['sp_id'] = $this->loginUser['id'];
        $pageParam = $this->getPagingParams();
        $orderInfo = model('TransportOrder', 'logic')->getTransportOrderList($where, $pageParam);
        if (empty($orderInfo)) {
            returnJson('4004', '暂无订单信息');
        }
        $list = [];
        foreach ($orderInfo['list'] as $k => $v) {
            $list[$k]['order_id'] = $v['id'];
            $list[$k]['org_city'] = $v['org_city'];
            $list[$k]['dest_city'] = $v['dest_city'];
            if (!empty($v['dr_id'])) {
                $drBaseInfo = model('DrBaseInfo', 'logic')->findInfoByUserId($v['dr_id']);
                $dr_real_name = $drBaseInfo['real_name'];
            }else{
                $dr_real_name = '';
            }
            $list[$k]['dr_name'] = $dr_real_name;
            $list[$k]['final_price'] = wztxMoney($v['final_price']);
            $list[$k]['pay_time'] = wztxDate($v['pay_time']);
            $list[$k]['usecar_time'] = wztxDate($v['usecar_time']);
            $list[$k]['is_pay'] = $v['is_pay'];
            $list[$k]['status'] = $v['status'];
        }
        $orderInfo['list'] = $list;
        returnJson('2000', '成功', $orderInfo);
    }

    /**
     * @api {POST} /pay/rechargeRecord  充值记录done
     * @apiName rechargeRecord
     * @apiGroup Pay
     * @apiHeader {String} authorization-token      token.
     * @apiParam {Number} [page=1]                  页码.
     * @apiParam {Number} [pageSize=20]             每页数据量.
     * @apiSuccess  {Array}     list                     充值记录列表
     * @apiSuccess  {String}    list.real_amount              充值金额
     * @apiSuccess  {Int}       list.pay_way                  支付方式 1=支付宝，2=微信
     * @apiSuccess  {String}    list.pay_time                  支付时间
     * @apiSuccess  {Int}       list.pay_status               支付状态 0=未支付，1=支付成功，2=支付失败
     * @apiSuccess {Number} page                页码.
     * @apiSuccess {Number} pageSize            每页数据量.
     * @apiSuccess {Number} dataTotal           数据总数.
     * @apiSuccess {Number} pageTotal           总页码数.
     */
    public function rechargeRecord() {
        $where['sp_id'] = $this->loginUser['id'];
        $where['type'] = $this->loginUser['type'];
        $pageParam = $this->getPagingParams();
        $recordInfo = model('Pay', 'logic')->getRechargeRecordList($where, $pageParam);
        if (empty($recordInfo)) {
            returnJson('4004', '暂无订单信息');
        }
        $list = $recordInfo['list'];

        foreach ($list as $k => $v) {
            $list[$k]['real_amount'] = wztxMoney($v['real_amount']);
            $list[$k]['balance'] = wztxMoney($v['balance']);
            $list[$k]['pay_time'] = wztxDate($v['pay_time']);
        }
        $recordInfo['list'] = $list;
        returnJson('2000', '成功', $recordInfo);
    }

}