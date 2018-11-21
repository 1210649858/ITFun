<?php

namespace App\Http\Controllers\Admin;

use App\Models\Advert;
use App\Models\Photo;
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
        $adverts =Advert::with('advert_node','photo')->orderBy('sort','desc')->where($where)->where($category)->paginate(5);
        return response()->json($adverts);
    }

    public function store(Request $request)
    {
        $advert =Advert::create($request->all());
        return response()->json($advert);
    }

    public function edit($id)
    {
        $advert =Advert::with('photo')->find($id);
        return response()->json($advert);
    }

    public function update(Request $request, $id)
    {
        $advert =Advert::find($id);
        $advert->update($request->all());
    }

    public function destroy($id)
    {
        $advert =Advert::find($id);
        Advert::destroy($id);
        Photo::destroy($advert->photo_id);
    }

    //排序
    public function change_sort(Request $request )
    {
        $advert =Advert::find($request->id);
        $advert ->sort= $request ->sort;
        $advert ->save();
    }
}
