<?php

namespace App\Http\Controllers\Admin;

use App\Models\Chapter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ChapterController extends Controller
{
    public function store(Request $request)
    {
        $chapter = Chapter::create($request->all());
        return response()->json($chapter);
    }

    public function edit($id)
    {
        $chapter = Chapter::find($id);
        return response()->json($chapter);
    }

    public function update(Request $request, $id)
    {
        $chapter = Chapter::find($id);
        $chapter->update($request->all());
    }

    public function destroy($id)
    {
        Chapter::destroy($id);
    }

    public function change_attr(Request $request)
    {
        $chapter = Chapter::find($request->id);
        $chapter->free = !$request->free;
        $chapter->save();
    }

    public function change_sort(Request $request)
    {
        $chapter = Chapter::find($request->id);
        $chapter->sort = $request->sort;
        $chapter->save();
    }
}
