<?php
// 引入鉴权类
use Qiniu\Auth;
// 引入上传类
use Qiniu\Storage\UploadManager;

function qiniu_upload($filePath){
    // 需要填写你的 Access Key 和 Secret Key
    $accessKey ="hOPgEqWYzvdobslsnnQZPueFJY0y8mtqvDDPG_fh";
    $secretKey = "kIIlfrw5ZzQHe1n2mIJX_Xwd3Z5uxKCMAn7EfTEQ";
    $bucket = "shop";
// 构建鉴权对象
    $auth = new Auth($accessKey, $secretKey);
// 生成上传 Token
    $token = $auth->uploadToken($bucket);
// 上传到七牛后保存的文件名
    $key = basename($filePath);
// 初始化 UploadManager 对象并进行文件的上传。
    $uploadMgr = new UploadManager();
// 调用 UploadManager 的 putFile 方法进行文件的上传。
    $uploadMgr->putFile($token, $key, $filePath);
    //unlink($filePath);
}

