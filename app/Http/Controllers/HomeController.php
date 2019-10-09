<?php

namespace Streamcms\Http\Controllers;

use Illuminate\Http\Request;

use Streamcms\Models\Keyword;
use Streamcms\Models\Medicine;
use Streamcms\Models\Info;
use Streamcms\Models\Tips;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }
}
