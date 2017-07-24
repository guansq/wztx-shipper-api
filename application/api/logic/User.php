<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/5/4
 * Time: 10:15
 */

namespace app\api\logic;

use jwt\JwtHelper;
use think\Db;
class User extends BaseLogic{

    protected $table = 'rt_system_user_shipper';

    /**
     * Author: WILL<314112362@qq.com>
     * Time: ${DAY}
     * Describe: 生成密码
     * @param $pWd  明文密码
     * @param $salt 盐值
     */
    private static function generatePwd($pwd, $salt){
        $encryptPwd = self::encryptPwd($pwd);
        return $pwd = self::encryptPwdSalt($encryptPwd, $salt);
    }

    /**
     * Author: WILL<314112362@qq.com>
     * Time: ${DAY}
     * Describe: 密码加密
     * @param $loginPWd
     * @param $salt
     */
    private static function encryptPwd($pwd){
        return $pwd = md5("RUITU{$pwd}KEJI");
    }

    /**
     * Author: WILL<314112362@qq.com>
     * Time: ${DAY}
     * Describe: 密码加盐值加密
     * @param $loginPWd
     * @param $salt
     */
    private static function encryptPwdSalt($pwd, $salt = ''){
        return $pwd = sha1("THE{$salt}DAO{$pwd}");
    }


    /**
     * Author: WILL<314112362@qq.com>
     * Describe: 用户登录逻辑
     * @param $params
     * @Param {String} account           账号/手机号/邮箱.
     * @Param {String} password          密码.
     * @Param {String} [wxOpenid]        微信openid.
     * @Param {String} [pushToken]       消息推送token.
     * @Success {String} accessToken     接口调用凭证.
     * @Success {String} refreshToken    刷新凭证.
     * @Success {Number} expireTime      有效期.
     */
    public function login($params){
        $now = time();
        $account = $params['account'];
        $password = $params['password'];
        $wxOpenid = $params['wxOpenid'];
        $pushToken = $params['pushToken'];

        $loginUser = $this->findByAccount($account);

        if(empty($loginUser)){
            return resultArray(4000,'该用户不存在');
        }
        // 校验密码
        $ret = $this->checkPassword($loginUser, $password);
        if(!$ret){
            return resultArray(4014);
        }
        // 校验用户状态
        $ret = $this->checkStatus($loginUser);
        if(!$ret){
            return resultArray(4010, '用户已被锁定');
        }

        $loginUser->last_login_time = $now;
        $token = JwtHelper::encodeToken($loginUser);
        $ret = [
            'userId' => $loginUser->id,
            'real_name' => $loginUser->real_name,
            'accessToken' => $token,
            'refreshToken' => '没有哟~',
            'expireTime' => $loginUser->last_login_time + JwtHelper::DUE_TIME,
        ];
        //更新用户信息
        $updatedUser = [
            'wx_openid' => $wxOpenid,
            'push_token' => $pushToken,
            'last_login_time' => $now,
        ];
        $this->where(['push_token' => $pushToken])->update(['push_token' => null]);
        $this->where(['id' => $loginUser->id])->update($updatedUser);
        return resultArray(2000, '', $ret);

    }

    /**
     * Auther: guanshaoqiu <94600115@qq.com>
     * Describe:刷新token信息
     */
    public function refreshToken($userInfo){

    }

