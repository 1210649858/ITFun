<?php

namespace App\Http\Controllers\Admin;

use App\Models\AdvertNode;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdvertNodeController extends Controller
{
    public function index()
    {
        $advert_nodes =AdvertNode::orderBy('sort')->get();
        return response()->json($advert_nodes);
    }

    public function store(Request $request)
    {
        $advert_node =AdvertNode::create($request->all());
        return response()->json($advert_node);
    }

    public function edit($id)
    {
        $advert_node =AdvertNode::find($id);
        return response()->json($advert_node);
    }

    public function update(Request $request, $id)
    {
        $advert_node =AdvertNode::find($id);
        $advert_node->update($request->all());
    }

    public function destroy($id)
    {
        AdvertNode::destroy($id);
    }

    //多选删除
    public function destroy_checked(Request $request)
    {
        AdvertNode::destroy($request->checked_id);
    }

    //排序
    public function change_sort(Request $request )
    {
        $advert_node =AdvertNode::find($request->id);
        $advert_node ->sort= $request ->sort;
        $advert_node ->save();
    }
}
