<?php

namespace App\Common\Api\File;
use Illuminate\Support\Facades\Storage;

/**
 * Class File
 * @package App\Common\Api\File
 * Author tang
 */
class File
{
    /**
     * 存储类型
     * @var
     * @author tang
     */
    public $disk;
    /**
     * 存储名称
     * @var
     * @author tang
     */
    public $file_name;
    /**
     * 存储路径
     * @var
     * @author tang
     */
    public $file_path;

    /**
     * 处理保存
     * @return false|string
     * @author tang
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
