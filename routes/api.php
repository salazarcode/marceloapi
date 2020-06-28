<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Laravel\Passport\Http\Middleware\CheckClientCredentials;

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


Route::post('usuarios','UsuariosController@Create');
Route::post('login','UsuariosController@Login');
Route::get('usuarios/verify/{token}','UsuariosController@VerifyToken');




Route::middleware(['auth:api'])->group(function () {
    Route::post('dominios','DominiosController@Create');
    Route::get('dominios/{id?}','DominiosController@Get');
    Route::post('dominios/{id}/add','DominiosController@Add');
    Route::delete('dominios/{dominio_id}','DominiosController@RemoveDominio');
    Route::delete('dominios/{dominio_id}/{valor_id}','DominiosController@RemoveValor');


    Route::get('logout','UsuariosController@Logout');
    Route::delete('usuarios/{usuario_id}','UsuariosController@Delete');
    Route::get('usuarios/{id?}','UsuariosController@Get');
});