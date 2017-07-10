<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/7/10
 * Time: 10:34
 */
namespace app\common\validate;
use think\Validate;

class User extends Validate{
    protected $rule = [
        'user_name'=>['regex'=>'/^[1]{1}[3|5|7|8]{1}[0-9]{9}$/','require','unique:system_user_shipper'],
        'password' => 'require|length:6,128',
        'captcha' => 'require|length:4,8',
    ];

    protected $message = [
        'user_name.require' => '手机号必填',
        'password.require' => '密码必填',
        'captcha.require' => '验证码不能为空',
    ];
}