<?php

namespace App\Http\Model\Admin;

use App\Common\Tree;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ToolsList extends Model
{
    use SoftDeletes;
    protected $table = 'tools_list';
    protected $primaryKey = 'id';
    public $timestamps = true;
    protected $guarded = [];
    protected $dates = ['deleted_at']; //开启软删除

    public static function tree($type=1){
        $data = self::orderBy('sort','asc')->get()->toArray();
        //trees($tree_array,$par_id='parent_id',$id='id',$name='name',$type=1)
        $tree = Tree::trees($data,'parent_id','id','text',$type);
        return $tree;
    }

}
