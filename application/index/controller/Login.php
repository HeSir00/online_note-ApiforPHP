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


//无限极分类
//    public function fenlei()
//    {
//        $item = Db::name('cate')->order('cate_pid')->select();
//
//        $menu = array();
//
//        foreach ($item as $v){
//            $menu[$v['cate_id']]  = $v;
//            $menu[$v['cate_id']['item']] = array();
//            if($v['cate_pid'] != 0){
//                $menu[$v['cate_pid']]['item'][$v['cate_id']] = &$menu[$v['cate_id']];
//            }
//        }
//
//        foreach ($menu as $k=>$v){
//            if($v['cate_id'] != 0){
//                unset($menu[$k]);
//            }
//        }
//
//
//
//        return json_encode($menu,JSON_UNESCAPED_UNICODE);
//    }


    public
    function index($username = '', $password = '')
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

    public
    function register($username = '', $password = '', $email = '')
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


    public
    function editInfo($userid = '', $username = '', $useremail = '', $userphone = '', $usersex = '')
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


    public
    function changePwd($userid = '', $oldPassword = '', $newPassword)
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


    public function getTree()
    {
        $return = [];//索引目录
        $parent = '';//根目录,
        $list = Db::name('cate')->select();
        foreach ($list as $v)
            $return[$v['cate_id']] = [
                'cate_id' => $v['cate_id'],
                'cate_name' => $v['cate_name'],
                'cate_pid' => $v['cate_pid'],
                'children' => '',
            ];

        foreach ($return as $k => $v) {
            if ($v['cate_pid'] >= 0)
                $return[$v['cate_pid']]['children'][$v['cate_id']] = &$return[$k];
            else
                $parent = &$return[$k];
        }

//打印根目录
        return json_encode($parent, JSON_UNESCAPED_UNICODE);

    }


//    public function GetTeamMember($members, $mid)
//    {
//        $Teams = array();//最终结果
//        $Teams[] = $mid;
//        foreach ($members as $k => $v) {
//            if (in_array($v['active_uid'], $Teams, true) && !in_array($v['uid'], $Teams, true)) {
//                $Teams[] = $v['uid'];
//                unset($members[$k]);
//            } else {
//                unset($members[$k]);
//            }
//
//        }
//
//    }

    function array2tree(&$array, $pid = 'pid', $child_key_name = 'children')
    {
        $counter = array_children_count($array, $pid);
        if ($counter[0] == 0)
            return false;
        $tree = [];
        while (isset($counter[0]) && $counter[0] > 0) {
            $temp = array_shift($array);
            if (isset($counter[$temp['id']]) && $counter[$temp['id']] > 0) {
                array_push($array, $temp);
            } else {
                if ($temp[$pid] == 0) {
                    $tree[] = $temp;
                } else {
                    $array = array_child_append($array, $temp[$pid], $temp, $child_key_name);
                }
            }
            $counter = array_children_count($array, $pid);
        }

        return $tree;
    }


    function getUser($userId = '')
    {
        $user = Db::name('user')->where('user_id', '=', $userId)->field('user_name,user_id,user_phone,user_email,user_sex')->select();

        if ($user) {
            return json_encode($user, JSON_UNESCAPED_UNICODE);

        } else {
            $return = ['num' => 101, 'msg' => '没有查找到该用户信息!'];
            return json_encode($return, JSON_UNESCAPED_UNICODE);
        }
    }

}





