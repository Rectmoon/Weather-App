<?php
use Illuminate\Http\Request;
use Zttp\Zttp;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/weather', function () {
    $key = config("services.darksky.key");
    $lat = request('lat');
    $lng = request('lng');

    $response = Zttp::get("https://api.darksky.net/forecast/$key/$lat,$lng?lang=zh&units=ca");

    return $response->json();
});
