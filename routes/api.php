

<?php

use App\Http\Controllers\Api\TaskController;
use App\Http\Controllers\Api\UserAuthController;
use Illuminate\Support\Facades\Route;


// Route::get('task',[TaskController::class,'index'])->name('task.index');
// Route::get('task/{task}/show',[TaskController::class,'show'])->name('task.show');


// Route::apiResource('tasks', TaskController::class)->only(['index', 'show', 'store','update','destroy']);

Route::get('user', [UserAuthController::class, 'index']);
Route::post('user/register', [UserAuthController::class, 'register']);
Route::post('user/login', [UserAuthController::class, 'login']);


Route::middleware('auth:sanctum')->group(function () {
    Route::get('user/loggedin', [UserAuthController::class, 'loggedinUser']);
    Route::apiResource('tasks', TaskController::class);
    Route::post('user/logout', [UserAuthController::class, 'logout']);
});




// Route::apiResource('examples', ExampleController::class);
