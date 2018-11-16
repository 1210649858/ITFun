<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Site extends Model
{
    protected $guarded=['image','photo'];

    public function site_node(){
        return $this->belongsTo('App\Models\SiteNode');
    }

    public function photo(){
        return $this->belongsTo('App\Models\Photo');
    }
}
