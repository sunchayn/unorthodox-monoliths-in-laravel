<?php

use App\Http\Monolith\ExampleController;
use Illuminate\Support\Facades\Route;

Route::get('/test', ExampleController::class);

Route::get('/test/exception', fn () => throw new RuntimeException('Test Exception'));

Route::get('/fuse/normal', [\App\Http\Monolith\FuseController::class, 'normal']);
Route::get('/fuse/has-errors', [\App\Http\Monolith\FuseController::class, 'errors']);

Route::get('/test/query', \App\Http\Monolith\QueryController::class);
