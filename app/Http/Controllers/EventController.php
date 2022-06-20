<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use\App\Category;
use\App\Event;

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
        $events = Event::with(['galleries'])->paginate(20);

        return view('pages.event',[
            'categories' => $categories,
            'events' => $events
        ]);
    }
    public function detail(Request $request, $slug)
    {
        $categories = Category::all();
        $category = Category::where('slug', $slug)->firstOrFail();
        $events = Event::where('categories_id', $category->id)->paginate($request->input('limit', 12));

        return view('pages.event',[
            'categories' => $categories,
            'category' => $category,
            'events' => $events
        ]);
    }
}
