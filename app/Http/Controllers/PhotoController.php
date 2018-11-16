<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Photo;

class PhotoController extends Controller
{
    public function store(Request $request)
    {
        if ($request->hasFile('file') and $request->file('file')->isValid()) {

            //数据验证
            $allow = array('image/jpeg', 'image/png', 'image/gif');

            $mine = $request->file('file')->getMimeType();
            if (!in_array($mine, $allow)) {
                return response()->json(['status' => 0, 'msg' => '文件类型错误，只能上传图片']);
            }

            //文件大小判断$filePath
            $max_size = 1024 * 1024 * 3;
            $size = $request->file('file')->getClientSize();
            if ($size > $max_size) {
                return response()->json(['status' => 0, 'msg' => '文件大小不能超过3M']);
            }

            //original图片
            $path = $request->file->store('public/images');

            //绝对路径
            $file_path = storage_path('app/') . $path;

            //保存到七牛
            qiniu_upload($file_path);

            //插入图片表
            $photo = Photo::create(['image' => 'http://qiniu.wenflush.com/' . basename($file_path)]);
            return ['photo_id' => $photo->id, 'image' => basename($file_path), 'image_url' => 'http://qiniu.wenflush.com/' . basename($file_path)];
        }
    }
}
