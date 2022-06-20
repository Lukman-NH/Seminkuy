<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use\App\Event;

class HomeController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $events = Event::with(['galleries'])->take(4)->latest()->get();

        return view('pages.home',[
            'events' => $events
        ]);
    }
}
