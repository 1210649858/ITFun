<?php

namespace App\Http\Controllers\Admin;

use App\Models\Tag;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TagController extends Controller
{
    public function index(Request $request)
    {
        $where = function ($query) use ($request) {
            if ($request->has('keyword') and $request->keyword != '') {
                $search = "%" . $request->keyword . "%";
                $query->where('name', 'like', $search);
            }
        };
        $category = function ($query) use ($request) {
            if ($request->has('course_node_id') and $request->course_node_id != '') {
                $search =$request->course_node_id;
                $query->where('course_node_id', 'like', $search);
            }
        };
        $tags =Tag::with('course_node')->orderBy('sort')->where($where)->where($category)->paginate(7);
        return response()->json($tags);
    }

    public function store(Request $request)
    {
        $tag =Tag::create($request->all());
        return response()->json($tag);
    }

    public function edit($id)
    {
        $tag =Tag::find($id);
        return response()->json($tag);
    }

    public function update(Request $request, $id)
    {
        $tag =Tag::find($id);
        $tag->update($request->all());
    }

    public function destroy($id)
    {
        Tag::destroy($id);
    }

    //改变属性
    public function change_attr(Request $request){
        $tag = Tag::find($request->id);
        $tag->is_show = !$request->is_show;
        $tag->save();
    }

    //排序
    public function change_sort(Request $request )
    {
        $tag =Tag::find($request->id);
        $tag ->sort= $request ->sort;
        $tag ->save();
    }
}
