<?php

namespace App\Common;

class Tree
{
    /**
     * 父亲菜单，type为多加一个无父亲分类，type为2多加一个所有分类
     * @param array $tree
     * @param int $type
     * @return array
     * @author tang
     */
    public static function tree($tree,$type=1){
        $tree = self::getCateTree($tree,'|--');
        $tree=self::array2ToArray1($tree,'id','title');
        if($type==1){
            $tree=[''=>'无父亲分类']+$tree;
        }
        if($type==2){
            $tree=[''=>'所有分类']+$tree;
        }
        return $tree;
    }




    //region   建立树形        tang
    public static function getCateTree($data ,$html = '--',$pid=0,$level=0)
    {
        static $cate_list = array();
        foreach ($data as $row){
            if($row['Pid'] == $pid){
                $row['level'] = $level;
                $row['html']  = str_repeat($html, $level);
                $row['Name']=$row['html'].$row['Name'];
                $cate_list[] = $row;
                self::getCateTree($data,$html,$row['Id'],$level+1);
            }
        }
        return $cate_list;
    }
    //endregion


    //region   转数组        tang
    public static function array2ToArray1($data,$index,$val){
        $arr=array();
        foreach ($data as $key =>$value){
            $arr[$value[$index]]=$value[$val];
        }
        return $arr;
    }
    //endregion

    /**
     * 组合一维数组
     * @param $cate
     * @param string $html
     * @param string $pid
     * @param int $level
     * @return array
     * @author tang
     */
    public static function unlimitedForLevel ($cate, $html = '--', $pid = '0', $level = 0) {
        $arr = array();
        foreach ($cate as $k => $v) {
            if ($v['parent_id']==null){
                $v['parent_id']='0';
            }
            if ($v['parent_id'] == $pid) {
                $v['level'] = $level + 1;
                $v['html']  = str_repeat($html, $level);
                $v['title']=$v['html'].$v['title'];
                $arr[] = $v;
                $arr = array_merge($arr, static::unlimitedForLevel($cate, $html, $v['id'], $level + 1));
            }
        }
        return $arr;
    }

    /**
     * 递归挤压多多维数组
     * @param $cate
     * @param string $name
     * @param string $pid
     * @return array
     * @author tang
     */
    public static function unlimitedForLayer ($cate, $name = 'child', $pid = '0') {
        $arr = array();
        foreach ($cate as $v) {
            if ($v['parent_id']==null){
                $v['parent_id']='0';
            }
            if ($v['parent_id'] == $pid) {
                $v[$name] = self::unlimitedForLayer($cate, $name, $v['id']);
                $arr[] = $v;
            }
        }
        return $arr;
    }

    /**
     * 针对省市区使用的二维数组
     * @param $cate
     * @param string $name
     * @param string $pid
     * @return array
     * @author tang
     */
    public static function unlimitedForLayerForArea ($cate, $name = 'child', $pid = '0') {
        $arr = array();
        foreach ($cate as $v) {
            if ($v['parent_id']==null){
                $v['parent_id']='0';
            }
            if ($v['parent_id'] == $pid) {
                $thedata=self::unlimitedForLayerForArea($cate, $name, $v['id']);
                $v[$name] = $thedata;
                $arr[$v['id']] = $v;
            }
        }
        return $arr;
    }

    //region   使用不同的pid        tang
    public static function pidForLevel ($cate, $html = '--',$parent='parent_id',$title,$id, $pid = '0', $level = 0) {
        $arr = array();
        foreach ($cate as $k => $v) {
            if ($v[$parent]==null){
                $v[$parent]='0';
            }
            if ($v[$parent] == $pid) {
                $v['level'] = $level + 1;
                $v['html']  = str_repeat($html, $level);
                $v[$title]=$v['html'].$v[$title];
                $arr[] = $v;
                $arr = array_merge($arr, static::pidForLevel($cate, $html, $parent,$title,$id, $v[$id], $level + 1));
            }
        }
        return $arr;
    }
    //endregion

    //region   建立树形        tang
    public static function getCateTrees($data ,$name='Name',$par_id='Pid',$id='Id',$html = '--',$pid=0,$level=0)
    {
        static $cate_list = array();
        foreach ($data as $row){
            if($row[$par_id] == $pid){
                $row['level'] = $level;
                $row['html']  = str_repeat($html, $level);
                $row[$name]=$row['html'].$row[$name];
                $row['imgs'] = \Qiniu\json_decode($row['imgs']);
                $cate_list[] = $row;
                self::getCateTrees($data,$name,$par_id,$id,$html,$row[$id],$level+1);
            }
        }
        return $cate_list;
    }
    //endregion


    //region   树形结构        tang
    public static function trees($tree_array,$par_id='parent_id',$id='id',$name='name',$type=1){
        $tree = self::getCateTrees($tree_array,$name,$par_id,$id,'|--');
        $tree=self::array2ToArray1($tree,$id,$name);
        if($type==1){
            $tree=[''=>'无父亲分类']+$tree;
        }
        if($type==2){
            $tree=[''=>'所有分类']+$tree;
        }
        if($type==3){
            $tree = ['title'=>'标题','top'=>'置顶','hot'=>'热门','red'=>'推荐','slide'=>'幻灯片'];
        }
        return $tree;
    }
    //endregion
}
