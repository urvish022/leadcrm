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
    Route::post('bulk-update-status',[App\Http\Controllers\LeadsController::class,'bulk_change_status'])->name('leads.bulk-update-status');
    Route::post('send-mail',[App\Http\Controllers\LeadsController::class,'send_mail'])->name('leads.send-mail');
    Route::get('export-leads',[App\Http\Controllers\LeadsController::class,'export_leads'])->name('leads.export-leads');
    Route::post('lead-detail/{id}',[App\Http\Controllers\LeadsController::class,'get_lead_details'])->name('leads.get-leads-details');
    Route::post('save-schedule',[App\Http\Controllers\LeadsController::class,'save_schedule'])->name('leads.save-schedule');
    Route::resource('leads', App\Http\Controllers\LeadsController::class);

    Route::get('lead-email-templates/create/{id}',[App\Http\Controllers\LeadEmailController::class,'create']);
    Route::post('lead-email-templates/find-template',[App\Http\Controllers\LeadEmailController::class,'findEmailTemplate']);
    Route::get('lead-email-templates/active/{id}',[App\Http\Controllers\LeadEmailController::class,'activeEmailTemplate']);
    Route::resource('lead-email-templates',App\Http\Controllers\LeadEmailController::class);

    Route::get('lead-contacts/update-status/{id}',[App\Http\Controllers\LeadContactsController::class,'updateStatus'])->name('lead-contacts.update-status');
    Route::post('lead-contacts-list', [App\Http\Controllers\LeadContactsController::class,'list'])->name('lead-contacts.list');
    Route::resource('lead-contacts', App\Http\Controllers\LeadContactsController::class);

    Route::get('settings',[App\Http\Controllers\SettingsController::class,'index'])->name('settings.index');
    Route::patch('settings-update/{id}',[App\Http\Controllers\SettingsController::class,'update'])->name('settings.update');
});

Route::get('sample-mail',[App\Http\Controllers\LeadsController::class,'test_email']);

