<?php
/**
 * Created by IntelliJ IDEA.
 * User: HeSir
 * Date: 2018/12/14
 * Time: 11:29
 */

namespace app\index\validate;


use think\Validate;

class Part extends Validate
{

    protected $rule = [
        'part_name' => 'require',
    ];
    protected $message = [
        'part_name.require' => '文件夹名称不能为空!',

    ];

    //验证场景

    protected $scene = [
        'add' => ['part_name' => 'require'],
        'edit' => ['part_name' => 'require'],
    ];
}