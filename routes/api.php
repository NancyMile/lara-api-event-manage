<?php

use App\Http\Controllers\Api\EventController;
use App\Models\Attendee;
use Illuminate\Http\Request;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource('events',EventController::class);
Route::apiResource('events.attendees',Attendee::class)
 ->scoped(['attendee' => 'event']);  //looks only for attendees of a current event, the route requires both parameters the event and attendee
