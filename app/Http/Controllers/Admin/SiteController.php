<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Site;

class SiteController extends Controller
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
            if ($request->has('site_node_id') and $request->site_node_id != '') {
                $search =$request->site_node_id;
                $query->where('site_node_id', 'like', $search);
            }
        };
        $sites =Site::with('site_node','photo')->orderBy('created_at','desc')->where($where)->where($category)->paginate(5);
        return response()->json($sites);
    }

    public function store(Request $request)
    {
        $site =Site::create($request->all());
        return response()->json($site);
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $site =Site::with('site_node','photo')->find($id);
        return response()->json($site);
    }

    public function update(Request $request, $id)
    {
        return $request;false;
        $site =Site::find($id);
        $site->update($request->all());
    }

    public function destroy($id)
    {
        //
    }

    public function change_attr(Request $request){
        $site = Site::find($request->id);
        $site->is_show = !$request->is_show;
        $site->save();
    }
}
