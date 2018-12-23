<?php
/**
 * Created by IntelliJ IDEA.
 * User: HeSir
 * Date: 2018/12/14
 * Time: 15:02
 */


namespace app\index\controller;

use app\index\controller\Base;
use think\Db;
use think\Loader;

class  Article extends Base
{

    public function geArticleByfolder($folderId = '')
    {

        $result = Db::name('article')->where('folder_id', '=', $folderId)->select();
        $count = Db::name('article')->where('folder_id', '=', $folderId)->count();

        $return = ['count' => $count, 'data' => $result];

        return json_encode($return, JSON_UNESCAPED_UNICODE);


    }

    public function getTitleById($folderId)

    {
        $result = Db::name('article')->where('folder_id', '=', $folderId)->field('article_title,article_id')->select();
        return json_encode($result, JSON_UNESCAPED_UNICODE);
    }

    public function getContentByarticleId($articleId = '')
    {
        $result = Db::name('article')->where('article_id', '=', $articleId)->select();
        return json_encode($result, JSON_UNESCAPED_UNICODE);
    }

    public function add($articleTitle = '', $folderId = '')
    {
        $userId = session('userId');
        $data = [
            'article_title' => $articleTitle,
            'user_id' => $userId,
            'folder_id' => $folderId,
            'article_time' => time(),
        ];
        $validate = Loader::validate('Article');
        if (!$validate->scene('add')->check($data)) {
            $this->error($validate->getError());
            die;
        }
        $result = Db::name('article')->insert($data);
        if ($result) {
            $return = ['num' => 101, 'msg' => '笔记添加成功!'];
            return json_encode($return, JSON_UNESCAPED_UNICODE);
        } else {
            $return = ['num' => 102, 'msg' => '笔记添加失败!'];
            return json_encode($return, JSON_UNESCAPED_UNICODE);
        }

    }

    /*编辑文章标题*/
    public function editTitle($articleId = '', $articleTitle = '')
    {
        $userId = session('userId');
        $data = [
            'article_title' => $articleTitle,
            'article_id' => $articleId,
        ];
        $validate = Loader::validate('Article');
        if (!$validate->scene('add')->check($data)) {
            $this->error($validate->getError());
            die;
        }
        $result = Db::name('article')->update($data);
        if ($result) {
            $return = ['num' => 101, 'msg' => '标题修改成功!'];
            return json_encode($return, JSON_UNESCAPED_UNICODE);
        } else {
            $return = ['num' => 102, 'msg' => '标题修改失败!'];
            return json_encode($return, JSON_UNESCAPED_UNICODE);
        }

    }

    /*编辑*/

    public function edit($articleTitle = '', $articleContent = '', $articleId = '', $articleContentCode = '')
    {
        $userId = session('userId');
        $data = [
            'article_id' => $articleId,
            'article_title' => $articleTitle,
            'article_content' => $articleContent,
            'article_content_code' => $articleContentCode,
        ];

        $user = Db::name('user')->where('user_id', '=', $userId)->find();
        if ($user) {
            $validate = Loader::validate('Article');
            if (!$validate->scene('edit')->check($data)) {
                $this->error($validate->getError());
                die;
            }
            $result = Db::name('article')->update($data);
            if ($result) {
                $return = ['num' => 100, 'msg' => '笔记编辑成功!'];
                return json_encode($return, JSON_UNESCAPED_UNICODE);
            } else {
                $return = ['num' => 102, 'msg' => '笔记编辑失败!'];
                return json_encode($return, JSON_UNESCAPED_UNICODE);
            }
        } else {
            $return = ['num' => 103, 'msg' => '用户账号出错,请重新登录操作'];
            return json_encode($return, JSON_UNESCAPED_UNICODE);
        }
    }

    /*删除*/
    public function del($articleId = '')
    {
        $userId = session('userId');
        $user = Db::name('user')->where('user_id', '=', $userId)->find();
        if ($user) {
            $result = db('part')->delete($articleId);
            if ($result) {
                $return = ['num' => 100, 'msg' => '删除笔记成功!'];
                return json_encode($return, JSON_UNESCAPED_UNICODE);
            } else {
                $return = ['num' => 100, 'msg' => '删除笔记失败!'];
                return json_encode($return, JSON_UNESCAPED_UNICODE);
            }
        } else {
            $return = ['num' => 103, 'msg' => '用户账号出错,请重新登录操作'];
            return json_encode($return, JSON_UNESCAPED_UNICODE);
        }
    }
}