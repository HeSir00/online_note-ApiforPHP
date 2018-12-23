<?php
/**
 * Created by IntelliJ IDEA.
 * User: HeSir
 * Date: 2018/12/14
 * Time: 14:05
 */

namespace app\index\validate;


use think\Validate;

class Folder extends Validate
{

    protected $rule = [
        'folder_name' => 'require',
    ];
    protected $message = [
        'folder_name.require' => '文件夹名称不能为空!',

    ];

    //验证场景

    protected $scene = [
        'add' => ['folder_name' => 'require'],
        'edit' => ['folder_name' => 'require'],
    ];
}