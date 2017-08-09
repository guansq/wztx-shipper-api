<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/5/12
 * Time: 9:55
 */

namespace app\api\controller;

use think\Request;
use service\MsgService;

class User extends BaseController{

    /**
     * @api     {POST} /User/reg            用户注册done
     * @apiName   reg
     * @apiGroup  User
     * @apiParam {String} type              注册类型 person-个人 company-公司.
     * @apiParam {String} user_name         手机号/用户名.
     * @apiParam {String} captcha           验证码.
     * @apiParam {String} password          加密的密码. 加密方式：MD5("RUITU"+明文密码+"KEJI")
     * @apiParam {String} [recomm_code]   推荐码
     * @apiParam {String} pushToken         消息推送token.
     * @apiSuccess {Number} userId          用户id.
     * @apiSuccess {String} accessToken     接口调用凭证.
     */
    public function reg(Request $request){
        //校验参数
        $paramAll = $this->getReqParams(['type','user_name', 'password', 'recomm_code', 'captcha','pushToken']);
        //$result=$this->validate($paramAll,'User');
        $rule = [
            ['type','require','请选择注册用户的类型'],
            ['user_name',['regex'=>'/^[1]{1}[3|5|7|8]{1}[0-9]{9}$/','require','unique:system_user_shipper'],['请输入合法的手机号','手机号必填','已经存在该用户，请不要重复注册']],
            //['password',['require','length:6,128'],['请填写密码','密码长度不得小于6大于128字节']],
            ['captcha',['require','length:4,8'],['验证码必填','验证码长度在4-8之间']]
        ];
        validateData($paramAll, $rule);
        $userLogic = model('User','logic');
        //校验验证码
        $result = MsgService::verifyCaptcha($paramAll['user_name'],'reg',$paramAll['captcha']);
        if($result['code'] != 2000){
            returnJson(4000,'验证码输入有误');
        }
        //判断推荐码
        if(isset($paramAll['recomm_code']) && !empty($paramAll['recomm_code'])){
            $recomm_id = getBaseIdByRecommCode($paramAll['recomm_code']);//写入推荐人ID进数据库
            if(empty($recomm_id)){
                returnJson(4000,'输入的邀请码有误');
            }
        }
        //进行注册
        $result = $userLogic->reg($paramAll);
        //$userLogic
        if($result === false){
            returnJson(4000,'注册失败');
        }
        returnJson($result);
    }

    /**
     * @api      {POST} /User/personAuth  货主个人认证done
     * @apiName  personAuth
     * @apiGroup User
     * @apiHeader {String}  authorization-token     token
     * @apiParam {String} real_name          真实姓名.
     * @apiParam {String} sex        性别 1=男 2=女 0=未知.
     * @apiParam {String} identity         身份证号.
     * @apiParam {String} hold_pic         手持身份证照.
     * @apiParam {String} front_pic        身份证正面照.
     * @apiParam {String} back_pic         身份证反面照.
     */
    public function personAuth(Request $request){
        //校验参数
        $paramAll = $this->getReqParams(['real_name','sex', 'identity', 'hold_pic', 'front_pic','back_pic']);
        $rule = [
            'real_name' => 'require|max:10',
            'sex' => ['require','regex'=>'/^(0|1|2)$/'],
            'identity' =>['require','regex'=>'/^(\d{15}$|^\d{18}$|^\d{17}(\d|X|x))$/'],
            'hold_pic' =>'require',
            'front_pic' =>'require',
            'back_pic' =>'require'
        ];
        validateData($paramAll, $rule);
        //查看验证状态为init,refuse才可以进行验证
        $spBaseInfoLogic = model('SpBaseInfo','logic');
        $authStatus = $spBaseInfoLogic->getAuthStatus($this->loginUser['id']);
        if(!in_array($authStatus,['init','refuse'])){
            $ret = [
                'code' => '4022',
                'msg' => '您已经重复验证过了',
                'result' => ['auth_status'=>$authStatus]
            ];
            returnJson($ret);
        }
        //验证信息入库更改状态为check
        $paramAll['auth_status'] = 'check';
        $where = [
            'id' => $this->loginUser['id']
        ];
        $result = $spBaseInfoLogic->savePersonAuth($where,$paramAll);
        returnJson($result);
    }


