<?php

use App\Models\Device;
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

        $token = !$user->currentAccessToken()?:$user->createToken($request->device_id);

        $response = ['token' => $token->plainTextToken];
    }

    return $response;
});
