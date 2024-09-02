<?php

use App\Http\Controllers\ManageOperationsController;
use App\Http\Controllers\PreprocessInputFileController;
use App\Http\Controllers\SaveInputController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::post('upload/ts', [PreprocessInputFileController::class, 'preprocess_fillna'])->name('upload.ts');
Route::post('save/ts', [SaveInputController::class, 'save'])->name('save');
Route::post('manage/operations', [ManageOperationsController::class, 'manage'])->name('manage.operations');