    /**
     * @api      {POST} /User/businessAuth  企业个人认证done
     * @apiName  businessAuth
     * @apiGroup User
     * @apiHeader {String}  authorization-token     token
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
     * @apiParam {String} hold_pic             法人身份证手持照片.
     * @apiParam {String} front_pic            法人身份证正面照片.
     * @apiParam {String} back_pic             法人身份证背面照片.
     * @apiParam {String} sp_identity          操作人身份证号.
     * @apiParam {String} sp_hold_pic          操作人手持身份证照.
     * @apiParam {String} sp_front_pic         操作人身份证正.
     * @apiParam {String} sp_back_pic          操作人身份证反.
     * @apiParam {String} buss_pic             企业营业执照.
     */
    public function businessAuth(Request $request){
        //校验参数
        $paramAll = $this->getReqParams([
            'com_name',
            'com_short_name',
            'com_buss_num',
            'law_person',
            'identity',
            'phone',
            'address',
            'deposit_name',
            'bank',
            'account',
            'hold_pic',
            'front_pic',
            'back_pic',
            'sp_identity',
            'sp_hold_pic',
            'sp_front_pic',
            'sp_back_pic',
            'buss_pic'
        ]);
        $rule = [
            'com_name' =>'require|max:50',
            'com_buss_num'=>'require|min:10|max:100',
            'law_person'=>'require|max:50',
            'identity' =>['require','regex'=>'/^(\d{15}$|^\d{18}$|^\d{17}(\d|X|x))$/'],
            'phone'=>['regex'=>'/^[1]{1}[3|5|7|8]{1}[0-9]{9}$/','require'],
            'address'=>'require|max:100',
            'deposit_name'=>'require|max:50',
            'bank'=>'require|max:50',
            'account'=>'require|max:50',
            'hold_pic'=>'require',
            'front_pic'=>'require',
            'back_pic'=>'require',
            'sp_identity'=>['require','regex'=>'/^(\d{15}$|^\d{18}$|^\d{17}(\d|X|x))$/'],
            'sp_hold_pic'=>'require',
            'sp_front_pic'=>'require',
            'sp_back_pic'=>'require',
            'buss_pic'=>'require',
        ];
        validateData($paramAll, $rule);
        //查看验证状态为init,refuse才可以进行验证
        $spBaseInfoLogic = model('SpBaseInfo','logic');
        $authStatus = $spBaseInfoLogic->getAuthStatus($this->loginUser['id']);
        if(!in_array($authStatus,['init','refuse']) ){
            $ret = [
                'code' => '4022',
                'msg' => '您已经重复验证过了',
                'result' => ['auth_status'=>$authStatus]
            ];
            returnJson($ret);
        }

        $result = $spBaseInfoLogic->saveBusinessAuth($paramAll,$this->loginUser);
        returnJson($result);
    }

    /**
     * @api      {POST} /User/login     用户登录done
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
     * @apiSuccess {String} real_name       用户真实姓名.
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
        $loginRet = model('User','logic')->login($paramAll);
        returnJson($loginRet);
    }

    /**
     * @api      {POST} /User/forget   重置密码done
     * @apiName  resetPwd
     * @apiGroup User
     * @apiParam {String} account           账号/手机号/邮箱.
     * @apiParam {String} new_password          加密的密码. 加密方式：MD5("RUITU"+明文密码+"KEJI").
     * @apiParam {String} captcha           验证码.
     */
    public function forget(Request $request){
        //校验参数
        $paramAll = $this->getReqParams(['account', 'new_password', 'captcha']);
        $rule = [
            'account' => ['regex'=>'/^[1]{1}[3|5|7|8]{1}[0-9]{9}$/','require'],
            'new_password' => 'require|length:6,128',
            'captcha' => 'require|length:4,8',
        ];
        validateData($paramAll, $rule);
        //校验验证码
        $result = MsgService::verifyCaptcha($paramAll['account'],'resetpwd',$paramAll['captcha']);
        if($result['code'] != 2000){
            returnJson($result);
        }
        $userLogic = model('User','logic');

        $ret = $userLogic->resetPwd($paramAll['account'],$paramAll);
        returnJson($ret);
    }


    /**
     * @api      {GET} /user/info   获取用户信息done
     * @apiName  info
     * @apiGroup User
     * @apiHeader {String} authorization-token           token.
     * @apiSuccess {Number} id                  id.
     * @apiSuccess {String} phone               绑定手机号.
     * @apiSuccess {String} type                获取用户的类型. person-个人 company-公司
     * @apiSuccess {String} type                获取用户的类型. person-个人 company-公司
     * @apiSuccess {Number} sex                 性别 1=男 2=女 0=未知.
     * @apiSuccess {String} avatar              头像.
     * @apiSuccess {String} real_name           真实姓名.
     * @apiSuccess {String} auth_status         认证状态（init=未认证，check=认证中，pass=认证通过，refuse=认证失败，delete=后台删除）
     * @apiSuccess {String} bond_status         保证金状态(init=未缴纳，checked=已缴纳,frozen=冻结)
     * @apiSuccess {String}  bond                保证金 保留两位小数点
     * @apiSuccess {String}  recomm_code         推荐码
     */

