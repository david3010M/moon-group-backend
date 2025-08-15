<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// routes/web.php
Route::get('/_imagick_check', function () {
    $ok = class_exists(\Imagick::class);
    $ver = $ok ? (new \Imagick())->getVersion() : null;
    return response()->json([
        'sapi' => php_sapi_name(),
        'php' => PHP_VERSION,
        'ini' => php_ini_loaded_file(),
        'imagick' => $ok,
        'imagick_version' => $ver['versionString'] ?? null,
        'imagick_build' => $ver['releaseDate'] ?? null,
        'gd' => extension_loaded('gd'),
    ]);
});

Route::get('/_limits', fn() => [
    'sapi' => php_sapi_name(),
    'post_max_size' => ini_get('post_max_size'),
    'upload_max_filesize' => ini_get('upload_max_filesize'),
    'max_file_uploads' => ini_get('max_file_uploads'),
]);

