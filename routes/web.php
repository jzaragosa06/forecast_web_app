<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\InputFileGraphController;
use App\Http\Controllers\LLMController;
use App\Http\Controllers\ManageOperationsController;
use App\Http\Controllers\ManageResultsUsingCRUDController;
use App\Http\Controllers\ManageShowResultsController;
use App\Http\Controllers\NotesController;
use App\Http\Controllers\PreprocessInputFileController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SaveInputController;
use App\Http\Controllers\ShareController;
use App\Http\Controllers\TSSeqAlController;
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
})->name('welcome');

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
Route::post('/llm/ask', [LLMController::class, 'ask'])->name('llm.ask');
Route::post('/llm/save', [LLMController::class, 'save'])->name('llm.save');

Route::post('/notes/save', [NotesController::class, 'save'])->name('notes.save');
Route::post('/ts/seq_al/index/{file_id}', [TSSeqAlController::class, 'index'])->name('seqal.index');
Route::post('/ts/seq_al/save_preprocess_fillna_seqal', [TSSeqAlController::class, 'save_preprocess_fillna_seqal'])->name('seqal.save_preprocess');
// Route::post('/ts/seq_al/to_graph', [TSSeqAlController::class, 'to_multi_preprocess'])->name('seqal.to_graph');
Route::get('/ts/seq_al/multi', [TSSeqAlController::class, 'showMultivariateData'])->name('seqal.multi');


Route::post('/share/with_other', [ShareController::class, 'shareFileWithUsers'])->name('share.with_other');

Route::post('/ts/seq_al/temp/save', [TSSeqAlController::class, 'temporary_save'])->name('seqal.tempsave');
Route::get('ts/seq_al/preprocess/{id}', [TSSeqAlController::class, 'to_graph_for_preprocessing'])->name('seqal.preprocess');


Route::get('/test_base', function () {
    return view('test_base');
});

Route::get('/test_child', function () {
    return view('child_test');
});


Route::get('/test_date_parse', function () {
    return view('uploadData.draft_test_parse_date');
});

Route::get('/fetch-data', function () {
    return view('fetchData.index');
});

Route::get('/landing', function () {
    return view('landing');
});


Route::get('/flowchart', function () {
    return view('flowchart_test');
});


Route::get('/carousel', function () {
    return view('carousel');
});

Route::get('/alignment', function () {
    return view('alignement');
});


