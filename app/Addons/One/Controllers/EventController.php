<?php

namespace App\Addons\One\Controllers;

use App\Http\Controllers\Controller;

class EventController extends Controller
{
    public function index()
    {
        return view('One::event.events')->render();
    }
}
