<?php

use App\Http\Controllers\BabyController;
use App\Http\Controllers\MealController;
use App\Http\Controllers\ParentInviteController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware(['auth:sanctum'])->group(function () {
    Route::resource('babies', BabyController::class);
    Route::post('babies/{baby}/meals', [BabyController::class, 'addMeal']);
    Route::put('babies/{baby}/meals/{meal}', [BabyController::class, 'updateMeal']);
    Route::get('babies/{baby}/parents', [BabyController::class, 'getParents']);
    Route::post('babies/{baby}/inviteParent', [BabyController::class, 'invite']);
    Route::delete('babies/{baby}/invite/{invite}', [BabyController::class, 'deleteInvite']);

    Route::post('parentInvites/{invite}/accept', [ParentInviteController::class, 'accept']);
    Route::post('parentInvites/{invite}/decline', [ParentInviteController::class, 'decline']);

    Route::get('user/invites', [UserController::class, 'invites']);
});

require __DIR__.'/auth.php';
