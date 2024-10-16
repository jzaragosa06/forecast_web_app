<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InputFileGraphController;
use App\Http\Controllers\LLMController;
use App\Http\Controllers\LogController;
use App\Http\Controllers\ManageOperationsController;
use App\Http\Controllers\ManageResultsUsingCRUDController;
use App\Http\Controllers\ManageShowResultsController;
use App\Http\Controllers\NotesController;
use App\Http\Controllers\PreprocessInputFileController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RenderImageController;
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


Route::prefix('upload')->group(function () {
    Route::post('/time-series', [PreprocessInputFileController::class, 'preprocess_fillna'])->name('upload.ts');
    Route::post('/save/time-series', [SaveInputController::class, 'save'])->name('save');

});

Route::prefix('analyze')->group(function () {
    Route::post('/time-series', action: [ManageOperationsController::class, 'manage'])->name('manage.operations');

});


Route::prefix('results')->group(function () {
    Route::post('/view/{file_assoc_id}', [ManageShowResultsController::class, 'manage'])->name('manage.results.post');
    Route::get('/view/results/{file_assoc_id}', [ManageShowResultsController::class, 'manage'])->name('manage.results.get');

});

Route::prefix('files')->group(function () {
    Route::get('/', action: [ManageResultsUsingCRUDController::class, 'index'])->name('crud.index');
    Route::post('/results/delete/{file_assoc_id}', action: [ManageResultsUsingCRUDController::class, 'delete_file_assoc'])->name('crud.delete.file_assoc');
    Route::post('/inputs/delete/{file_id}', action: [ManageResultsUsingCRUDController::class, 'delete_file'])->name('crud.delete.file');
    Route::get('input/view/{file_id}', [InputFileGraphController::class, 'index'])->name('input.file.graph.view.get');
    Route::post('input/view/{file_id}', [InputFileGraphController::class, 'index'])->name('input.file.graph.view.post');

});



Route::prefix('profile')->group(function () {
    Route::get('/', [ProfileController::class, 'index'])->name('profile.index');
    Route::post('/update/photo', [ProfileController::class, 'update_photo'])->name('profile.update.photo');
});


Route::prefix('llm')->group(function () {
    Route::post('/ask', [LLMController::class, 'ask'])->name('llm.ask');
    Route::post('/save', [LLMController::class, 'save'])->name('llm.save');
});

Route::prefix('notes')->group(function () {
    Route::post('/save', [NotesController::class, 'save'])->name('notes.save');

});

Route::prefix('sequence-alignment/series-alignment')->group(function () {
    Route::post('/index/{file_id}', [TSSeqAlController::class, 'index'])->name('seqal.index');
    Route::post('/save_preprocess_fillna_seqal', [TSSeqAlController::class, 'save_preprocess_fillna_seqal'])->name('seqal.save_preprocess');
    Route::get('/multi/show', [TSSeqAlController::class, 'showMultivariateData'])->name('seqal.multi');
    Route::post('/temp/save', [TSSeqAlController::class, 'temporary_save'])->name('seqal.tempsave');
    Route::get('/preprocess/{id}', [TSSeqAlController::class, 'to_graph_for_preprocessing'])->name('seqal.preprocess');

});


Route::prefix('logs')->group(function () {
    Route::get('/', [LogController::class, 'index'])->name('logs.index');

});

Route::prefix('share')->group(function () {
    Route::post('/with_other', [ShareController::class, 'shareFileWithUsers'])->name('share.with_other');
    Route::get('/view/{file_assoc_id}/{user_id}', [ShareController::class, 'view_shared_file'])->name('share.view_file');
    Route::get('/', [ShareController::class, 'index'])->name('share.index');

});


Route::prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/users', [AdminController::class, 'users'])->name('admin.users');
    Route::get('/data-source/external', [AdminController::class, 'data_source'])->name('admin.data-source');
    Route::get('/open-meteo', [AdminController::class, 'open_meteo'])->name('admin.open_meteo');
    Route::get('/stocks', [AdminController::class, 'stocks'])->name('admin.stocks');
    Route::post('/users/delete/{id}', [AdminController::class, 'delete'])->name('admin.delete');
    Route::post('/update-options/open-meteo', [AdminController::class, 'update_options_open_meteo'])->name('admin.update_options_open_meteo');
    Route::post('/update-options/stocks', [AdminController::class, 'update_options_stocks'])->name('admin.update_options_stocks');

});



// ============================================================================================================================================================



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




Route::get('/response', function () {
    return view('response');
});



Route::get('/render', [RenderImageController::class, 'render']);
Route::post('/save-chart-image', [RenderImageController::class, 'saveChartImage']);

Route::get('/terms', function () {
    $termsHtml = file_get_contents(resource_path('views/auth/terms.html'));
    return view('terms', compact('termsHtml'));
})->name('terms');