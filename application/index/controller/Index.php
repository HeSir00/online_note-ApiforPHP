<?php

namespace app\index\controller;

use app\index\controller\Base;
class Index extends Base
{
    public function index()
    {

        $return = [
            'num' => 0,
            'message' => '请先登录系统!！'
        ];

//            $this->error('请先登录系统!', 'Login/index');
        return json_encode($return,JSON_UNESCAPED_UNICODE);

    }
}
