<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TeacherController;
use Illuminate\Support\Facades\Route;


Route::get('/', [LoginController::class, 'index'])->name('login.index');
Route::post('/', [LoginController::class, 'store'])->name('login.store');
Route::get('/logout', [LoginController::class, 'logout'])->name('login.logout');

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => 'login'], function () {

    Route::get('/teacher', [AdminController::class, 'teacherIndex'])->name('teacher.index');
    Route::post('/teacher', [AdminController::class, 'teacherStore'])->name('teacher.store');
    Route::get('/teacher/{teacher}', [AdminController::class, 'teacherEdit'])->name('teacher.edit');
    Route::put('/teacher/{teacher}', [AdminController::class, 'teacherUpdate'])->name('teacher.update');
    Route::delete('/teacher/{teacher}', [AdminController::class, 'teacherDelete'])->name('teacher.delete');

    Route::get('/student', [AdminController::class, 'studentIndex'])->name('student.index');
    Route::post('/student', [AdminController::class, 'studentStore'])->name('student.store');
    Route::get('/student/{student}', [AdminController::class, 'studentEdit'])->name('student.edit');
    Route::put('/student/{student}', [AdminController::class, 'studentUpdate'])->name('student.update');
    Route::delete('/student/{student}', [AdminController::class, 'studentDelete'])->name('student.delete');

    Route::get('/notice/{personal}', [AdminController::class, 'noticeIndex'])->name('notice.index');
    Route::post('/notice/{personal}', [AdminController::class, 'noticeStore'])->name('notice.store');
    Route::delete('/notice/{personal}', [AdminController::class, 'noticeDelete'])->name('notice.delete');

    Route::get('/class', [AdminController::class, 'classIndex'])->name('class.index');
    Route::post('/class', [AdminController::class, 'classStore'])->name('class.store');
    Route::delete('/class', [AdminController::class, 'classDelete'])->name('class.delete');

    Route::get('/', [AdminController::class, 'index'])->name('index');
    Route::post('/', [AdminController::class, 'store'])->name('store');
    Route::get('/{admin}', [AdminController::class, 'edit'])->name('edit');
    Route::put('/{admin}', [AdminController::class, 'update'])->name('update');
    Route::delete('/{admin}', [AdminController::class, 'delete'])->name('delete');
});


Route::group(['prefix' => 'teacher', 'as' => 'teacher.', 'middleware' => 'login'], function () {

    Route::get('/', [TeacherController::class, 'index'])->name('index');
    Route::get('/classes', [TeacherController::class, 'classes'])->name('classes.index');
    Route::get('/info/{clas}', [TeacherController::class, 'info'])->name('info.index');
    Route::get('/notice/{clas}', [TeacherController::class, 'notice'])->name('notice.index');
    Route::post('/notice/{clas}', [TeacherController::class, 'noticeStore'])->name('notice.store');
    Route::delete('/notice/{clas}', [TeacherController::class, 'noticeDelete'])->name('notice.delete');
});

Route::group(['prefix' => 'student', 'as' => 'student.', 'middleware' => 'login'], function () {

    Route::get('/', [StudentController::class, 'index'])->name('index');
    Route::get('/data', [StudentController::class, 'dataIndex'])->name('data.index');
    Route::post('/data', [StudentController::class, 'dataStore'])->name('data.store');
});
