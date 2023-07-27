<?php

namespace App\Http\Controllers;

use App\Jobs\LaravelQueueMailJob;
use App\Mail\TaskAssigned;
use App\Models\Todo;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class TodoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(
            Todo::where('assigned_to', Auth::user()->id)
                ->orWhere('status', 0)
                ->get()
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //return response()->json($request->assigned_to);

        $data = [
            'title' => $request->title,
            'description' => $request->description,
            'deadline' => $request->deadline,
            'assigned_to' => !empty($request->assigned_to) ? $request->assigned_to : Auth::user()->id,
        ];

        //return response()->json($data);

        $todo = Todo::create($data);

        if(!empty($request->assigned_to)){
            // Send email notification to the assignee
            $user = User::findOrFail($request->assigned_to);

            //return response()->json($user);


            dispatch(new LaravelQueueMailJob($user, $todo));
        }

        return response()->json($todo);
    }

    /**
     * Display the specified resource.
     */
    public function show(Todo $todo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Todo $todo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Todo $todo)
    {
        $todo->update($request->all());

        return response()->json($todo);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Todo $todo)
    {
        $todo->delete();

        return response()->json('Success!');
    }
}
