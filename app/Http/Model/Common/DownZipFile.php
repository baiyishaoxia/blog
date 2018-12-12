<?php

namespace App\Http\Model\Common;

use ZipArchive;

class DownZipFile{

    public $dir_name; //压缩包的目录文件名称（根目录，即文件的相对地址。如：./storage/file/test.zip）
    public $mkdir_name="./storage/file"; //解压到指定的目录，如：./storage/file

    /*
     * $file_name压缩文件的相对路径地址（如：./storage/file/test.zip）
     */
    public function __construct($file_name="")
    {
        if($file_name!=""){
            //$file_name = './storage/file/test.zip'(地址举例)
            //判断名称是否存在后缀
            if(strpos($file_name,'.zip') == false){
                //不存在则添加
                $file_name = $file_name.'.zip';//加上后缀，防止调用方式时出现错误
            }
            $this->dir_name = $file_name;
        }
        $this->mkdirs($this->mkdir_name);
    }

    /*
     * 压缩文件（将文件添加到压缩包）（完成）
     * $files是一个数组，多个文件的地址组合而成的数组(格式为一维数组：['./storage/file/1.jpg','./storage/file/2.jpg','./storage/file/3.jpg'])
     */
    public function getFileAddToZip($files){
        $zip = new ZipArchive();
        $zip_url = $this->dir_name;//文件相对地址，如：./storage/file/test.zip
        /*
         * $zip->open这个方法第一个参数表示处理的zip文件名。(zip文件名是相对路径，如：./storage/file/test.zip)
         * 第二个参数表示处理模式：
         * (1)ZipArchive::OVERWRITE 表示如果要打开的zip文件存在，就覆盖掉原来的zip文件。
         * (2)ZipArchive::CREATE 表示系统就会往原来的zip文件里添加内容。
         * 如果不是为了多次添加内容到zip文件，建议使用ZipArchive::OVERWRITE。
         * 使用这两个参数，如果zip文件不存在，系统都会自动新建。
         * 如果对zip文件对象操作成功，$zip->open这个方法会返回TRUE
         */
        //打开zip文件
        $open = $zip->open($zip_url,\ZipArchive::OVERWRITE);
        if($open !== true){
            //文件不存在，则创建文件
            $create = $zip->open($zip_url,\ZipArchive::CREATE);
            if($create !== true){
                return false;//无法打开文件，或者文件创建失败
            }
        }
        //判断$files是否是数组类型
        if(!is_array($files)){
            return false;//要添加的文件数据格式有误
        }
        //添加文件到压缩包addFile()方法
        foreach ($files as $key=>$val){
            //判断是否存在./相对地址的标识
            if(strpos($val,'./') == false){
                $files[$key] = './'.$val;//文件的相对地址（如：./storage/file/test1.doc）
            }
            //$files[$key] = mb_convert_encoding($files[$key],'GBK','utf-8');//防止文件乱码
            //对各个文件名称进行处理，直接获取文件的名称
            $new_filename = substr($files[$key], strrpos($files[$key], '/') + 1);
            /*
             * addFile()方法第一个参数是要添加到压缩包的文件的绝对地址
             * addFile()方法第二个参数（可选参数）表示该文件添加到压缩包以什么样的形式保存，如将文件保存在压缩包中的file文件中
             */
            $zip->addFile($files[$key],$new_filename);
        }
        // 添加一个字符串到压缩文档中的b.txt
        //$zip->addFromString('test.txt', '这个一个b.txt');
        // 添加一个空目录b到压缩文档
        //$zip->addEmptyDir('test');

        // 关闭打开的压缩文档（一定要关闭）
        $zip->close();
        return true;
    }

    /*
     * 解压缩(完成)
     * $this->mkdir_name要解压缩的目录地址（相对路径,如：./storage/file/test2）
     * $zip_url要解压的压缩包对象（相对路径,如：./storage/file/test.zip）
     */
    public function getFileFromZip($zip_url = ''){
        $zip = new ZipArchive();
        if($zip_url == ''){
            //如果没有指定解压某个指定压缩包，则解压初始化时要下载的压缩包
            $zip_url = $this->dir_name;//相对地址（如：./storage/file/test.zip）
        }
        $res = $zip->open($zip_url);
        if($res)
        {
            // 解压缩文件到指定目录
            $zip->extractTo($this->mkdir_name);
            $zip->close();
        }
    }