    /**
     * Author: WILL<314112362@qq.com>
     * Time: 根据登录用户查询账号消息信息
     * Describe:
     * @param $loginUser
     *
     * @Success {Number} id                  id.
     * @Success {String} bindMobile          绑定手机号.
     * @Success {String} bindEmail           绑定邮箱.
     * @Success {Number} sex                 性别 1=男 2=女 0=未知.
     * @Success {String} avatar              头像.
     * @Success {String} nickName            昵称.
     */
    public function getInfo($loginUser){
        $userFields = [
            'mobile' => 'bindMobile',
            'email' => 'bindEmail',
            'nick_name' => 'nickName',
            'avatar',
            'sex',
        ];
        $supFields = [
            'code',
            'name',
            'type_code' => 'typeCode',
            'type_name' => 'typeName',
            'state_tax_code' => 'taxCode',
            'found_date' => 'foundDate',
            'tax_rate' => 'taxRate',
            'mobile',
            'phone',
            'email',
            'fax',
            'ctc_name' => 'ctcName',
            'address',
            'pay_way' => 'payWay',
            'com_name' => 'comName',
            'purch_Code' => 'purchCode',
            'purch_name' => 'purchName',
            'purch_type' => 'purchType',
            'check_type' => 'checkType',
            'check_rate' => 'checkRate',
            'arv_rate' => 'arvRate',
            'pass_rate' => 'passRate',
        ];

        $userInfo = $this->field($userFields)->find($loginUser['id'])->toArray();
        $supInfo = model('SupplierInfo', 'logic')->findBySupId($loginUser['id'], $supFields)->toArray();

        $ret = array_merge($userInfo, $supInfo);
        $ret['passRate'] = empty($ret['passRate']) ? '0%' : rand($ret['passRate']*100, 0)."%";
        $ret['arvRate'] = empty($ret['arvRate']) ? '0%' : rand($ret['arvRate']*100, 0)."%";
        $ret['sex'] = empty($ret['sex']) ? 0 : $ret['sex'];
        $ret['foundDate'] = empty($ret['foundDate']) ? '' : date('Y-m-d', $ret['foundDate']);
        $ret['creditLevel'] = $this->getCreditLevel($supInfo);
        return resultArray(2000, '', $ret);
    }

    /**
     * Author: WILL<314112362@qq.com>
     * Time: 上传并更新头像
     * Describe:
     * @param $file
     */
    public function uploadAvatar($loginUser, $file){

        $fileLogic = model('File', 'logic');
        if(empty($_FILES)){
            return resultArray(4001);
        }
        $ossRet = $fileLogic->uploadFile($file);
        if(empty($ossRet) || $ossRet['code'] != 2000){
            return resultArray($ossRet);
        }
        $dbRet = $this->where('id', $loginUser['id'])->update(['avatar' => $ossRet['result']['file']['url']]);
        Db::name('sp_base_info')->where('id', $loginUser['id'])->update(['avatar' => $ossRet['result']['file']['url']]);
        if(!$dbRet){
            return resultArray(5000);
        }
        return resultArray($ossRet);

    }

    /**
     * Author: WILL<314112362@qq.com>
     * Time: 更新用户信息
     * Describe:
     * @param $file
     */
    public function updateInfo($updateUser){
        $update = [];
        if($updateUser['sex']){
            $update['sex'] = $updateUser['sex'];
        }
        if($updateUser['avatar']){
            $update['avatar'] = $updateUser['avatar'];
        }
        if($updateUser['nickName']){
            $update['nick_name'] = $updateUser['nickName'];
        }
        $this->where('id',$updateUser['id'])->update($update);
        $update = [];
        if($updateUser['payWay']){
            $update['pay_way_change'] = $updateUser['payWay'];
            $update['pay_way_status'] = 'uncheck';
        }
        model('SupplierInfo', 'logic')->where('sup_id',$updateUser['id'])->update($update);
        return resultArray(2000);
    }

    /**
     * Author: WILL<314112362@qq.com>
     * Time: 根据登录名查询账号信息
     * Describe:
     * @param $account
     */
    public function findByAccount($account){
        return $this->alias('a')->field('a.*,b.real_name')->join('sp_base_info b','a.user_name = b.phone','LEFT')->where(['a.user_name' => $account])->find();
    }

    /**
     * Author: WILL<314112362@qq.com>
     * Describe: 校验密码
     * @param $loginUser
     * @param $password
     */
    private function checkPassword($loginUser, $encryptPwd){
        $encryptPwd = self::encryptPwdSalt($encryptPwd, $loginUser->salt);
        return $loginUser->password === $encryptPwd;
    }
    /**
     * Author:
     * Describe: 校验密码
     * @param $loginUser
     * @param $password
     */
    private function checkPasswordNew($loginUser,$encryptNewPwd){
        $encryptNewPwd = self::encryptPwdSalt($encryptNewPwd, $loginUser->salt);
        return $loginUser->password === $encryptNewPwd;
    }
    /**
     * Author: WILL<314112362@qq.com>
     * Describe: 校验用户状态
     * @param $loginUser
     */
    private function checkStatus($loginUser){
        return $loginUser->status == 'enabled';
    }

