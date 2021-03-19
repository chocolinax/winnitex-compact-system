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

// This endpoint does not need authentication.
// ...

// These endpoints require a valid access token.
Route::middleware('jwt')->post('/modules/get', function (Request $request) {

    $validator = Validator::make($request->all(), [
        'role' => 'required|array'
    ]);

    if ($validator->fails()) {
        $response = $validator->messages();
    } else {
        if (in_array("Domain Admins", $request->role)) {
            $response = System::find(1)->modules;
        } else {
            $response = System::find(1)->modules->where();
        }
    }

    return $response;
});

Route::middleware('jwt')->get('/pantry_items/get', function (Request $request) {
    return PantryItem::all();
});

Route::middleware('jwt')->post('/pantry_items/add', function (Request $request) {

    $validator = Validator::make($request->all(), [
        'code' => 'required|unique:pantry_items,code',
        'product' => 'required',
        'manufacturer' => 'required',
        'best_before' => 'required|date'
    ]);

    if ($validator->fails()) {
        $response = $validator->messages();
    } else {
        $response = PantryItem::create([
            'code' => $request->code,
            'product' => $request->product,
            'manufacturer' => $request->manufacturer,
            'best_before' => $request->best_before,
        ]);
    }

    return $response;
});

Route::middleware('jwt')->post('/pantry_items/del', function (Request $request) {

    $validator = Validator::make($request->all(), [
        'code' => 'required'
    ]);

    if ($validator->fails()) {
        $response = $validator->messages();
    } else {
        $response = PantryItem::where([
            'code' => $request->code
        ])->delete();
    }

    return $response;
});


// These endpoints require a valid access token with a "read:messages" scope.
Route::middleware('check.scope:read:messages')->post('/module/create', function (Request $request) {

    $validator = Validator::make($request->all(), [
        'name' => 'required',
        'allow_role' => 'required|array'
    ]);

    if ($validator->fails()) {
        $response = $validator->messages();
    } else {
        $sys = System::firstOrCreate();

        $response = Module::create([
            'name' => $request->name,
            'allow_role' => $request->allow_role
            'system_id' => $sys->id
        ]);
    }

    return $response;
});
