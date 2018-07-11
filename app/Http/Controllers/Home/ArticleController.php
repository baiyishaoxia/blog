<?php

namespace App\Http\Controllers\Home;

use App\Jobs\SendEmail;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ArticleController extends Controller
{
    //region   文件上传        tang
    public function upload(Request $request)
    {
        if($request->isMethod('POST')){
           $file = $request->file('source');
           if($file->isValid()){
               //原文件名
               $oldname = $file->getClientOriginalName();
               //扩展名
               $ext = $file->getClientOriginalExtension();
               //文件类型
               $type = $file->getClientMimeType();
               //临时绝对路径
               $oldpath = $file->getRealPath();
               //拼接新文件名
               $filename = date('Y-m-d-H-i-s').'-'.uniqid().'.'.$ext;
               $res = \Storage::disk('uploads')->put($filename,file_get_contents($oldpath));
               if ($res){
                   return true;
               }else{
                   return false;
               }
           }
        }
        return view('home.article.upload');
    }
    //endregion

    //region   发送邮件        tang
    public function mail()
    {
      \Mail::raw('邮件内容',function($message){
          $message->from('tzf2273465837@126.com','白衣少侠');
          $message->subject('邮件主题测试');
          $message->to('1174881637@qq.com');
      });
      echo '发送成功';

//        \Mail::send('home.article.mail',['name'=>'baiyishaoxia'],function($message){
//            $message->to('1174881637@qq.com');
//        });
    }
    //endregion

    //region   缓存的使用       tang
    public function cache1()
    {
        //写入 put(键,值,有效期)
        \Cache::put('key1','val1',10);

        //add() 存在返回false
        //$bool = \Cache::add('key2','val2',10);
        //dd($bool);

        //forever()
        //\Cache::forever('key3','val3');

        //has() 判断某个key是否存在
        if(\Cache::has('Success')){
            $val = \Cache::get('Success');
            dd($val);
        }else{
            dd('不存在');
        }
    }

    public function cache2()
    {
        //获取 get(键)
        $val = \Cache::get('key1');
        dd($val);

        //pull() 只取一次,取完后就删除
        //$val = \Cache::pull('key2');
        //dd($val);

        //forget() 从缓存中删除对象,删除成功返回true
        //$bool = \Cache::forget('key1');
        //dd($bool);
    }
    //endregion

    //region   错误调试(APP_DEBUG)的作用以及http状态码跳转       tang
    public function error()
    {
        //$name = '白衣少侠';
        //dd($name);
        //return view('home.article.error');

        $article = null;
        if($article == null){
            abort('500');
        }
    }
    //endregion

    //region   日志的使用        tang
    //LOG_CHANNEL=stack/daily每天
    public function log()
    {
        //\Log::info('这是一个Info级别的日志');
        //\Log::warning('这是一个warning级别的日志');
        \Log::error('这是一个数组',['name'=>'zhansan','age'=>'19']);
        echo '日志测试成功';
    }
    //endregion

    //region   推送队列任务        tang
    public function queue()
    {
        dispatch(new SendEmail('1174881637@qq.com'));
    }
    //endregion

}