    /**
     * 用户注册 system_user_shipper 插入记录，并插入到sp_base_info表
     */
    public function reg($params){

        Db::startTrans();
        try{
            //启动事务
            $now = time();
            $systemUser = [];
            $systemUser['salt'] = randomStr();//得到加密盐值
            $systemUser['user_name'] = $params['user_name'];
            $systemUser['mobile'] = $params['user_name'];
            $systemUser['password'] = self::encryptPwdSalt($params['password'],$systemUser['salt']);
            $systemUser['avatar'] = getSysconf('default_avatar');
            $systemUser['push_token'] = $params['pushToken'];
            $systemUser['last_login_time'] = $now;
            $systemUser['create_at'] = $now;
            $systemUser['update_at'] = $now;
            //$this->create($systemUser);
            $userId = Db::name('system_user_shipper')->insertGetId($systemUser);//得到user_id
            //$systemUser['user_id'] = $userId;
            $baseUser = [];
            if(isset($params['recomm_code']) && !empty($params['recomm_code'])){
                $recomm_id = Db::name('sp_base_info')->where("recomm_code",$params['recomm_code'])->value('id');
                if(!empty($recomm_id)){
                    $baseUser['recomm_id'] = $recomm_id;
                }
            }

            $baseUser['id'] = $userId;
            $baseUser['user_id'] = $userId;
            $baseUser['phone'] = $params['user_name'];
            $baseUser['type'] = $params['type'];
            $baseUser['avatar'] = $systemUser['avatar'];
            $baseUser['create_at'] = $now;
            $baseUser['update_at'] = $now;
            $baseUser['recomm_code'] = randomStr(6);
            if(isset($params['recom_code'])){
                $baseUser['recomm_id'] = getBaseIdByRecommCode($params['recom_code']);//写入推荐人ID进数据库
            }
            $result = Db::name('sp_base_info')->insertGetId($baseUser);
            Db::commit();
        }catch(\Exception $e){
            Db::rollback();
            return false;
        }
        $userObj = new \StdClass;
        $userObj->last_login_time = $now;
        $userObj->password = $systemUser['password'];
        $userObj->salt = $systemUser['salt'];
        $userObj->id = $userId;

        $token = JwtHelper::encodeToken($userObj);
        $ret = [
            'userId' => $result,
            'accessToken' => $token,
            'refreshToken' => '没有哟~',
            'expireTime' => $now + JwtHelper::DUE_TIME,
        ];
        return resultArray(2000, '', $ret);
    }

    /**
     * Auther: guanshaoqiu <94600115@qq.com>
     * Describe:修改个人密码
     */
    public function resetPwd($userInfo,$params){

        if(!is_array($userInfo)){
            $account = $userInfo;
        }else{
            $account = $userInfo['user_name'];
        }

        $loginUser = $this->findByAccount($account);

        if(empty($loginUser)){
            return resultArray(4000,'该用户不存在');
        }
        if(is_array($userInfo)){//存在数组 是修改密码 不存在则是重置密码
            // 校验密码
            $ret = $this->checkPassword($loginUser, $params['old_password']);
            if(!$ret){
                return resultArray(4014);
            }
        }else{
            $ret = $this->checkPasswordNew($loginUser,$params['new_password']);
            //重置密码时，设置的密码与原密码一样，无任何提示，依然设置成功
            if($ret){
                return resultArray(4000,'重置密码不能和原密码一致');
            }
        }

        $salt = randomStr();
        $newPwd = self::encryptPwdSalt($params['new_password'],$salt);
        $data = [
            'password' => $newPwd,
            'salt' => $salt
        ];
        $result = $this->where("id",$loginUser['id'])->update($data);
        if($result !== false){
            return resultArray('2000','更改成功');
        }
        return resultArray('4020','更改失败');
    }

}