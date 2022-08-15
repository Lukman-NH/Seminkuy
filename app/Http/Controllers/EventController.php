<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Python\PythonController;

use\App\Category;
use\App\Event;
use\App\Rating;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class EventController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {   
        $categories = Category::all();

        if (Auth::user()) {
            $categories = Category::all();
        } else {
            $categories = Category::where('name', '!=', 'Rekomendasi')->get();
        }

        $events = Event::with(['galleries'])->paginate(20);

        return view('pages.event',[
            'categories' => $categories,
            'events' => $events
        ]);
    }
    
    public function detail (Request $request, $slug)
    {
        $categories = Category::all();
        $category   = Category::where('slug', $slug)->firstOrFail();

        if (Auth::user()) {
            $categories = Category::all();

            if ($slug === 'rekomendasi') {
                // Execute python script and set data recommender to session
                (new PythonController)->export();
                (new PythonController)->index();

                $events = $request->session()->get('recommender');
            } else {
                $events = $request->session()->forget('recommender');
                $events = Event::where('categories_id', $category->id)->get();
            }
        } else {
            $categories  = Category::where('name', '!=', 'Rekomendasi')->get();
            $events = $request->session()->forget('recommender');
            $events = Event::where('categories_id', $category->id)->get();
        }

        return view('pages.event',[
            'categories' => $categories,
            'category' => $category,
            'events' => $events
        ]);
    }
}
