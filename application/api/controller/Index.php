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
     * @apiSuccess {Array} payWays             付款方式 一维数组
     * @apiSuccess {String} xxx                其他参数
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
        if($data['opt'] == 'reg'){
            //用已有账号注册时，依然能获得验证码，  此处应该不能再获得验证码且应提示“该用户已存在”。
            $info =  model('User','logic')->findByAccount($data['mobile']);
            if(!empty($info)){
                returnJson('4000','该用户已存在');
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



}