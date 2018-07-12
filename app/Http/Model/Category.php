<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
   protected $table='category';
   protected $primaryKey = 'cate_id';
   public  $timestamps = false;
   protected $guarded = [''];

   //分类列表用的数据(使用2维)
    public static function tree()
    {
        //all()方法获取所有数据
        $category = self::orderBy('cate_order','asc')->get();
        //返回处理后数据
        return self::getTree($category,'cate_name','cate_id','cate_pid');
    }
    //分类列表用的数据(使用多维)
    public static function moreTree(){
        $cateInfo = self::orderBy('cate_order','asc')->get();
        //二次遍历查询顶级分类
        foreach ($cateInfo as $key => $value) {
            if($value['cate_pid'] > 0){
                //查询cate_pid对应的分类信息
                $info = self::find($value['cate_pid']);
                //只需要保留其中的name
                //var_dump($value);die;
                $cateInfo[$key]['_cate_name'] = $info['cate_name'];
            }
        }
        return self::getCateTree($cateInfo);
    }

    //分类列表用的数据(使用多维,除去本身id)
    public static function moreEditTree($cate_id){
        //$cateInfo = self::orderBy('cate_order','asc')->where('cate_id','<>',$cate_id)->get();
        $cateInfo = self::orderBy('cate_order','asc')->get();
        //二次遍历查询顶级分类
        foreach ($cateInfo as $key => $value) {
            if($value['cate_pid'] > 0){
                //查询cate_pid对应的分类信息
                $info = self::find($value['cate_pid']);
                $cateInfo[$key]['_cate_name'] = $info['cate_name'];
            }
        }
        return self::getCateTree($cateInfo);
    }
    //树形结构(2维)
    public static function getTree($data,$field_name,$field_id='id',$field_pid='pid',$pid=0)
    {
        $arr = array();
        foreach ($data as $k => $v){
            if($v->$field_pid == $pid){
                $data[$k]['_'.$field_name] = $data[$k][$field_name];
                $arr[] = $data[$k];
                foreach ($data as $m =>$n){
                    if($n->$field_pid == $v->$field_id){
                        $data[$m]['_'.$field_name] = '→'.$data[$m][$field_name];
                        $arr[] = $data[$m];
                    }
                }
            }
        }
        return $arr;
    }
    //多维树形结构、层次关系(多维无限级)
    public static function getCateTree($data,$html = '--',$pid=0,$level=0)
    {
        static $cate_list = array();
        foreach ($data as $row){
            if($row['cate_pid'] == $pid){
                $row['level'] = $level;
                $row['html']  = str_repeat($html, $level);
                $row['cate_name']  = $row['html'].$row['cate_name'];
                $cate_list[] = $row;
                self::getCateTree($data,$html,$row['cate_id'],$level+1);
            }
        }
        return $cate_list;

    }

    //region   $data数组  (键值)$index => $val       tang
    public static function array2ToArray1($data,$index,$val){
        $arr=array();
        foreach ($data as $key =>$value){
            $arr[$value[$index]]=$value[$val];
        }
        return $arr;
    }
    //endregion

    /**
     * 父亲菜单，type为多加一个无父亲分类，type为2多加一个所有分类
     * @param int $type
     * @return array
     * @author tang
     */
    public static function tree2($type=1){
        $tree=self::orderBy('cate_order','asc')
            ->get();
        $tree = self::getCateTree($tree->toArray(),'|--');
        $tree=self::array2ToArray1($tree,'cate_id','cate_name');
        if($type==1){
            $tree=[''=>'无父亲分类']+$tree;
        }
        if($type==2){
            $tree=[''=>'所有分类']+$tree;
        }
        return $tree;
    }


}
