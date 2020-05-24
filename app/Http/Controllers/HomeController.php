<?php

namespace App\Http\Controllers;

use App\Category;
use App\Event;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('calendar');
    }

    public function listCategories()
    {
        $categories = Category::get();
        return view('categories', compact('categories'));
    }

    public function showCalendar()
    {
        $categories = Category::get();
        $events = DB::table('events')
            ->join('categories', 'categories.id', '=', 'events.category_id')
            ->select('events.id', 'events.title', 'events.description', 'events.link', 'events.start_time AS startTime', 'events.end_time AS endTime', 'events.days_of_week AS daysOfWeek', 'events.minimum_age', 'events.maximum_age', 'events.dfe_approved', 'events.requires_supervision', 'categories.category', 'categories.colour')
            ->get();
        $data = [
            'categories' => $categories,
            'events' => $events
        ];
        return view('calendar', compact('data'));
    }

}
