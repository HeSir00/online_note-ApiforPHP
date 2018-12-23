<?php
/**
 * Created by IntelliJ IDEA.
 * User: HeSir
 * Date: 2018/12/14
 * Time: 15:02
 */

namespace app\index\validate;


use think\Validate;

class Article extends Validate
{

    protected $rule = [
        'article_title' => 'require',
    ];
    protected $message = [
        'article_title.require' => '笔记名称不能为空!',

    ];

    //验证场景
    protected $scene = [
        'add' => ['article_title' => 'require'],
        'edit' => ['article_title' => 'require'],
    ];
}