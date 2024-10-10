<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\GroupMenuController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\OptionMenuController;
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
    /**
     * PUBLIC ROUTES
     */
    Route::post('/login', [AuthController::class, 'login'])->name('login');

    Route::get('project', [ProjectController::class, 'index'])->name('projects.index');
    Route::get('project/{project}', [ProjectController::class, 'show'])->name('projects.show');
    Route::get('news', [NewsController::class, 'index'])->name('news.index');
    Route::get('news/{news}', [NewsController::class, 'show'])->name('news.show');
    Route::get('slider', [SliderController::class, 'index'])->name('slider.index');
    Route::get('slider/{slider}', [SliderController::class, 'show'])->name('slider.show');
    Route::get('contact', [ContactController::class, 'store'])->name('contact.store');

    /**
     * ADMIN ROUTES WITH AUTH
     */
    Route::group(['middleware' => ['auth:sanctum']], function () {

        Route::get('/authenticate', [AuthController::class, 'authenticate'])->name('authenticate');
        Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
        Route::get('/logs', [AuthController::class, 'logs'])->name('logs');

//        GROUP MENU
        Route::resource('groupmenu', GroupMenuController::class)->only(
            ['index', 'show', 'store', 'update', 'destroy']
        )->names(
            [
                'index' => 'groupmenu.index',
                'store' => 'groupmenu.store',
                'show' => 'groupmenu.show',
                'update' => 'groupmenu.update',
                'destroy' => 'groupmenu.destroy',
            ]
        );

//        OPTION MENU
        Route::resource('optionmenu', OptionMenuController::class)->only(
            ['index', 'show', 'store', 'update', 'destroy']
        )->names(
            [
                'index' => 'optionmenu.index',
                'store' => 'optionmenu.store',
                'show' => 'optionmenu.show',
                'update' => 'optionmenu.update',
                'destroy' => 'optionmenu.destroy',
            ]
        );

//    PROJECTS
        Route::post('project', [ProjectController::class, 'store'])->name('project.store');
        Route::post('project/update/{project}', [ProjectController::class, 'update'])->name('project.update');
        Route::delete('project/{project}', [ProjectController::class, 'destroy'])->name('project.destroy');

//    NEWS
        Route::post('news', [NewsController::class, 'store'])->name('news.store');
        Route::post('news/update/{news}', [NewsController::class, 'update'])->name('news.update');
        Route::delete('news/{news}', [NewsController::class, 'destroy'])->name('news.destroy');

//    SLIDER
        Route::post('slider', [SliderController::class, 'store'])->name('slider.store');
        Route::delete('slider/{slider}', [SliderController::class, 'destroy'])->name('slider.destroy');

//    CONTACT
        Route::resource('contact', ContactController::class)->only(
            ['index', 'show', 'update', 'destroy']
        )->names(
            [
                'index' => 'contact.index',
                'show' => 'contact.show',
                'update' => 'contact.update',
                'destroy' => 'contact.destroy',
            ]
        );

//        CATEGORIES
        Route::resource('category', CategoryController::class)->only(
            ['index', 'show', 'store', 'update', 'destroy']
        )->names(
            [
                'index' => 'category.index',
                'store' => 'category.store',
                'show' => 'category.show',
                'update' => 'category.update',
                'destroy' => 'category.destroy',
            ]
        );
    });
});
