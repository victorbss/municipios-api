<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MunicipioController;

Route::get('/', function () {
    return 'hello world!';
    // return view('welcome');
});

Route::get('/ping', function () {
    return 'pong!';
});

Route::get('/api/municipios/{uf}', [MunicipioController::class, 'index']);