<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminMeadController;
use App\Http\Controllers\Admin\CityTierController;
use App\Http\Controllers\Admin\DAController;
use App\Http\Controllers\Admin\EmployeGradeController;
use App\Http\Controllers\Admin\GradeController;
use App\Http\Controllers\Admin\HotelTierController;
use App\Http\Controllers\Admin\TravelController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
// 2Dec code
Route::resource('admin/grade', GradeController::class);
Route::resource('admin/meal', AdminMeadController::class);
Route::resource('admin/city', CityTierController::class);
Route::resource('admin/da', DAController::class);
Route::resource('admin/hotel', HotelTierController::class);
Route::resource('admin/travel', TravelController::class);
Route::resource('admin/employe-grade', EmployeGradeController::class);

Route::group(['namespace' => 'api', 'middleware' => []] ,function(){
    //before 2Dec codee
    Route::post('create-expense',[App\Http\Controllers\api\ExpenseController::class,'createExpense']);
    Route::get('get-pending-expenses',[App\Http\Controllers\api\ExpenseController::class,'getPendingExpenses']);
    Route::get('get-draft-expenses',[App\Http\Controllers\api\ExpenseController::class,'getDraftExpenses']);
    Route::get('get-approved-expenses',[App\Http\Controllers\api\ExpenseController::class,'getApprovedExpenses']);
    Route::get('get-rejected-expenses',[App\Http\Controllers\api\ExpenseController::class,'getRejectedExpenses']);
    Route::get('get-expense-details',[App\Http\Controllers\api\ExpenseController::class,'getExpenseDetails']);

    Route::post('approve-expense',[App\Http\Controllers\api\ExpenseController::class,'approveExpense']);
    Route::post('reject-expense',[App\Http\Controllers\api\ExpenseController::class,'rejectExpense']);
});
