<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $guarded=[];

    public function course_node(){
        return $this->belongsTo('App\Models\CourseNode');
    }

    public function tag(){
        return $this->belongsToMany('App\Models\Course');
    }
}
