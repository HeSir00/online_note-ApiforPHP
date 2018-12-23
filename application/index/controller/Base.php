<?php
/**
 * Created by IntelliJ IDEA.
 * User: HeSir
 * Date: 2018/12/14
 * Time: 9:56
 */

namespace app\index\controller;

use think\Controller;

header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Headers:Authorization');
header("Access-Control-Allow-Methods: GET, POST, DELETE");
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Headers: Content-Type, X-Requested-With, Cache-Control,Authorization");

class Base extends Controller
{

    //登录权限
    public function _initialize()
    {
        if (!session('username')) {
            $return = [
                'num' => 0,
                'message' => '请先登录系统!！'
            ];

//            $this->error('请先登录系统!', 'Login/index');
            return json_encode($return, JSON_UNESCAPED_UNICODE);

//

        }
    }

}