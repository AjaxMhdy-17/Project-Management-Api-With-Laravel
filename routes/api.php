

<?php

use App\Http\Controllers\ExampleController;
use App\Http\Controllers\TaskController;
use App\Http\Resources\Api\TaskResources;
use Illuminate\Support\Facades\Route;


// Route::get('task',[TaskController::class,'index'])->name('task.index');
// Route::get('task/{task}/show',[TaskController::class,'show'])->name('task.show');


// Route::apiResource('tasks', TaskController::class)->only(['index', 'show', 'store','update','destroy']);
Route::apiResource('tasks', TaskController::class);

// Route::apiResource('examples', ExampleController::class);
