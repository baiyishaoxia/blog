<?php

namespace App\Http\Model\Background;

use Illuminate\Database\Eloquent\Model;

class ImagesContent extends Model
{
    protected $table = 'images_content';
    protected $primaryKey = 'Id';
    protected $guarded = [];
    public $timestamps = false;
}
