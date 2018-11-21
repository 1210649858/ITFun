<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $guarded=['image','photo','tag_id'];

    //课程与标签多对多
    public function course(){
        return $this->belongsToMany('App\Models\Tag');
    }

    //课程属于图片
    public function photo(){
        return $this->belongsTo('App\Models\Photo');
    }

    //课程有很多章节
    public function chapters()
    {
        return $this->hasMany('App\Models\Chapter')->orderBy('sort');
    }
}
