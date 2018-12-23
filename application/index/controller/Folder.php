<?php
/**
 * Created by IntelliJ IDEA.
 * User: HeSir
 * Date: 2018/12/14
 * Time: 14:05
 */

namespace app\index\controller;

use app\index\controller\Base;
use think\Controller;
use think\Db;
use think\Loader;
use think\Validate;
use app\index\model\Folder as FolderModel;

class Folder extends Controller
{


    public function lis()
    {
        $userId = session('userId');
        $categoryList = Db::name('part')->where('user_id', '=', $userId)
            ->select();
        foreach ($categoryList as $key => $value) {
            //第二个数据库查询，与第一个数据库某字段相关联
            $categoryList[$key]['children'] = Db::name('folder')->where('part_id', $value['part_id'])
                ->field('folder_id,folder_name')->select();
        }
        return json_encode($categoryList, JSON_UNESCAPED_UNICODE);
    }


    /*添加*/
    public function add($folderName = '', $partId = '')
    {
        $userId = session('userId');
        $data = [
            'folder_name' => $folderName,
            'user_id' => $userId,
            'part_id' => $partId,
        ];

        $validate = Loader::validate('Folder');
        if (!$validate->scene('add')->check($data)) {
            $this->error($validate->getError());
            die;
        }
        $result = Db::name('folder')->insert($data);
        if ($result) {
            $return = ['num' => 101, 'msg' => '文件夹添加成功!'];
            return json_encode($return, JSON_UNESCAPED_UNICODE);
        } else {
            $return = ['num' => 102, 'msg' => '添加失败!'];
            return json_encode($return, JSON_UNESCAPED_UNICODE);
        }
    }

    /*修改*/
    public function edit($folderName = '', $folderId = '')
    {
        $userId = session('userId');
        $data = [
            'folder_name' => $folderName,
            'folder_id' => $folderId,
            'user_id' => $userId
        ];
        $user = Db::name('user')->where('u_id', '=', $userId)->find();
        if ($user) {
            $validate = Loader::validate('Folder');
            if (!$validate->scene('edit')->check($data)) {
                $this->error($validate->getError());
                die;
            }
            $result = Db::name('folder')->update($data);
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
    public function del($folderId = '')
    {
        $userId = session('userId');
        $user = Db::name('user')->where('user_id', '=', $userId)->find();
        if ($user) {
            $result = db('folder')->delete($folderId);
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