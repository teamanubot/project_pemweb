<?php

use App\Http\Controllers\ModuleDownloadController;
use App\Http\Controllers\QuizDownloadController;
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

Route::get('/module-download/{filename}', ModuleDownloadController::class)
    ->name('module.download');

Route::get('/quiz-download/{filename}', QuizDownloadController::class)
    ->name('quiz.download');

use App\Http\Controllers\MidtransController;

Route::get('/register', [MidtransController::class, 'form'])->name('register.form');
Route::post('/register/token', [MidtransController::class, 'token'])->name('register.token');
Route::post('/payment/callback', [MidtransController::class, 'handleSuccess'])->name('register.callback');
Route::post('/otp-generate', [MidtransController::class, 'generateOtp'])->name('otp.generate');