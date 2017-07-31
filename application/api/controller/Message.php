<?php
/**
 * 采购单
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/5/12
 * Time: 9:55
 */

namespace app\api\controller;

use think\Request;

class Message extends BaseController {
    /**
     * @api      {GET} /message 我的消息-列表done
     * @apiName  index
     * @apiGroup Message
     * @apiHeader {String} [authorization-token]   token.
     *
     * @apiParam {String} [push_type=private]           消息类型. system=系统消息 private=私人消息
     * @apiParam {Number} [page=1]                  页码.
     * @apiParam {Number} [pageSize=20]             每页数据量.
     *
     * @apiSuccess {Array} list                 列表.
     * @apiSuccess {Number} list.id              消息ID.
     * @apiSuccess {String} list.type            客户端类型 0货主端 1司机端.
     * @apiSuccess {String} list.title           标题.
     * @apiSuccess {String} list.summary         摘要.
     * @apiSuccess {Number} list.isRead          是否阅读
     * @apiSuccess {String} list.pushTime        推送时间.
     * @apiSuccess {Number} page                页码.
     * @apiSuccess {Number} pageSize            每页数据量.
     * @apiSuccess {Number} dataTotal           数据总数.
     * @apiSuccess {Number} pageTotal           总页码数.
     * @apiSuccess {Number} unreadnum           未读消息.
     */
    public function index() {
        $paramAll = $this->getReqParams([
            'push_type',
        ]);
        $rule = [
            'push_type' => ['require', '/^(system|private)$/'],
        ];
        validateData($paramAll, $rule);
        $where = [];
        $where['push_type'] = $paramAll['push_type'];
        $where['id'] = empty($this->loginUser['id']) ? '' : $this->loginUser['id'];
        $pageParam = $this->getPagingParams();
        $ret = model('Message', 'logic')->getMyMessage($where, $pageParam);
        returnJson($ret);
    }


    /**
     * @api {GET} /message/detail      我的消息-详情done
     * @apiName detail
     * @apiGroup Message
     * @apiHeader {String} authorization-token   token.
     * @apiParam {Number} id          id.
     * @apiSuccess {Number} id              消息ID.
     * @apiSuccess {String} type            类型.
     * @apiSuccess {String} title           标题.
     * @apiSuccess {String} content         内容.
     * @apiSuccess {Number} isRead          是否阅读
     * @apiSuccess {String} pushTime        推送时间.
     */
    public function detail() {
        $paramAll = $this->getReqParams([
            'id',
        ]);
        $rule = [
            'id' => ['require', 'regex' => '^[0-9]*$'],
        ];

        validateData($paramAll, $rule);
        $ret = model('Message', 'logic')->getMyMsgDetail($paramAll['id'], $this->loginUser);
        returnJson($ret);
    }

    /**
     * @api {GET} /message/getUnRead     未读消息数量done
     * @apiName getUnRead
     * @apiGroup Message
     * @apiHeader {String} [authorization-token]   token.
     * @apiSuccess {Array} list                 列表.
     * @apiSuccess {String} list.name              名称.
     * @apiSuccess {Number} list.unread            未读数量.
     * @apiSuccess {String} list.icon_url           图标链接.
     * @apiSuccess {String} list.push_type         推送类型.
     * @apiSuccess {String} list.msg                列表文案.
     */
    public function getUnRead() {
        if (empty($this->loginUser)) {
            $privatetotal = 0;
            $privatemsg = '';
        } else {
            $privatetotal = model('Message', 'logic')->countUnreadMsg($this->loginUser);
            $privatemsg = model('Message', 'logic')->getUnreadMsg($this->loginUser, $privatetotal);
        }
        $systemtotal = model('Message', 'logic')->countSystemUnreadMsg($this->loginUser);
        $systemmsg = model('Message', 'logic')->getSystemUnreadMsg($this->loginUser, $systemtotal);
        $list = [
            [
                'name' => '系统消息',
                'unread' => $systemtotal,
                'icon_url' => '',
                'push_type' => 'system',
                'systemmsg' => $systemmsg
            ],
            [
                'name' => '私人消息',
                'unread' => $privatetotal,
                'icon_url' => '',
                'push_type' => 'private',
                'privatemsg' => $privatemsg
            ],
        ];
        returnJson(2000, '成功获取', ['list' => $list]);
    }

    /*
     * @api {GET} /message/onlineService      在线客服
     * @apiName onlineService
     * @apiGroup Message
     * @apiHeader {String} authorization-token   token.
     * @apiSuccess {String} custom_phone             客服电话.
     * @apiSuccess {String} complain_phone           投诉电话.
     * @apiSuccess {String} custom_email            我们的邮件地址.
     */
    public function onlineService() {

    }

}