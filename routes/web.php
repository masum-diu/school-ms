<?php

use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExamResultController;
use App\Http\Controllers\FeeController;
use App\Http\Controllers\SchoolClassController;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\TeacherController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => redirect()->route('login'));

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('students', StudentController::class);
    Route::get('/api/classes/{schoolClass}/sections', [StudentController::class, 'sections'])->name('api.sections');

    Route::resource('teachers', TeacherController::class);

    Route::resource('classes', SchoolClassController::class)->parameters(['classes' => 'schoolClass']);
    Route::post('/classes/{schoolClass}/sections', [SectionController::class, 'store'])->name('classes.sections.store');
    Route::delete('/classes/{schoolClass}/sections/{section}', [SectionController::class, 'destroy'])->name('classes.sections.destroy');

    Route::resource('subjects', SubjectController::class)->except(['show']);

    Route::get('/attendance', [AttendanceController::class, 'index'])->name('attendance.index');
    Route::post('/attendance', [AttendanceController::class, 'store'])->name('attendance.store');
    Route::get('/attendance/report', [AttendanceController::class, 'report'])->name('attendance.report');

    Route::get('/fees/types', [FeeController::class, 'types'])->name('fees.types');
    Route::post('/fees/types', [FeeController::class, 'storeType'])->name('fees.types.store');
    Route::put('/fees/types/{feeType}', [FeeController::class, 'updateType'])->name('fees.types.update');
    Route::delete('/fees/types/{feeType}', [FeeController::class, 'destroyType'])->name('fees.types.destroy');
    Route::get('/fees/payments', [FeeController::class, 'payments'])->name('fees.payments');
    Route::post('/fees/payments', [FeeController::class, 'storePayment'])->name('fees.payments.store');

    Route::get('/exams', [ExamResultController::class, 'index'])->name('exams.index');
    Route::get('/exams/create', [ExamResultController::class, 'create'])->name('exams.create');
    Route::post('/exams', [ExamResultController::class, 'store'])->name('exams.store');
    Route::delete('/exams/{exam}', [ExamResultController::class, 'destroy'])->name('exams.destroy');
    Route::get('/api/classes/{schoolClass}/students', [ExamResultController::class, 'students'])->name('api.students');
});
