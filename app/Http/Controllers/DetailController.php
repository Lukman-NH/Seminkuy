<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Event;
use App\Cart;
use Illuminate\Support\Facades\Auth;

class DetailController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request, $id)
    {
        $event = Event::with(['galleries'])->where('slug', $id)->firstOrFail();

        return view('pages.detail', [
            'event' => $event
        ]);
    }

    public function add(Request $request, $id)
    {
        $data = [
            'events_id' => $id,
            'users_id' => Auth::user()->id,
        ];

        Cart::create($data);

        return redirect()->route('cart');
    }
}
