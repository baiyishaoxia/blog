<?php

namespace App\Http\Controllers\Common;

use App\Http\Model\Links;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ExcelController extends Controller
{
    //region   导出友情链接        tang
    public function getExportLink(Request $request)
    {
        $keywords = $request->get("keywords", "");
        $id = $request->get("id", "");
        if ($id != ""){
            $ids = explode(',', $id);
            if ($ids[0] == 'on') {
                $ids = array_except($ids, ['0', count($ids)-1]);
            }else {
                $ids = array_except($ids, count($ids)-1);
            }
            $data = Links::whereIn('link_id', $ids)->where('link_isdel', 0)->get();
        }else{
            $data = Links::where("link_isdel", 0)->orderBy("link_id", "desc");
            if ($keywords != "") {
                $data = $data->where("link_name", "like", "%".$keywords."%")->orWhere('link_title','like',"%".$keywords."%")->get();
            }
            $data = $data->orderBy('link_id', 'desc')->get();
        }
        $str = "序号,标题,简介,链接,";
        $str = substr($str, 0, strlen($str)-1)."\n";
        foreach($data as $key=>$val) {
            $str .= ($key + 1) . ',';
            $str .= str_replace('"', '""', "" . ($val['link_name'])) . ',';
            $str .= str_replace('"', '""', "".(implode(";", explode(",", $val['link_title'])))).',';
            $str .= str_replace('"', '""', "" . ($val['link_url'])) . ',';
            $str = substr($str, 0, strlen($str)-1)."\n";
        }
        $str .= "\n";
        $str .= "*注：时间：".date('Y-m-d H:i:s',time());
        //设置保存的文件名
        $file_name = date('Y-m-d').'-友情链接.csv';
        //设置文档编码
        //$str = iconv('utf-8','GBK',$str);
        $str = mb_convert_encoding($str,'GBK','utf-8');
        //调用导出方法（头文件）
        self::export_csv($file_name,$str);
    }
    //endregion

    //region  导出的关键头文件         tang
    public function export_csv($filename,$data) {
        header( "Content-type: application/vnd.ms-excel; charset=utf-8" );
        header("Content-type:text/csv");
        $filename = iconv("utf-8","gb2312",$filename);
        header("Content-Disposition:attachment;filename=".$filename);
        header('Cache-Control:must-revalidate,post-check=0,pre-check=0');
        header('Expires:0');
        header('Pragma:public');
//        $filename = iconv("utf-8","gb2312",$filename);
//        Header("Content-Disposition: attachment; filename=".$filename);
        echo $data;
    }
    //endregion
}
