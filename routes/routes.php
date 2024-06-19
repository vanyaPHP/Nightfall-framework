<?php

use App\Controller\TestController;
use Nightfall\Http\Router\Route;

Route::get('/home/{name}', [TestController::class, 'show']);
Route::get('/home', [TestController::class, 'index']);