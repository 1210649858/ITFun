<?php

namespace App\Http\Controllers\Admin;

use App\Models\Course;
use App\Models\CourseNode;
use App\Models\Photo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class CourseController extends Controller
{
    //课程概览
    public function overview()
    {
        $overviews =CourseNode::with('tags')->orderBy('sort')->get();
        return response()->json($overviews);
    }

    public function index(Request $request)
    {
        $where = function ($query) use ($request) {
            if ($request->has('keyword') and $request->keyword != '') {
                $search = "%" . $request->keyword . "%";
                $query->where('body', 'like', $search);
            }
        };
        $courses = Course::with('course', 'photo')->orderBy('created_at')->where($where)->paginate(5);
        return response()->json($courses);
    }

    public function store(Request $request)
    {
        $course = Course::create($request->all());
        $course->course()->sync($request->tag_id);
        return response()->json($course);
    }

    public function edit($id)
    {
        $course = Course::with('course', 'photo')->find($id);

        //查出每个课程对应的所有章节,即章节列表
        $chapters = Course::with('chapters')->find($id);

        return response()->json(compact('course','chapters'));
    }

    public function update(Request $request, $id)
    {
        $course = Course::find($id);
        $course->course()->sync($request->tag_id);
        $course->update($request->all());
    }

    public function destroy($id)
    {
        $course =Course::find($id);
        Course::destroy($id);
        Photo::destroy($course->photo_id);
        DB::table('course_tag')->where('course_id',$id)->delete();
    }
}
