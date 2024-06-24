<?php

use App\Controller\TestController;
use Nightfall\Http\Router\Route;

Route::get('/home', [TestController::class, 'index']);