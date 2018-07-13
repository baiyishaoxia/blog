<?php

namespace App\Http\Model\Background;

use App\Common\Tree;
use Illuminate\Database\Eloquent\Model;

class ImagesClass extends Model
{
    protected $table = 'images_class';
    protected $primaryKey = 'Id';
    protected $guarded = [];
    public $timestamps = false;

    //region   调用公共方法        tang
    public static function tree($type)
    {
        $tree=self::orderBy('Sort','asc')->get()->toArray();
        $tree = Tree::pidForLevel($tree,'|--','Pid','Name','Id');
        $tree=  Tree::array2ToArray1($tree,'Id','Name');
        if($type==1){
            $tree=[''=>'无父亲分类']+$tree;
        }
        if($type==2){
            $tree=[''=>'所有分类']+$tree;
        }
        if($type==3){
            $tree = ['new'=>'最新','hot'=>'热门','top'=>'头条'];
        }
        if($type==4){
            $tree = Tree::array2ToArray1(RuiecChildGroup::get()->toArray(),'Id','Name');
            $tree=[''=>'游客']+$tree;
        }
        return $tree;
    }
    //endregion
}
