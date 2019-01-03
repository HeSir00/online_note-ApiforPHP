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

    public function geArticleByfolder($folderId = '', $userId = '')
    {

        $user = Db::name('user')->where('user_id', '=', $userId)->select();
        if ($user) {
            $articleTitle = Db::name('article')
                ->where('user_id', '=', $userId)
                ->where('folder_id', '=', $folderId)
                ->field('article_id,article_title,folder_id,article_time,article_state')
                ->select();
            $articleCount = Db::name('article')->where('folder_id', '=', $folderId)->count();

            $folder = Db::name('folder')->where('user_id', '=', $userId)->where('folder_parentId', '=', $folderId)->select();
            $folderCount = Db::name('folder')
                ->where('user_id', '=', $userId)
                ->where('folder_parentId', '=', $folderId)
                ->count();

            $count = $articleCount + $folderCount;


            $resultData = [
                'count' => $count,
                'folder' => $folder,
                'articles' => $articleTitle
            ];
            return json_encode($resultData, JSON_UNESCAPED_UNICODE);

        }


    }

    public function getTitleById($folderId)

    {
        $result = Db::name('article')->where('folder_id', '=', $folderId)->field('article_title,article_id')->select();
        return json_encode($result, JSON_UNESCAPED_UNICODE);
    }

    public function getArticleContent($articleId = '')
    {
        $result = Db::name('article')->where('article_id', '=', $articleId)->select();
        return json_encode($result, JSON_UNESCAPED_UNICODE);
    }

    //新建标题 文件 或者 MD
    public function add($folderId = '', $userId = '')
    {
        $articleTitle = '未命名Markdown';
        $data = [
            'article_title' => $articleTitle,
            'user_id' => $userId,
            'folder_id' => $folderId,
            'article_state' => 2,
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

    public function edit($userId = '', $articleTitle = '', $articleContent = '', $articleId = '', $articleContentMd = '')
    {

        $data = [
            'user_id' => $userId,
            'article_id' => $articleId,
            'article_title' => $articleTitle,
            'article_content' => $articleContent,
            'article_content_md' => $articleContentMd,
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
                $return = ['num' => 101, 'msg' => '笔记编辑成功!'];
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
    public function delById($articleId = '',$userId='')
    {
        $user = Db::name('user')->where('user_id', '=', $userId)->find();
        if ($user) {
            $result = db('article')->delete($articleId);
            if ($result) {
                $return = ['num' => 101, 'msg' => '删除笔记成功!'];
                return json_encode($return, JSON_UNESCAPED_UNICODE);
            } else {
                $return = ['num' => 102, 'msg' => '删除笔记失败!'];
                return json_encode($return, JSON_UNESCAPED_UNICODE);
            }
        } else {
            $return = ['num' => 103, 'msg' => '用户账号出错,请重新登录操作'];
            return json_encode($return, JSON_UNESCAPED_UNICODE);
        }
    }
    public function delByFolderId($folderId = '',$userId='')
    {
        $user = Db::name('user')->where('user_id', '=', $userId)->find();
        if ($user) {
            $result = db('article')->where('folder_id','=' ,$folderId)->delete();
            if ($result) {
                db('folder')->delete($folderId);
                $return = ['num' => 101, 'msg' => '删除笔记成功!'];
                return json_encode($return, JSON_UNESCAPED_UNICODE);
            } else {
                $return = ['num' => 102, 'msg' => '删除笔记失败!'];
                return json_encode($return, JSON_UNESCAPED_UNICODE);
            }
        } else {
            $return = ['num' => 103, 'msg' => '用户账号出错,请重新登录操作'];
            return json_encode($return, JSON_UNESCAPED_UNICODE);
        }
    }

    //搜索所有的文章 匹配参数 标题 和 内容
    public function searchArticle($keywords = '', $userId = '')
    {

        $user = Db::name('user')->where('user_id', '=', $userId)->find();


        $where['article_title|article_content'] = array('like', '%' . $keywords . '%');
        if ($user) {
            $list = Db::name('article')->where($where)->field('article_id,article_title,folder_id,article_time,article_state')->select();

            $count = Db::name('article')->where($where)->count();
            $resultData = [
                'count' => $count,
                'articles' => $list
            ];

            return json_encode($resultData, JSON_UNESCAPED_UNICODE);
        }
    }
}