<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\TodoController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::middleware(['auth'])->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    Route::get('/todo', function (){
        return view('todo');
    })->name('todo');

    Route::resource('api/todos', TodoController::class);
    Route::post('api/update-task-status/{id}', [HomeController::class, 'updateTaskStatus'])->name('update.task.status');
    Route::resource('api/users', UserController::class, ['only' => ['index']]);

});