<?php

use App\Models\Device;
use App\Models\Module;
use App\Models\PantryItem;
use App\Models\System;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/tokens/create', function (Request $request) {

    $validator = Validator::make($request->all(), [
        'device_id' => 'required',
    ]);

    if ($validator->fails()) {
        $response = $validator->messages();
    } else {

        $user = Device::firstOrCreate([
            'device_id' => $request->device_id
        ]);

        $token = $user->createToken($request->device_id);

        $response = ['token' => $token->plainTextToken];
    }

    return $response;
});

Route::middleware('auth:sanctum')->get('/modules/get', function (Request $request) {
    $modules = System::find(1)->modules;
    return $modules;
});

Route::middleware('auth:sanctum')->get('/pantry_items/get', function (Request $request) {
    return PantryItem::all();
});



Route::post('/module/create', function (Request $request) {

    $validator = Validator::make($request->all(), [
        'name' => 'required',
    ]);

    if ($validator->fails()) {
        $response = $validator->messages();
    } else {
        $sys = System::firstOrCreate();

        $response = Module::create([
            'name' => $request->name,
            'system_id' => $sys->id
        ]);
    }

    return $response;
});


// This endpoint does not need authentication.
Route::get('/public', function (Request $request) {
    return response()->json(["message" => "Hello from a public endpoint! You don't need to be authenticated to see this."]);
});

// These endpoints require a valid access token.
Route::get('/private', function (Request $request) {
    return response()->json(["message" => "Hello from a private endpoint! You need to have a valid access token to see this."]);
})->middleware('jwt');

// These endpoints require a valid access token with a "read:messages" scope.
Route::get('/private-scoped', function (Request $request) {
    return response()->json([
        "message" => "Hello from a private endpoint! You need to have a valid access token and a scope of read:messages to see this."
    ]);
})->middleware('check.scope:read:messages');
