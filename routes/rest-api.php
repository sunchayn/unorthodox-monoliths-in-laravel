<?php

use App\Http\RestApi\ExampleController;
use Illuminate\Support\Facades\Route;

Route::get('/test', ExampleController::class);

Route::get('/test/exception', fn () => throw new RuntimeException('Test Exception'));
