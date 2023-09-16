<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeeController;

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

Route::get('/', [EmployeeController::class, 'index']);
Route::post('add_form_data', [EmployeeController::class, 'addFormData']);
Route::get('show_data', [EmployeeController::class, 'fetchAllEmployees']);
Route::get('edit_data', [EmployeeController::class, 'editData']);
Route::post('update_data', [EmployeeController::class, 'updateData']);
Route::post('delete_data', [EmployeeController::class, 'deleteData']);
