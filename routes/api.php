<?php

use App\Models\Device;
use App\Models\Module;
use App\Models\ModuleAllowRole;
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
        'roles' => 'required|array'
    ]);

    if ($validator->fails()) {
        $response = $validator->messages();
    } else {
        $modules = System::find(1)->modules()->get();

        // $response = $modules->map(function ($module) use ($request) {
        //     $role_names = $module->roles()->select('name')->get()->map(function ($role) {
        //         return $role->name;
        //     });
        //     $result = array_intersect($request->roles, $role_names->toArray());
        //     if ($result == $role_names)
        //         return $module;
        // });
    }

    return $modules->find(3)->roles->map(function ($role) {
        return $role->get('name');
    });
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
// Route::middleware('check.scope:read:messages')->post('/module/create', function (Request $request) {
    Route::middleware('jwt')->post('/module/create', function (Request $request) {

    $validator = Validator::make($request->all(), [
        'name' => 'required|unique:modules,name',
        'allow_role' => 'required|array'
    ]);

    if ($validator->fails()) {
        $response = $validator->messages();
    } else {
        $sys = System::firstOrCreate();

        $module = Module::create([
            'name' => $request->name,
            'system_id' => $sys->id
        ]);

        foreach ($request->allow_role as $allow_role_name) {
            ModuleAllowRole::create([
                'name' => $allow_role_name,
                'module_id' => $module->id
            ]);
        }

        $response = Module::where('name', $request->name)->get();
    }

    return $response;
});
