<?php

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


//listar categotias 
route::get('categories','App\Http\Controllers\CategoryController@index');

//obtener categoria
route::get('category/{id}','App\Http\Controllers\CategoryController@show');

//nueva categoria 
route::post('category','App\Http\Controllers\CategoryController@store');

//editar categoria
route::put('category','App\Http\Controllers\CategoryController@store');

//eliminar categoria
route::delete('category/{id}','App\Http\Controllers\CategoryController@destroy');




