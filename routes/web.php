<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AppraisalCtrl;
use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\AuthCtrl;
use Illuminate\Support\Facades\Auth;

Route::prefix('appraisal')->group(function () {
    Route::view('/direct-report', 'appraisalDirectReport');
    Route::view('/supervisor', 'appraisal');
});

Route::post('enter-appraisal-data', [AppraisalCtrl::class, 'enterAppraisalData']);
Route::post('edit-appraisal-data', [AppraisalCtrl::class, 'editAppraisalData']);
Route::post('send-appraisal-email', [AppraisalCtrl::class, 'sendAppraisalEmail']);
Route::post('getAll-appraisal-data', [AppraisalCtrl::class, 'getAllAppraisalData']);
Route::post('get-appraisal-data', [AppraisalCtrl::class, 'getAppraisalData']);
Route::post('getAll-employee-data', [AppraisalCtrl::class, 'getAllEmployeeData']);
Route::post('get-employee-data', [AppraisalCtrl::class, 'getEmployeeData']);
Route::post('get-supervisor-data', [AppraisalCtrl::class, 'getSupervisorData']);
Route::post('send-app-email', [AppraisalCtrl::class, 'sendAppEmail']);
Route::post('add-employee', [AppraisalCtrl::class, 'addEmployee']);
Route::post('edit-employee', [AppraisalCtrl::class, 'editEmployee']);
Route::post('getAll-employees', [AppraisalCtrl::class, 'getAllEmployees']);


Route::middleware('auth')->group(function(){
    Route::prefix('appraisal')->group(function () {
        // Route::view('/supervisor', 'supervisor');
        Route::get('/supervisor', function () {
            if (auth()->user()->username === 'admin') {
                abort(403);
            }
            return view('supervisor');
        });
        // Route::view('/history', 'history');
        Route::get('/history', function () {
            if (auth()->user()->username !== 'admin') {
                abort(403);
            }
            return view('history');
        });
        Route::get('/editEmployees', function () {
            if (auth()->user()->username !== 'admin') {
                abort(403);
            }
            return view('editEmployees');
        });
        // Route::view('/admin', 'admin');
        Route::get('/admin', function () {
            if (auth()->user()->username !== 'admin') {
                abort(403);
            }
            return view('admin');
        });
    });

    // Auth
    Route::post('/logout', [AuthCtrl::class, 'logout']);
}); 

Route::middleware('guest')->group(function(){
    // Auth
    Route::view('/register', 'auth.register')->name('register');
    Route::post('/register', [AuthCtrl::class, 'register']);

    Route::view('/login', 'auth.login')->name('login');
    Route::post('/login', [AuthCtrl::class, 'login']);

    // Rest Password Routes
    Route::view('/forgot-password', 'auth.forgot-password')->name('password.request');
    Route::post('/forgot-password', [ResetPasswordController::class, 'passwordEmail']);
    Route::get('/reset-password/{token}', [ResetPasswordController::class, 'passwordReset'])->name('password.reset');

    Route::post('/reset-password', [ResetPasswordController::class, 'passwordUpdate'])->name('password.update');
});
