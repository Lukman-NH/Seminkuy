<?php

namespace App\Http\Controllers;

use App\Rating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use RealRashid\SweetAlert\Facades\Alert;

class RatingController extends Controller
{
    public function add(Request $request)
    {
        $rating = $request->input('event_rating');
        $event_id = $request->input('event_id');


        $rated = Rating::where('users_id', Auth::user()->id)->where('events_id', $event_id)->first();
        if($rated) {
            $rated->rating = $rating;
            $rated->update();
        } 
        else{
            $data = [
                'users_id' => Auth::user()->id,
                'events_id' => $event_id,
                'rating' => $rating
            ];
            
            Rating::create($data);
        }

        alert()->success('Success', 'Thank you for Rate this Event');

        return redirect()
            ->back();
    }
}
