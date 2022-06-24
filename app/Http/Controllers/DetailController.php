<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Rating;
use App\Event;
use App\Cart;
use App\Users;
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
        $event_rating = Rating::where('events_id', $event->id)->get();
        $rating_review = Rating::where('events_id', $event->id)->take(3)->latest()->get();
        $rating_sum = Rating::where('events_id', $event->id)->sum('rating');
        if ($event_rating->count() > 0)
        {
            $rating_value = $rating_sum/$event_rating->count();
        }
        else
        {
            $rating_value = 0;
        }

        return view('pages.detail', [
            'event' => $event,
            'event_rating' => $event_rating,
            'rating_value' => $rating_value,
            'rating_review' => $rating_review
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
