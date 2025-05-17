<?php

use App\Http\Controllers\DomainController;
use App\Http\Controllers\InstituteController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\student\AssessmentController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Resource Route are define here
    Route::resource('domain', DomainController::class);
    Route::resource('section', SectionController::class);
    Route::resource('question', QuestionController::class);
    Route::get('domain/{id}/sections', [QuestionController::class, 'getSections'])->name('domain.sections');


    Route::get('/assessment', [AssessmentController::class, 'index'])->name('assessment.index');
    Route::get('/assessment/domain/{id}', [AssessmentController::class, 'index'])->name('assessment.domain.view');
    Route::post('assessment/store', [AssessmentController::class, 'store'])->name('assessment.store');

    Route::get('/assessment/result', [AssessmentController::class, 'result'])->name('assessment.result');

    //Institutes
    Route::get('/institute', [InstituteController::class, 'index'])->name('institute.index');
    Route::get('/institute/create', [InstituteController::class, 'create'])->name('institute.create');
    Route::post('/institute/store', [InstituteController::class, 'store'])->name('institute.store');
    Route::get('/institute/{id}/edit', [InstituteController::class,'edit'])->name('institute.edit');
    Route::patch('/institute/{id}/update', [InstituteController::class,'update'])->name('institute.update');

});

require __DIR__ . '/auth.php';
