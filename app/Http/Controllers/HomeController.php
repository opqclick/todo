<?php

namespace App\Http\Controllers;

use App\Models\Todo;
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
        return view('home');
    }

    public function updateTaskStatus(Request $request, $id)
    {
        $task = Todo::findOrFail($id);

        if($task) {
            $task->status = 1;
            $task->save();
        }

        return response()->json($task);
    }
}
