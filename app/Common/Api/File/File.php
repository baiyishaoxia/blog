<?php

namespace App\Common\Api\File;
use Illuminate\Support\Facades\Storage;

/**
 * Class File
 * @package App\Common\Api\File
 * Author Ruiec.Simba
 */
class File
{
    /**
     * 存储类型
     * @var
     * @author Ruiec.Simba
     */
    public $disk;
    /**
     * 存储名称
     * @var
     * @author Ruiec.Simba
     */
    public $file_name;
    /**
     * 存储路径
     * @var
     * @author Ruiec.Simba
     */
    public $file_path;

    /**
     * 处理保存
     * @return false|string
     * @author Ruiec.Simba
     */
    public function store(){
        $path='';
        switch ($this->disk){
            case 'local':
                $path=Storage::putFile($this->file_path, $this->file_name);
                break;
        }
        return $path;
    }
}
