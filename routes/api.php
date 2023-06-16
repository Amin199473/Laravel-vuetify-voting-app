<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\IdeaController;
use App\Http\Controllers\Api\IdeaFilterController;
use App\Http\Controllers\Api\StatusController;
use App\Http\Controllers\CommentController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
 */

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::middleware('auth:api')->group(function () {
    Route::get('/logout', [AuthController::class, 'logout']);
    Route::post('/idea/store', [IdeaController::class, 'store'])->name('idea.store');
    Route::get('/idea/{idea:slug}/vote', [IdeaController::class, 'vote'])->name('idea.vote');
    Route::get('/idea', [IdeaController::class, 'index'])->name('idea.index')->withoutMiddleware('auth:api');
    Route::get('/idea/{idea:slug}', [IdeaController::class, 'show'])->name('idea.show');
    Route::put('/idea/{idea:slug}', [IdeaController::class, 'update'])->name('idea.update');
    Route::delete('/idea/{idea:slug}', [IdeaController::class, 'destroy'])->name('idea.delete');
    Route::get('/status', [StatusController::class, 'index'])->name('status.index');
    Route::post('/idea/updateStatus', [StatusController::class, 'updateStatus'])->name('updateStatus');
    Route::get('/idea/comments/{slug}',[CommentController::class,'getComments'])->withoutMiddleware('auth:api');
    Route::post('/add/comment/{slug}',[CommentController::class,'store']);
    Route::put('/comment/{comment:id}',[CommentController::class,'update']);
    Route::delete('/comment/{comment:id}',[CommentController::class,'destroy']);
});

Route::get('/category', [CategoryController::class, 'index'])->name('category.index');
Route::get('/ideasCountBasedOntheirStatus', [IdeaFilterController::class, 'ideasCountBasedOntheirStatus'])->name('ideasCountBasedOntheirStatus');
Route::post('/filteringIdeasBasedOnTheirStatuses', [IdeaFilterController::class, 'filteringIdeasBasedOnTheirStatuses'])->name('filteringIdeasBasedOnTheirStatuses');
Route::post('/filteringIdeasBasedOnTheirCategories', [IdeaFilterController::class, 'filteringIdeasBasedOnTheirCategories'])->name('filteringIdeasBasedOnTheirCategories');
Route::post('/filteringIdeasBasedOnOtherFilters', [IdeaFilterController::class, 'filteringIdeasBasedOnOtherFilters'])->name('filteringIdeasBasedOnOtherFilters');
Route::post('/filteringIdeasBasedOnIdeaTitle', [IdeaFilterController::class, 'filteringIdeasBasedOnIdeaTitle'])->name('filteringIdeasBasedOnIdeaTitle');
