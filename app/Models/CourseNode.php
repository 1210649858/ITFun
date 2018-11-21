<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CourseNode extends Model
{
    protected $guarded=[];

    public function tags(){
        return $this->hasMany('App\Models\Tag');
    }
}
