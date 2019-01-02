<?php
/**
 * Created by IntelliJ IDEA.
 * User: HeSir
 * Date: 2018/12/14
 * Time: 11:22
 */

namespace app\index\controller;

use app\index\controller\Base;
use think\Db;
use think\Loader;


class Part extends Base
{

    /*所有Part*/
    public function lis()
    {
        $userId = session('userId');
        if ($userId) {
            $result = Db::name('part')->where('user_id', '=', $userId)->find();
            return json_encode($result, JSON_UNESCAPED_UNICODE);
        }
    }

    /*添加*/
    public function add($partName = '', $userId = '')
    {
        $data = [
            'part_name' => $partName,
            'user_id' => $userId
        ];

        $validate = Loader::validate('Part');
        if (!$validate->scene('add')->check($data)) {
            $this->error($validate->getError());
            die;
        }
        $result = Db::name('part')->insert($data);
        if ($result) {
            $return = ['num' => 101, 'msg' => '文件夹添加成功!'];
            return json_encode($return, JSON_UNESCAPED_UNICODE);
        } else {
            $return = ['num' => 102, 'msg' => '添加失败!'];
            return json_encode($return, JSON_UNESCAPED_UNICODE);
        }
    }

    /*修改*/
    public function edit($partName = '', $partId = '')
    {
        $userId = session('userId');
        $data = [
            'part_name' => $partName,
            'part_id' => $partId,
            'user_id' => $userId
        ];
        $user = Db::name('user')->where('u_id', '=', $userId)->find();
        if ($user) {
            $validate = Loader::validate('Part');
            if (!$validate->scene('edit')->check($data)) {
                $this->error($validate->getError());
                die;
            }
            $result = Db::name('part')->update($data);
            if ($result) {
                $return = ['num' => 100, 'msg' => '修改文件夹成功!'];
                return json_encode($return, JSON_UNESCAPED_UNICODE);
            } else {
                $return = ['num' => 102, 'msg' => '修改文件失败!'];
                return json_encode($return, JSON_UNESCAPED_UNICODE);
            }
        } else {
            $return = ['num' => 103, 'msg' => '用户账号出错,请重新登录操作'];
            return json_encode($return, JSON_UNESCAPED_UNICODE);
        }
    }

    /*删除*/
    public function del($partId = '')
    {
        $userId = session('userId');
        $user = Db::name('user')->where('u_id', '=', $userId)->find();
        if ($user) {
            $result = db('part')->delete($partId);
            if ($result) {
                $return = ['num' => 100, 'msg' => '删除文件夹成功!'];
                return json_encode($return, JSON_UNESCAPED_UNICODE);
            } else {
                $return = ['num' => 100, 'msg' => '删除文件夹失败!'];
                return json_encode($return, JSON_UNESCAPED_UNICODE);
            }
        } else {
            $return = ['num' => 103, 'msg' => '用户账号出错,请重新登录操作'];
            return json_encode($return, JSON_UNESCAPED_UNICODE);
        }
    }

}