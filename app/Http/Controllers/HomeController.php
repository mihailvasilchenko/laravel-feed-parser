<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Services\Feed;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Feed $feed)
    {
        $this->middleware('auth');
        $this->feed = $feed;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $feed = $this->feed->parse(config('feeds.url'));
        return view('home', ['feed' => $feed]);
    }

}