    public function info(Request $request){
        $ret = model('SpBaseInfo', 'logic')->getPersonBaseInfo($this->loginUser);
        returnJson($ret);
    }

    /**
     * @api      {POST} /user/uploadAvatar 上传并修改头像done
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
     * @api      {POST} /user/updateInfo  更新用户信息(ok)
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
     * @api {GET} /user/getPersonAuthInfo   获取个人认证信息done
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
     * @apiSuccess {String} hold_pic                    手持身份证
     * @apiSuccess {String} front_pic                   身份证正
     * @apiSuccess {String} back_pic                    身份证反
     *
     */
    public function getPersonAuthInfo(){
        $spBaseInfoLogic = model('SpBaseInfo','logic');
        //echo $this->loginUser['type'];die;
        /*if($this->loginUser['type'] != 'person'){
            returnJson('4000','请用个人类型的账号访问');
        }*/
        $result = $spBaseInfoLogic->getPersonAuthInfo($this->loginUser);
        returnJson($result);
    }

    /**
     * @api {GET} /user/getCompanyAuthInfo    获取企业公司认证信息done
     * @apiName getCompanyAuthInfo
     * @apiGroup User
     *
     * @apiHeader {String}  authorization-token     token.
     * @apiSuccess {String} auth_status                 认证状态（init=未认证，pass=认证通过，refuse=认证失败，delete=后台删除）
     * @apiSuccess {String} auth_info                   认证失败原因
     *
     * @apiSuccess {String} com_name                    企业全称
     * @apiSuccess {String} com_short_name              企业简称
     * @apiSuccess {String} com_buss_num                营业执照注册号
     * @apiSuccess {String} law_person                  企业法人姓名
     * @apiSuccess {String} law_identity                法人身份证号
     * @apiSuccess {String} com_phone                   企业联系电话
     * @apiSuccess {String} address                     地址
     *
     * @apiParam {String} deposit_name         开户名称.
     * @apiParam {String} bank                 开户行.
     * @apiParam {String} account              结算账号.
     *
     * @apiSuccess {String} identity                    操作人身份证号
     * @apiSuccess {String} front_pic                   操作人身份证正
     * @apiSuccess {String} back_pic                    操作人身份证反
     * @apiParam {String}   hold_pic                    操作人手持身份证照.
     * @apiSuccess {String} law_front_pic               法人身份证正
     * @apiSuccess {String} law_back_pic                法人身份证反
     * @apiSuccess {String} law_hold_pic                法人手拿身份证
     * @apiSuccess {String} buss_pic                    营业执照
     */
    public function getCompanyAuthInfo(){
        $spBaseInfoLogic = model('SpBaseInfo','logic');
        $result = $spBaseInfoLogic->getBusinessAuthInfo($this->loginUser);
        returnJson($result);
    }

    /**
     * @api {Get}   /user/refreshToken      刷新token
     * @apiName refreshToken
     * @apiGroup    User
     * @apiHeader {String}  authorization-token     token.
     * @apiSuccess {String} accessToken     接口调用凭证（token有效期为7200秒）.
     */
    public function refreshToken(){
        $loginRet = model('User','logic')->refreshToken($this->loginUser);
        returnJson($loginRet);
    }

    /**
     * @api      {POST} /User/updatePwd   修改密码done
     * @apiName  updatePwd
     * @apiGroup User
     * @apiHeader {String}  authorization-token     token.
     * @apiParam {String} old_password      加密的密码. 加密方式：MD5("RUITU"+明文密码+"KEJI").
     * @apiParam {String} new_password      加密的密码. 加密方式：MD5("RUITU"+明文密码+"KEJI").
     * @apiParam {String} repeat_password   重复密码.
     */
    public function updatePwd(Request $request){
        //校验参数
        $paramAll = $this->getReqParams(['old_password', 'new_password', 'repeat_password']);
        $rule = [
            //'account' => ['regex'=>'/^[1]{1}[3|5|7|8]{1}[0-9]{9}$/','require'],
            ['old_password',['require','length:6,128'],['旧密码必填','旧密码长度在6-128之间']],
            ['new_password',['require','length:6,128'],['新密码必填','新密码长度在6-128之间']],
            ['repeat_password',['require','confirm:new_password'],['重复密码必填','重复密码和新密码填写不一致']]
        ];


        validateData($paramAll, $rule);
        //校验验证码
        $userLogic = model('User','logic');
        $ret = $userLogic->resetPwd($this->loginUser,$paramAll);
        //$loginRet = \think\Loader::model('User', 'logic')->login($paramAll);
        returnJson($ret);
    }

}