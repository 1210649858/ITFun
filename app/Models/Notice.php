<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notice extends Model
{
    protected $guarded=['image','photo'];

    public function notice_node(){
        return $this->belongsTo('App\Models\NoticeNode');
    }

    public function photo(){
        return $this->belongsTo('App\Models\Photo');
    }
}
