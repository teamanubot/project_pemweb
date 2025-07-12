<?php

use App\Http\Controllers\SubmissionDownloadController;
use App\Http\Controllers\SyllabusDownloadController;
use App\Livewire\MainPage;
use App\Livewire\BlogPage;
use Illuminate\Support\Facades\Route;
use Livewire\Livewire;
use App\Models\Submission;
use Illuminate\Support\Facades\Storage;

/* NOTE: Do Not Remove
/ Livewire asset handling if using sub folder in domain
*/
Livewire::setUpdateRoute(function ($handle) {
    return Route::post(config('app.asset_prefix') . '/livewire/update', $handle);
});

Livewire::setScriptRoute(function ($handle) {
    return Route::get(config('app.asset_prefix') . '/livewire/livewire.js', $handle);
});
/*
/ END
*/
// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/',MainPage::class)->name('home');
Route::get('/blog', BlogPage::class)->name('blog');

Route::get('/submission-download/{filename}', SubmissionDownloadController::class)
    ->name('submission.download');

Route::get('/syllabus-download/{filename}', SyllabusDownloadController::class)
    ->name('syllabus.download');

use App\Http\Controllers\MidtransDemoController;

Route::get('/demo', [MidtransDemoController::class, 'form'])->name('demo.form');
Route::post('/demo/token', [MidtransDemoController::class, 'token'])->name('demo.token');

