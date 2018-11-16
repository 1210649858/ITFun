<?php

namespace App\Http\Controllers\Admin;

use App\Models\Advert;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdvertController extends Controller
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
            if ($request->has('advert_node_id') and $request->advert_node_id != '') {
                $search =$request->advert_node_id;
                $query->where('advert_node_id', 'like', $search);
            }
        };
        $adverts =Advert::with('advert_node','photo')->orderBy('sort')->where($where)->where($category)->paginate(5);
        return response()->json($adverts);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }

}
