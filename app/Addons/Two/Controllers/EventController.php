<?php

namespace App\Addons\Two\Controllers;

use App\Http\Controllers\Controller;

class EventController extends Controller
{
    public function events()
    {
        return view('Two::event.events')->render();
    }
}
