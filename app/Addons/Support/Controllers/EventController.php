<?php

namespace App\Addons\Support\Controllers;

use App\Http\Controllers\Controller;

class EventController extends Controller
{
    public function index()
    {
        return view('Support::event.events')->render();
    }

    public function test()
    {
        $page_data = 'working';
        return view('Support::event.test')->render();
    }
}
