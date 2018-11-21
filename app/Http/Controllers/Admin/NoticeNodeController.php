<?php

namespace App\Http\Controllers\Admin;

use App\Models\NoticeNode;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class NoticeNodeController extends Controller
{
    public function index()
    {
        $notice_nodes =NoticeNode::orderBy('sort')->get();
        return response()->json($notice_nodes);
    }

    public function store(Request $request)
    {
        $notice_node =NoticeNode::create($request->all());
        return response()->json($notice_node);
    }

    public function edit($id)
    {
        $notice_node =NoticeNode::find($id);
        return response()->json($notice_node);
    }

    public function update(Request $request, $id)
    {
        $notice_node =NoticeNode::find($id);
        $notice_node->update($request->all());
    }

    public function destroy($id)
    {
        NoticeNode::destroy($id);
    }

    //多选删除
    public function destroy_checked(Request $request)
    {
        NoticeNode::destroy($request->checked_id);
    }

    //排序
    public function change_sort(Request $request )
    {
        $notice_node =NoticeNode::find($request->id);
        $notice_node ->sort= $request ->sort;
        $notice_node ->save();
    }
}