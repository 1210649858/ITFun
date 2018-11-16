<?php

namespace App\Http\Controllers\Admin;

use App\Models\Advert;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        //dd('后台首页，当前管理员：' . auth('admin')->user()->name);
        return view('admin.home');

    }
}
