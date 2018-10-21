<?php

namespace App\Http\Model\Background;

use Illuminate\Database\Eloquent\Model;

class EmailLog extends Model
{
    protected $table = 'email_log';
    protected $guarded = [];
    public $timestamps = true;

    //region   关联Email表        tang
    public function email(){
        return $this->belongsTo('App\Http\Model\Background\Email', 'email_id');
    }
    //endregion
}
