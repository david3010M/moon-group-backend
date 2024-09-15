<?php

use App\Http\Controllers\ContactController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\SliderController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});


Route::group([], function () {

//    PROJECTS
    Route::resource('project', ProjectController::class)->only(
        ['index', 'show', 'store', 'update', 'destroy']
    )->names(
        [
            'index' => 'projects.index',
            'store' => 'projects.store',
            'show' => 'projects.show',
            'update' => 'projects.update',
            'destroy' => 'projects.destroy',
        ]
    );

//    NEWS
    Route::resource('news', NewsController::class)->only(
        ['index', 'show', 'store', 'update', 'destroy']
    )->names(
        [
            'index' => 'news.index',
            'store' => 'news.store',
            'show' => 'news.show',
            'update' => 'news.update',
            'destroy' => 'news.destroy',
        ]
    );

//    SLIDER
    Route::resource('slider', SliderController::class)->only(
        ['index', 'show', 'store', 'update', 'destroy']
    )->names(
        [
            'index' => 'slider.index',
            'store' => 'slider.store',
            'show' => 'slider.show',
            'update' => 'slider.update',
            'destroy' => 'slider.destroy',
        ]
    );

//    CONTACT
    Route::resource('contact', ContactController::class)->only(
        ['index', 'show', 'store', 'update', 'destroy']
    )->names(
        [
            'index' => 'contact.index',
            'store' => 'contact.store',
            'show' => 'contact.show',
            'update' => 'contact.update',
            'destroy' => 'contact.destroy',
        ]
    );

});
