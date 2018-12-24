<?php
/**
 * Created by IntelliJ IDEA.
 * User: HeSir
 * Date: 2018/12/14
 * Time: 10:29
 */

namespace app\index\validate;


use think\Validate;

class Login extends Validate
{

    protected $rule = [
        'user_name' => 'require|min:6',
        'user_password' => 'require',
        'user_email' => 'email',
        'user_phone' => 'length:11',
    ];
    protected $message = [
        'user_name.require' => '管理员名称必须填写!',
        'user_name.min' => '管理员名称不能小于6位!',
        'user_password.require' => '管理员名密码必须填写!',
        'user_email.email' => '邮箱格式不对！',
        'user_phone.length' => '请填写正确的电话号码!',
    ];

    //验证场景

    protected $scene = [
        'register' => ['user_name' => 'require|min:6', 'user_password', 'u_email'],
        'editInfo' => ['user_name' => 'require|min:6',  'u_email'],
        'change' => ['user_password' => 'require'],
    ];
}