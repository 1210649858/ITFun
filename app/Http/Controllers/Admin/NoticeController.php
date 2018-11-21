<?php

namespace App\Http\Controllers\Admin;

use App\Models\Notice;
use App\Models\Photo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class NoticeController extends Controller
{
    public function index(Request $request)
    {
        $where = function ($query) use ($request) {
            if ($request->has('keyword') and $request->keyword != '') {
                $search = "%" . $request->keyword . "%";
                $query->where('title', 'like', $search);
            }
        };
        $category = function ($query) use ($request) {
            if ($request->has('notice_node_id') and $request->notice_node_id != '') {
                $search =$request->notice_node_id;
                $query->where('notice_node_id', 'like', $search);
            }
        };
        $notices =Notice::with('notice_node','photo')->orderBy('created_at','desc')->where($where)->where($category)->paginate(5);
        return response()->json($notices);
    }

    public function store(Request $request)
    {
        $notice =Notice::create($request->all());
        return response()->json($notice);
    }

    public function edit($id)
    {
        $notice =Notice::with('photo')->find($id);
        return response()->json($notice);
    }

    public function update(Request $request, $id)
    {
        $notice =Notice::find($id);
        $notice->update($request->all());
    }

    public function destroy($id)
    {
        $notice =Notice::find($id);
        Notice::destroy($id);
        Photo::destroy($notice->photo_id);
    }
}
