<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Advert extends Model
{
    protected $guarded=[];

    public function advert_node(){
        return $this->belongsTo('App\Models\AdvertNode');
    }

    public function photo(){
        return $this->belongsTo('App\Models\Photo');
    }
}
