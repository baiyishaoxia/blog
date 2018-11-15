<?php

namespace App\Http\Model\Admin;

use App\User;
use Illuminate\Database\Eloquent\Model;

class ArticleTmpImages extends Model
{
    protected $table = 'article_tmp_images';
    protected $primaryKey = 'id';
    public $timestamps = true;
    protected $guarded = [];

    //region   多文件添加        tang
    public static function created_files($attach=null){
        $files_id = '';
        #添加文件目录
        $n=0;
        foreach ($attach as $key => $val){
            $file = new ArticleTmpImages();
            $m = $file::get_add($attach[$key]);
            if ($m){
                $files_id .= $m.',';
                $n++;
            }
        }
        $product_file_id = ArticleTmpImages::get_file_id($files_id);
        if ($n == count($attach)){
            return $product_file_id;
        }else{
            return false;
        }
    }
    //endregion

    //region   处理新增        tang
    public static function get_add($attach=null){
        $file = new self();
        $file->user_id = User::info()['id'];
        $file->file_name = $attach['filename'];
        $file->file_url = $attach['filepath'];
        $file->file_size = $attach['filesize'];
        $file->file_suffix = substr($attach['filename'], strrpos($attach['filename'], '.'));
        $now_name1 = pathinfo($attach['filepath'])['basename'];
        $now_name2 = substr(strrchr($now_name1, '.'), 1);
        $now_name3 = basename($now_name1,".".$now_name2);
        $file->file_now_name = $now_name3;
        $res = $file->save();
        if ($res){
            return $file->id;
        }else{
            return false;
        }
    }
    public static function get_file_id($files_id){
        $files_id = substr($files_id, 0, -1);
        return $files_id;
    }
    //endregion

    //region   获取图片        tang
    public static function get_file($product_files_id=''){
        if (!$product_files_id){
            return [];
        }
        $files_id = explode(',',$product_files_id);
        $data = self::whereIn('id',$files_id)->get();
        return $data;
    }
    //endregion
}
