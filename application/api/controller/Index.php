<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/5/12
 * Time: 9:55
 */

namespace app\api\controller;

use service\MsgService;
use think\Request;

class Index extends BaseController{
    private $url = 'http://api.sendcloud.net/apiv2/mail/send';//普通发送
    private $templateurl = 'http://api.sendcloud.net/apiv2/mail/sendtemplate';


    /**
     * @api             {GET} /apiCode   返回码说明done
     * @apiDescription  技术支持：<a href="http://www.ruitukeji.com" target="_blank">睿途科技</a>
     * @apiName         apiCode
     * @apiGroup        Index
     */
    public function apiCode(){
        //统计过期数量
//        $QlfLogic = model('SupplierQualification', 'logic');
//        $exceedQlfCount = $QlfLogic->countExceedQlf();
//        dd($exceedQlfCount);
        returnJson(2000, '技术支持：睿途科技(www.ruitukeji.com)', getCodeMsg());
    }

    /**
     * @api      {GET} /appConfig   应用配置参数done
     * @apiName  appConfig
     * @apiGroup Index
     * @apiSuccess {String} defaultAvatar      默认头像
     * @apiSuccess {String} share_percent      分享佣金比例
     * @apiSuccess {String} grab_range         通知附近司机接单范围
     * @apiSuccess {String} premium_rate       保险费率
     * @apiSuccess {String} bond_person_amount      个人保证金金额
     * @apiSuccess {String} bond_company_amount      公司保证金金额
     * @apiSuccess {String} withdraw_begintime      提现开始日期
     * @apiSuccess {String} withdraw_endtime      提现结束日期
     * @apiSuccess {String} custom_phone      客服电话
     * @apiSuccess {String} custom_email      客服邮件
     * @apiSuccess {String} complain_phone    投诉电话
     * @apiSuccess {String} weixin_limit    微信限额
     * @apiSuccess {String} alipay_limit    支付宝限额
     * @apiSuccess {String} tran_account    转账银行账号
     * @apiSuccess {String} xx    其他参数
     */
    public function appConfig(){
        $ret= model('SystemConfig','logic')->getAppConfig();
        returnJson( $ret);
    }

    /**
     * @api      {GET} /lastApk 获取最新apk下载地址done
     * @apiName  lastApk
     * @apiGroup Index
     * @apiSuccess {String} url                 下载链接.
     * @apiSuccess {Number} versionNum          真实版本号.
     * @apiSuccess {String} version             显示版本号.
     */
    public function lastApk(){
        $ret= model('SystemConfig','logic')->getLastApk();
        returnJson( $ret);
    }
    /**
     * @api      {GET} /index/home 首页轮播图 done
     * @apiName  home
     * @apiGroup Index
     * @apiHeader {String} [authorization-token]           token.
     *
     * @apiSuccess {Array} list             轮播图.
     * @apiSuccess {Number} list.id         id.
     * @apiSuccess {Number} list.position   序号.
     * @apiSuccess {String} list.url        跳转链接.
     * @apiSuccess {String} list.src        图片.
     * @apiSuccess {Object} unreadMsg       未读消息.
     */
    public function home(){
        $ads = model('Advertisement', 'logic')->getAdInfo();

        if(empty($this->loginUser['id'])){
            $unreadMsgCnt = 0;
        }else{
            $unreadMsgCnt = model('Message', 'logic')->countUnreadMsg($this->loginUser);
        }
        $ret = [
            'list' => $ads,
            'unreadMsg' => [
                'msg' => $unreadMsgCnt,
            ]
        ];
        returnJson(2000, '', $ret);
    }

    /**
     * @api      {POST} /index/sendCaptcha  发送验证码done
     * @apiName  sendCaptcha
     * @apiGroup Index
     * @apiParam {String} mobile   手机号.
     * @apiParam {String} opt      验证码类型 reg=注册 resetpwd=找回密码 login=登陆 bind=绑定手机号.
     * @apiParam {String} codeId   此为客户端系统当前时间截 除去前两位后经MD5 加密后字符串.
     * @apiParam {String} validationId   codeIdvalidationId(此为手机号除去第一位后字符串+（codeId再次除去前三位） 生成字符串后经MD5加密后字符串)
     * 后端接收到此三个字符串后      也同样生成validationId
     * 与接收到的validationId进行对比 如果一致则发送短信验证码，否则不发送。同时建议对 codeId 进行唯一性检验   另外，错误时不要返回错误内容，只返回errCode，此设计仅限获取短信验证码
     */
    public function sendCaptcha(){
        $data = $this->getReqParams(['mobile', 'opt']);
        $rule = [
            'mobile' => 'require|min:7',
            'opt' => 'require'
        ];
        validateData($data, $rule);
        //加上黑名单验证
        $blackwhere = [
            'is_del'=>0,
            'phone'=>$data['mobile'],
            'type'=>0
        ];
        if(!empty(getBlackInfo($blackwhere))) {
            $ret = [
                'code' => '4022',
                'msg' => '用户被加入黑名单',
                'result' => []
            ];
            returnJson($ret);
        }
        if($data['opt'] == 'reg'){
            //用已有账号注册时，依然能获得验证码，  此处应该不能再获得验证码且应提示“该用户已存在”。
            $info =  model('User','logic')->findByAccount($data['mobile']);
            if(!empty($info)){
                returnJson('4000','该用户已存在');
            }
        }
        if(in_array($data['opt'],['resetpwd'])){
            $isReg = isReg($data['mobile']);
            if(!$isReg){
                returnJson(4000,'抱歉您还未注册');
            }
        }
        returnJson(MsgService::sendCaptcha($data['mobile'],$data['opt']));
    }

    /**
     * 显示创建资源表单页.
     *
     * @return \think\Response
     */
    public function create(){
        returnJson(2000, '显示创建资源表单页');
    }

    public function test () {
        saveOrderShare(1);
    }
    /**
     * @api      {GET} /index/getArticle 获取文章内容done
     * @apiName  getArticle
     * @apiGroup Index
     *
     * @apiParam    {String}    type           文章标识(货主端:关于我们-shipper_about，发布订单协议-shipper_order_agreement，货物保险说明-shipper_insurance_instructions，推荐奖励说明-shipper_recommend_reward，用户注册协议-shipper_registration_protocol)
     * @apiSuccess {String} title    文章标题.
     * @apiSuccess {String} content   文章内容.
     * @apiSuccess {String} type     文章标识.
     */
    public function getArticle(){

        $paramAll = $this->getReqParams([
            'type',
        ]);
        $rule = [
            'type' => 'require',
        ];
        validateData($paramAll, $rule);
        $ret = model('Article', 'logic')->getArticleInfo($paramAll['type']);
        if(empty($ret)){
            returnJson(4004, '未获取到文章内容');
        }
        returnJson(2000, '', $ret);
    }

}