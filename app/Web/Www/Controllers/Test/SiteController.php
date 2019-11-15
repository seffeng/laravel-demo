<?php

namespace App\Web\Www\Controllers\Test;

use App\Common\Base\Controller;

class SiteController extends Controller
{
    public function index()
    {
        var_dump('www.index', config('app.name'));
    }

    public function home()
    {
        return view('home');
    }
}
