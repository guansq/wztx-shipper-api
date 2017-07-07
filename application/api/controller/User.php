<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/5/12
 * Time: 9:55
 */

namespace app\api\controller;

use think\Request;

class User extends BaseController{

    /**
     * @api     {POST} /User/reg            用户注册
     * @apiName   reg
     * @apiGroup  User
     * @apiParam {String} type              注册类型 person-个人 company-公司.
     * @apiParam {String} phone             手机号.
     * @apiParam {String} password          加密的密码. 加密方式：MD5("RUITU"+明文密码+"KEJI")
     * @apiParam {String} [recommendcode]   推荐码
     * @apiSuccess {Number} userId          用户id.
     * @apiSuccess {String} accessToken     接口调用凭证.
     */
    public function reg(Request $request){

        echo '123';
    }

    /**
     * @api      {POST} /User/personAuth  货主个人认证
     * @apiName  personAuth
     * @apiGroup User
     * @apiSuccess {String} accessToken     接口调用凭证.
     * @apiParam {String} id           个人ID.
     * @apiParam {String} real_name          真实姓名.
     * @apiParam {String} sex        性别 1=男 2=女 0=未知.
     * @apiParam {String} pushToken         消息推送token.
     * @apiParam {String} identity         身份证号.
     * @apiParam {String} hold_pic         手持身份证照.
     * @apiParam {String} front_pic        身份证正面照.
     * @apiParam {String} back_pic         身份证反面照.
     */
    public function personAuth(Request $request){

    }


    /**
     * @api      {POST} /User/businessAuth  企业个人认证
     * @apiName  businessAuth
     * @apiGroup User
     * @apiSuccess {String} accessToken        接口调用凭证.
     * @apiParam {int} id                      ID.
     * @apiParam {String} com_name             企业全称.
     * @apiParam {String} com_short_name       企业简称.
     * @apiParam {String} com_buss_num         营业执照注册号.
     * @apiParam {String} law_person           企业法人姓名.
     * @apiParam {String} identity             企业法人身份证号码.
     * @apiParam {String} phone                企业联系电话.
     * @apiParam {String} address              地址.
     * @apiParam {String} deposit_name         开户名称.
     * @apiParam {String} bank                 开户行.
     * @apiParam {String} account              结算账号.
     * @apiParam {String} front_pic            法人身份证正面照片.
     * @apiParam {String} back_pic             法人身份证背面照片.
     * @apiParam {String} sp_identity          操作人身份证号.
     * @apiParam {String} sp_hold_pic          操作人手持身份证照.
     * @apiParam {String} sp_front_pic         操作人身份证正.
     * @apiParam {String} sp_back_pic          操作人身份证反.
     */
    public function busnessAuth(Request $request){

    }
    /**
     * @api      {POST} /User/login     用户登录(ok)
     * @apiName  login
     * @apiGroup User
     * @apiParam {String} account           账号/手机号/邮箱.
     * @apiParam {String} password          加密的密码. 加密方式：MD5("RUITU"+明文密码+"KEJI").
     * @apiParam {String} [wxOpenid]        微信openid.
     * @apiParam {String} pushToken         消息推送token.
     * @apiSuccess {String} accessToken     接口调用凭证.
     * @apiSuccess {String} refreshToken    刷新凭证.
     * @apiSuccess {Number} expireTime      有效期.
     * @apiSuccess {Number} userId          用户id.
     * @apiSuccess {String} type            用户类型.
     */
    public function login(Request $request){
        //校验参数
        $paramAll = $this->getReqParams(['account', 'password', 'wxOpenid', 'pushToken']);
        $rule = [
            'account' => 'require|max:32',
            'password' => 'require|length:6,128',
            'pushToken' => 'require|length:6,128',
        ];
        validateData($paramAll, $rule);
        $loginRet = \think\Loader::model('User', 'logic')->login($paramAll);
        returnJson($loginRet);
    }

    /**
     * @api      {POST} /User/resetPwd   重置密码
     * @apiName  resetPwd
     * @apiGroup User
     * @apiParam {String} account           账号/手机号/邮箱.
     * @apiParam {String} password          加密的密码. 加密方式：MD5("RUITU"+明文密码+"KEJI").
     * @apiParam {String} captcha           验证码.
     */
    public function resetPwd(Request $request){
        //校验参数
        $paramAll = $this->getReqParams(['account', 'password', 'captcha']);
        $rule = [
            'account' => 'require|max:32',
            'password' => 'require|length:6,128',
            'captcha' => 'require|length:4,8',
        ];
        validateData($paramAll, $rule);
        $loginRet = \think\Loader::model('User', 'logic')->login($paramAll);
        returnJson($loginRet);
    }


