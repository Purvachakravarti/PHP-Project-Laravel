<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Task;

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
        $user = auth()->user();
        $tasks = Task::where('user_id','=',$user->id)->orderBy('created_at', 'asc')->get();

        // return view('home');
        return view('home', [
            'tasks' => $tasks
        ]);
    }
}
