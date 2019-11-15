<?php

namespace App\Web\Admin\Controllers\Test;

use App\Common\Base\Controller;

class SiteController extends Controller
{
    public function index()
    {
        var_dump('admin.index', config('app.name'));
    }

    public function home()
    {
        return view('home');
    }
}