    /**
     * @api      {GET} /user/info   获取用户信息(ok)
     * @apiName  info
     * @apiGroup User
     * @apiHeader {String} authorization-token           token.
     * @apiSuccess {Number} id                  id.
     * @apiSuccess {String} phone               绑定手机号.
     * @apiSuccess {Number} sex                 性别 1=男 2=女 0=未知.
     * @apiSuccess {String} avatar              头像.
     * @apiSuccess {String} real_name           真实姓名.
     * @apiSuccess {String} auth_status         认证状态（init=未认证，pass=认证通过，refuse=认证失败，delete=后台删除）
     * @apiSuccess {String} bond_status         保证金状态(init=未缴纳，checked=已缴纳,frozen=冻结)
     * @apiSuccess {Float}  bond                保证金 保留两位小数点
     */

    public function info(Request $request){
        $ret = model('User', 'logic')->getInfo($this->loginUser);
        returnJson($ret);
    }

    /**
     * @api      {POST} /user/uploadAvatar 上传并修改头像(ok)
     * @apiName  uploadAvatar
     * @apiGroup User
     * @apiHeader {String} authorization-token           token.
     * @apiParam  {Image} file              上传的文件 最大5M 支持'jpg', 'gif', 'png', 'jpeg'
     * @apiParam  {Number} [retType=json]   返回数据格式 默认=json  jsonp
     * @apiSuccess {String} url             下载链接(绝对路径)
     */
    public function uploadAvatar(){
        $file = $this->request->file('file');

        if(empty($file)){
            returnJson(4001);
        }
        $rule = ['size' => 1024*1024*5, 'ext' => 'jpg,gif,png,jpeg'];
        validateFile($file, $rule);
        $userLogic = model('User', 'logic');
        returnJson($userLogic->uploadAvatar($this->loginUser, $file));

    }

    /**
     * @api      {PUT} /user/updateInfo  更新用户信息(ok)
     * @apiName  updateInfo
     * @apiGroup User
     * @apiHeader {String} authorization-token           token.
     * @apiParam {Number} [sex]                 性别 1=男 2=女 0=未知.
     * @apiParam {String} [avatar]              头像.
     * @apiParam {String} [nickName]            昵称.
     * @apiParam {String} [payWay]              付款方式.
     *//*
     * @apiParam {String} [mobile]              电话.
     * @apiParam {String} [phone]               手机.
     * @apiParam {String} [email]               邮箱.
     * @apiParam {String} [fax]                 传真.
     * @apiParam {String} [ctcName]             联系人.
     * @apiParam {String} [address]             地址.
     * @apiParam {String} [comName]             企业名称.
     */

    public function updateInfo(Request $request){
        //校验参数
        $paramAll = $this->getReqParams(['sex', 'avatar', 'nickName', 'payWay']);
        $rule = [
            'sex' => 'in:1,2',
            'avatar' => 'length:6,255',
            'nickName' => 'length:2,32',
            'payWay' => 'length:4,128',
        ];
        validateData($paramAll, $rule);
        $paramAll['id'] = $this->loginUser['id'];
        $loginRet = model('User', 'logic')->updateInfo($paramAll);
        returnJson($loginRet);
    }


    /**
     * @api {GET} /user/getPersonAuthInfo   获取个人认证信息
     * @apiName getPersonAuthInfo
     * @apiGroup User
     *
     * @apiHeader {String}  authorization-token         token.
     * @apiSuccess {String} auth_status                 认证状态（init=未认证，pass=认证通过，refuse=认证失败，delete=后台删除）
     * @apiSuccess {String} auth_info                   认证失败原因
     * @apiSuccess {String} real_name                   真实姓名
     * @apiSuccess {String} phone                       绑定手机号
     * @apiSuccess {String} identity                    身份证号
     * @apiSuccess {String} sex                         性别 1=男 2=女 0=未知
     * @apiSuccess {String} front_pic                   身份证正
     * @apiSuccess {String} back_pic                    身份证反
     *
     */
    public function getPersonAuthInfo(){

    }

    /**
     * @api {GET} /user/getCompanyAuthInfo    获取企业公司认证信息
     * @apiName getCompanyAuthInfo
     * @apiGroup User
     *
     * @apiHeader {String}  authorization-token     token.
     * @apiSuccess {String} auth_status                 认证状态（init=未认证，pass=认证通过，refuse=认证失败，delete=后台删除）
     * @apiSuccess {String} auth_info                   认证失败原因
     * @apiSuccess {String} com_name                    企业全称
     * @apiSuccess {String} com_short_name              企业简称
     * @apiSuccess {String} com_buss_num                营业执照注册号
     * @apiSuccess {String} law_person                  企业法人姓名
     * @apiSuccess {String} law_identity                法人身份证号
     * @apiSuccess {String} com_phone                   企业联系电话
     * @apiSuccess {String} address                     地址
     * @apiSuccess {String} identity                    操作人身份证号
     * @apiSuccess {String} front_pic                   操作人身份证正
     * @apiSuccess {String} law_front_pic               法人身份证正
     * @apiSuccess {String} law_back_pic                法人身份证反
     * @apiSuccess {String} buss_pic                    营业执照
     */
    public function getCompanyAuthInfo(){

    }
}