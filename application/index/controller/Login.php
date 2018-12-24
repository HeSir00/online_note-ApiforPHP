<?php
/**
 * Created by IntelliJ IDEA.
 * User: HeSir
 * Date: 2018/12/14
 * Time: 10:16
 */

namespace app\index\controller;


use think\Controller;
use think\Db;
use think\Loader;

header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Headers:Authorization');
header("Access-Control-Allow-Methods: GET, POST, DELETE");
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Headers: Content-Type, X-Requested-With, Cache-Control,Authorization");

class Login extends Controller
{
    public function index($username = '', $password = '')
    {
        $user = Db::name('user')->where('user_name', '=', $username)->find();
        if ($user) {
            if ($user['user_password'] == md5($password)) {
                session('username', $user['user_name']);
                session('userId', $user['user_id']);

                $return = [
                    'num' => 101,
                    'username' => $username,
                    'userEmail' => $user['user_email'],
                    'userID' => $user['user_id'],
                    'userSex' => $user['user_sex'],
                    'userPhone' => $user['user_phone'],
                    'msg' => '用户登录成功!'];
                return json_encode($return, JSON_UNESCAPED_UNICODE);
            } else {
                $return = ['num' => 102, 'msg' => '密码不正确!'];
                return json_encode($return, JSON_UNESCAPED_UNICODE);
            }
        } else {
            $return = ['num' => 103, 'msg' => '用户不存在!'];
            return json_encode($return, JSON_UNESCAPED_UNICODE);
        }
    }

    public function register($username = '', $password = '', $email = '')
    {
        $data = [
            'user_name' => $username,
            'user_password' => $password,
            'user_email' => $email,
        ];

        //validate
        $validate = Loader::validate('Login');
        if (!$validate->scene('register')->check($data)) {
            $this->error($validate->getError());
            die;
        } else {
            $data['user_password'] = md5($password);
        }

        //插入数据
        $result = Db::name('user')->insert($data);

        //返回信息
        if ($result) {
            $return = ['num' => 101, 'msg' => '用户注册成功!'];
            return json_encode($return, JSON_UNESCAPED_UNICODE);
        } else {
            $return = ['num' => 102, 'msg' => '用户注册失败!'];
            return json_encode($return, JSON_UNESCAPED_UNICODE);
        }
    }


    public function editInfo($userid = '', $username = '', $useremail = '', $userphone = '', $usersex = '')
    {
        $data = [
            'user_name' => $username,
            'user_email' => $useremail,
            'user_phone' => $userphone,
            'user_sex' => $usersex
        ];

        $validate = Loader::validate('Login');
        if (!$validate->scene('editInfo')->check($data)) {
            $this->error($validate->getError());
            die;
        } else {
            $user = Db::name('user')->where('user_id', '=', $userid)->find();
            if ($user) {
                $result = Db::name('user')->where('user_id', '=', $userid)->update($data);
                $userInfo = Db::name('user')->where('user_id', '=', $userid)->find();
                //返回信息
                if ($result) {
                    $return = ['data' => $userInfo, 'num' => 101, 'msg' => '用户信息修改成功!'];
                    return json_encode($return, JSON_UNESCAPED_UNICODE);
                } else {
                    $return = ['num' => 102, 'msg' => '用户信息修改失败!'];
                    return json_encode($return, JSON_UNESCAPED_UNICODE);
                }
            }

        }
    }


    public function changePwd($userid = '', $oldPassword = '', $newPassword)
    {
        $user = Db::name('user')->where('user_id', '=', $userid)->find();
        $data = [
            'user_password' => $newPassword,
        ];
        if ($user) {
            $validate = Loader::validate('login');
            if (!$validate->scene('change')->check($data)) {
                $this->error($validate->getError());
                die;
            } else {
                $password = md5($oldPassword);
                $userPassword = Db::name('user')->where('user_password', '=', $password)->find();
                if ($userPassword) {
                    $data['user_password'] = md5($newPassword);
                    $result = Db::name('user')->where('user_id', '=', $userid)->update($data);
                    //返回信息
                    if ($result) {
                        $return = ['num' => 101, 'msg' => '登录密码修改成功!'];
                        return json_encode($return, JSON_UNESCAPED_UNICODE);
                    } else {
                        $return = ['num' => 102, 'msg' => '登录密码修改失败!'];
                        return json_encode($return, JSON_UNESCAPED_UNICODE);
                    }
                } else {
                    $return = ['num' => 103, 'msg' => '密码不正确'];
                    return json_encode($return, JSON_UNESCAPED_UNICODE);
                }

            }
        }
    }

}