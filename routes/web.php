<?php

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

Auth::routes();

Route::get('/', [App\Http\Controllers\Auth\LoginController::class,'showLoginForm'])->name('login');

Route::group(['middleware' => ['auth']], function () { 
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    
    Route::resource('lead-category', App\Http\Controllers\LeadCategoryController::class);
    
    Route::get('leads-import',[App\Http\Controllers\LeadsController::class,'import'])->name('leads.import');
    Route::post('leads-store',[App\Http\Controllers\LeadsController::class,'import_store'])->name('leads.mass-store');
    Route::post('leads-list',[App\Http\Controllers\LeadsController::class,'list'])->name('leads.list');
    Route::post('leads-change-status',[App\Http\Controllers\LeadsController::class,'change_status'])->name('leads.change-status');
    Route::resource('leads', App\Http\Controllers\LeadsController::class);

    Route::get('lead-email-templates/create/{id}',[App\Http\Controllers\LeadEmailController::class,'create']);
    Route::post('lead-email-templates/find-template',[App\Http\Controllers\LeadEmailController::class,'findEmailTemplate']);
    Route::get('lead-email-templates/active/{id}',[App\Http\Controllers\LeadEmailController::class,'activeEmailTemplate']);
    Route::resource('lead-email-templates',App\Http\Controllers\LeadEmailController::class);
    
    Route::post('lead-contacts-list', [App\Http\Controllers\LeadContactsController::class,'list'])->name('lead-contacts.list');
    Route::resource('lead-contacts', App\Http\Controllers\LeadContactsController::class);
});
