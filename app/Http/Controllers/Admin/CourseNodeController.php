<?php

namespace App\Http\Controllers\Admin;

use App\Models\CourseNode;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CourseNodeController extends Controller
{ public function index()
{
    $course_nodes =CourseNode::orderBy('sort')->get();
    return response()->json($course_nodes);
}

    public function store(Request $request)
    {
        $course_node =CourseNode::create($request->all());
        return response()->json($course_node);
    }

    public function edit($id)
    {
        $course_node =CourseNode::find($id);
        return response()->json($course_node);
    }

    public function update(Request $request, $id)
    {
        $course_node =CourseNode::find($id);
        $course_node->update($request->all());
    }

    public function destroy($id)
    {
        CourseNode::destroy($id);
    }

    //多选删除
    public function destroy_checked(Request $request)
    {
        CourseNode::destroy($request->checked_id);
    }

    //排序
    public function change_sort(Request $request )
    {
        $course_node =CourseNode::find($request->id);
        $course_node ->sort= $request ->sort;
        $course_node ->save();
    }
}