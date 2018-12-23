<?php
/**
 * Created by IntelliJ IDEA.
 * User: HeSir
 * Date: 2018/12/14
 * Time: 14:05
 */

namespace app\index\model;

use think\Model;

class Folder extends Model
{

    public  function  part(){
        return $this->belongsTo('part','p_id');
    }
}