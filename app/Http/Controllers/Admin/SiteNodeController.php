<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\SiteNode;

class SiteNodeController extends Controller
{
    public function index()
    {
        $site_nodes =SiteNode::orderBy('sort')->get();
        return response()->json($site_nodes);
    }

    public function store(Request $request)
    {

        $site_node =SiteNode::create($request->all());
        return response()->json($site_node);
    }

    public function edit($id)
    {
        $site_node =SiteNode::find($id);
        return response()->json($site_node);
    }

    public function update(Request $request, $id)
    {
        $site_node =SiteNode::find($id);
        $site_node->update($request->all());
    }

    public function destroy($id)
    {
        SiteNode::destroy($id);
    }

    //多选删除
    public function destroy_checked(Request $request)
    {
        SiteNode::destroy($request->checked_id);
    }

    //排序
    public function change_sort(Request $request )
    {
        $site_node =SiteNode::find($request->id);
        $site_node ->sort= $request ->sort;
        $site_node ->save();
    }
}
