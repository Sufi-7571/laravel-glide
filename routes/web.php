<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use League\Glide\Server;

Route::get('/', [UserController::class, 'index'])
    ->name('home');

Route::resource('users', UserController::class)->only([
    'index',
    'create',
    'store',
    'show',
    'destroy'
]);

// Glide image route
Route::get('img/{path}', function (Server $server, string $path) {
    return $server->getImageResponse($path, request()->all());
})->where('path', '.*')->name('glide');
