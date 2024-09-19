<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\InputFileGraphController;
use App\Http\Controllers\ManageOperationsController;
use App\Http\Controllers\ManageResultsUsingCRUDController;
use App\Http\Controllers\ManageShowResultsController;
use App\Http\Controllers\PreprocessInputFileController;
use App\Http\Controllers\ProfileController;
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
Route::post('manage/operations', action: [ManageOperationsController::class, 'manage'])->name('manage.operations');
Route::post('manage/results/{file_assoc_id}', [ManageShowResultsController::class, 'manage'])->name('manage.results.post');
Route::get('manage/results/{file_assoc_id}', [ManageShowResultsController::class, 'manage'])->name('manage.results.get');


Route::get('/manage/results/crud/show', action: [ManageResultsUsingCRUDController::class, 'index'])->name('crud.index');
// Route::post('/manage/results/crud/view/{file_assoc_id}', action: [ManageResultsUsingCRUDController::class, 'view'])->name('crud.view');
Route::post('/manage/results/crud/delete/file_assoc/{file_assoc_id}', action: [ManageResultsUsingCRUDController::class, 'delete_file_assoc'])->name('crud.delete.file_assoc');
Route::post('/manage/results/crud/delete/file/{file_id}', action: [ManageResultsUsingCRUDController::class, 'delete_file'])->name('crud.delete.file');
Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
Route::post('/profile/update/photo', [ProfileController::class, 'update_photo'])->name('profile.update.photo');

Route::get('inputFileGraph/view/{file_id}', [InputFileGraphController::class, 'index'])->name('input.file.graph.view.get');
Route::post('inputFileGraph/view/{file_id}', [InputFileGraphController::class, 'index'])->name('input.file.graph.view.post');

Route::get('/test_date_parse', function () {
    return view('uploadData.draft_test_parse_date');
});

Route::get('/fetch-data', function () {
    return view('fetchData.index');
});





