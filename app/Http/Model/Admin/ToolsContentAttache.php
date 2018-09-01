<?php

namespace App\Http\Model\Admin;

use Illuminate\Database\Eloquent\Model;

class ToolsContentAttache extends Model
{
    protected $table = 'tools_content_attache';
    protected $primaryKey = 'id';
    public $timestamps = true;
    protected $guarded = [];
}
