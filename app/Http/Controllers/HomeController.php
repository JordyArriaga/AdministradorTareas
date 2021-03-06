<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        $tareas =  DB::table('tareas')
                ->where('idUser', '=', Auth()->user()->id)
                ->where('deleted_at', '=', null)
                ->get();
        if($tareas == "[]"){
            $tareas = null;
        }
        return view('home', compact('tareas'));
    }
}
