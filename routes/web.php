<?php

use App\Http\Controllers\AssistController;
use App\Http\Controllers\LogingController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\ParamController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\StudentStatusController;
use App\Http\Controllers\PdfController;
use App\Http\Controllers\ExcelController;
use App\Http\Controllers\YearController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/register', function () {
  return view('register');
});

Route::middleware('auth')->group(function () {
  Route::get('/dashboard', [DashboardController::class, 'compactData'])->name('/dashboard');

  Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
  Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
  Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

  Route::resource('students', StudentController::class);
  Route::get('assist/{id}', [StudentController::class, 'find'])->name("StudentAssist");

  Route::get('params.controlPanel', [ParamController::class,'getParams'])->name('panel');
  Route::get('params.editControlPanel/{id}', [ParamController::class, 'edit'])->name('edit');
  Route::put('param-update/{id}', [ParamController::class, 'updateParam'])->name("param-update");

  Route::get('/sign', [YearController::class,'returnToSign'])->name('signView');
  Route::GET('findThis', [StudentController::class,'findThis'])->name('findThis');
  Route::GET('getStudentsPerYear', [StudentController::class, 'getStudentsPerYear'])->name('getStudentsPerYear');
  Route::GET('storeFromButton/{id}', [AssistController::class, 'storeFromButton'])->name('storeFromButton');
  
  
  Route::get('/libres', [StudentStatusController::class,'compactAuditors'])->name('libres');
  Route::get('/aprobados', [StudentStatusController::class, 'compactPromoted'])->name('aprobados');
  Route::get('/regulares', [StudentStatusController::class, 'compactRegularized'])->name('regulares');
  Route::get('/asistencias', [StudentStatusController::class, 'compactAssists'])->name('asistencias');

  //Route::get('test', [StudentController::class, 'staticCompleteStudentStatus'])->name('test');

  Route::Get('informes', [YearController::class,'returnToReports'])->name('informes');
  Route::get('routeFormat')->middleware('routeFormat')->name('routeFormat');
  Route::get('pdf/pdf{request}', [PdfController::class,'pdfAssistGeneral'])->name('pdfAssistGeneral');
  Route::get('excel/excel{request}', [ExcelController::class, 'excelAssistGeneral'])->name('excelAssistGeneral');

    Route::get('logs', [LogingController::class,'getLogs'])->middleware('verifyPermission')->name('logs');


});

require __DIR__.'/auth.php';