    /*
     * 下载压缩包（完成）
     * $file_name 下载文件的文件名
     * $zip_path要下载的压缩包地址（相对路径,例子：./storage/file/test.zip）
     * $del_old 是否删除旧文件
     */
    public function downZip($file_name = '',$del_old = false){
        $zip_path = $this->dir_name;//相对地址（如：./storage/file/test.zip）
        if($file_name == ''){
            $file_name = basename($zip_path);//如果没有指定文件名，则直接用要下载的文件名作为文件名称
        }else{
            //判断指定的文件名是否有.zip后缀
            if(strpos($file_name,'.zip') == false){
                //不存在则添加
                $file_name = $file_name.'.zip';//加上后缀，防止下载时出现错误
            }
        }
        header("Cache-Control: public");
        header("Content-Description: File Transfer");
//        header('Content-disposition: attachment; filename='.basename($url)); //(直接获取压缩包的文件名)文件名
        header("Content-disposition: attachment; filename=\"$file_name\""); //重命名文件名
        header("Content-Type: application/zip"); //zip格式的
        header("Content-Transfer-Encoding: binary"); //告诉浏览器，这是二进制文件
        header('Content-Length: '. filesize($zip_path)); //告诉浏览器，文件大小
        @readfile($zip_path);
        if($del_old == true){
            unlink($zip_path);//删除压缩包（防止文件过多，视情况而定）
        }
    }

    /**
     * 删除压缩包中的文件，文件夹函数
     * @param  [string]  $del_file    [文件名]
     * @param  boolean  $delDir [文件夹名]
     * @return [type]          [description]
     */
    public function delDirAndFile($del_file,$delDir=""){
        $zip = new ZipArchive();
        if ($zip->open($this->dir_name) === TRUE) {
            $zip->deleteName($del_file);//删除文件
            if($delDir != ""){
                $zip->deleteName($delDir);//删除文件夹
            }
            $zip->close();
            echo '删除成功';
        } else {
            echo '删除失败';
        }
    }
    //文件夹不存在则新建
    private function mkdirs($dir, $mode = 0777)
    {
        if (! file_exists ( $dir )) {
            @mkdir ( "$dir", $mode, true );
        }
    }


    /*
     * ZipArchive类中的所有属性
     *$zip->status;//Zip Archive 的状态
     *$zip->statusSys;//Zip Archive 的系统状态
     *$zip->numFiles;//压缩包里的文件数
     *$zip->filename;//在文件系统里的文件名，包含绝对路径
     *$zip->comment;//压缩包的注释
     ////////////////////////////

     /* ZipArchive类中的常用方法
     *$zip->addEmptyDir('css');//在zip压缩包中建一个空文件夹，成功时返回 TRUE， 或者在失败时返回 FALSE
     *$zip->addFile('index.html','in.html');//在zip更目录添加一个文件,并且命名为in.html,第二个参数可以省略
     *$zip->addFromString('in.html','hello world');//往zip中一个文件中添加内容
     *$zip->extractTo('/tmp/zip/');//解压文件到/tmp/zip/文件夹下面
     *$zip->renameName('in.html','index.html');//重新命名zip里面的文件
     *$zip->setArchiveComment('Do what you love,Love what you do.');//设置压缩包的注释
     *$zip->getArchiveComment();//获取压缩包的注释
     *$zip->getFromName('index.html');//获取压缩包文件的内容
     *$zip->deleteName('index.html');//删除文件
     *$zip->setPassword('123456');//设置压缩包的密码
     *$zip->close();//关闭资源句柄
     ////////////////////////////
     */

    /*添加文件到到指定压缩包
    $zip = new DownZipFile();
    $zip->dir_name = './storage/file/test.zip';
    $add = ['./storage/file/1.jpeg','./storage/file/2.jpeg','./storage/file/3.jpeg'];
    $zip->getFileAddToZip($add);
    //解压文件到指定目录
    $zip->mkdir_name = './storage/file';
    $zip->getFileFromZip('./storage/file/test.zip');
    //下载压缩文件并更换文件名
    $zip->dir_name = './storage/file/test.zip';
    $zip->downZip('rename');
    //删除指定压缩包中文件和文件夹
    $zip->dir_name = "./storage/file/test.zip";
    $zip->delDirAndFile('1.jpeg');
    */
}