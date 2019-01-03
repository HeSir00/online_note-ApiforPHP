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


class Folder extends Base
{


    /* 获取所有的 文件夹*/
    public function getTree($userId = '')
    {
        $user = Db::name('user')->where('user_id', '=', $userId)->select();
        if ($user) {
            $tree = Db::name('folder')->where('user_id', '=', $userId)->select();
            return json_encode($tree, JSON_UNESCAPED_UNICODE);
        } else {
        }
    }


    /*添加第一级文件夹*/
    public function createfirstFolder($folderName = '', $userId = '')
    {
        $user = Db::name('user')->where('user_id', '=', $userId)->select();
        $folder = Db::name('folder')->where('user_id', '=', $userId)->where('folder_name', '=', $folderName)->select();
        $data = [
            'folder_name' => $folderName,
            'user_id' => $userId,
            'folder_parentId' => 0,
            'folder_level' => 1,
        ];

        if ($user) {
            if ($folder) {
                $return = ['num' => 103, 'msg' => '文件名称已经存在!'];
                return json_encode($return, JSON_UNESCAPED_UNICODE);
            } else {
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
        } else {
            $return = ['num' => 110, 'msg' => '没有找到用户信息!'];
            return json_encode($return, JSON_UNESCAPED_UNICODE);
        }
    }

    /*创建子文件夹 folder*/
    public function addNewFolder($userId = '', $name = '', $parentId = '', $level = '')
    {
        $user = Db::name('user')->where('user_id', '=', $userId)->select();
        $data = [
            'folder_name' => $name,
            'user_id' => $userId,
            'folder_parentId' => $parentId,
            'folder_level' => $level,
        ];
        if ($user) {
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

        } else {
            $return = ['num' => 110, 'msg' => '没有找到用户信息!'];
            return json_encode($return, JSON_UNESCAPED_UNICODE);
        }
    }


//    public function lis()
//    {
//        $userId = session('userId');
//        $categoryList = Db::name('part')->where('user_id', '=', $userId)
//            ->select();
//        foreach ($categoryList as $key => $value) {
//            //第二个数据库查询，与第一个数据库某字段相关联
//            $categoryList[$key]['children'] = Db::name('folder')->where('part_id', $value['part_id'])
//                ->field('folder_id,folder_name')->select();
//        }
//        return json_encode($categoryList, JSON_UNESCAPED_UNICODE);
//    }

    /*修改*/
    public function edit($folderName = '', $folderId = '', $userId = '')
    {
        $data = [
            'folder_name' => $folderName,
            'folder_id' => $folderId,
        ];
        $user = Db::name('user')->where('user_id', '=', $userId)->find();
        if ($user) {
            $validate = Loader::validate('Folder');
            if (!$validate->scene('edit')->check($data)) {
                $this->error($validate->getError());
                die;
            }
            $result = Db::name('folder')->update($data);
            if ($result) {
                $return = ['num' => 101, 'msg' => '修改文件夹成功!'];
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
    public function delbyFolderId($folderId = '', $userId = '')
    {
        $user = Db::name('user')->where('user_id', '=', $userId)->find();

        if ($user) {
            $result = db('folder')->delete($folderId);
            if ($result) {
                db('folder')->where('folder_parentId', '=', $folderId)->delete();

                db('article')->where('folder_id', '=', $folderId)->delete();
                $return = ['num' => 101, 'msg' => '删除文件夹成功!'];
                return json_encode($return, JSON_UNESCAPED_UNICODE);
            } else {
                $return = ['num' => 102, 'msg' => '删除文件夹失败!'];
                return json_encode($return, JSON_UNESCAPED_UNICODE);
            }
        } else {
            $return = ['num' => 103, 'msg' => '用户账号出错,请重新登录操作'];
            return json_encode($return, JSON_UNESCAPED_UNICODE);
        }
    }


}