<?php

namespace App\Http\Model\Home;

use Illuminate\Database\Eloquent\Model;

class Test extends Model
{
    protected $table = 'test';
    protected $primaryKey = 'id';
    public $timestamps = true;
    protected $guarded = [];
}
