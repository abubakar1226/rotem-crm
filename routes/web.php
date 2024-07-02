<?php

use App\Http\Controllers\Backend;
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

require __DIR__ . '/auth.php';

// Backend Routes
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [Backend\DashboardController::class, 'index'])->name('dashboard');
    // Profile Routes
    Route::resource('profile', Backend\ProfileController::class);
    Route::put('change-password/{id}', [Backend\ProfileController::class, 'changePassword'])->name('change-password');
    // Users Routes
    Route::resource('users', Backend\UserController::class);
    Route::get('users-dt', [Backend\UserController::class, 'dataTable'])->name('users-datatable');
    // Roles Routes
    Route::resource('roles', Backend\RoleController::class);
    Route::get('roles-dt', [Backend\RoleController::class, 'dataTable'])->name('roles-datatable');
    // Leads Routes
    Route::resource('leads', Backend\LeadsController::class);
    Route::get('leads/{lead}/edit-status', [Backend\LeadsController::class, 'edit'])->name('leads.edit-status');

    // Appointment Routes
    Route::get('appointments/index/{technician?}', [Backend\AppointmentsController::class, 'index'])
        ->name('appointments.index');
    Route::patch(
        'appointments/{appointment}/update-technician',
        [Backend\AppointmentsController::class, 'updateTechnician']
    )->name('appointments.technician-update');

    Route::resource('sub_reports', Backend\SubReportsController::class);

    Route::prefix('leads/{lead}')->name('leads.')->group(function () {
        Route::resource('appointments', Backend\AppointmentsController::class)
            ->only(['create', 'store']);

        Route::resource('lead-status', Backend\LeadStatusController::class)
            ->only(['create', 'store']);

        Route::post('no-response', [Backend\LeadStatusController::class, 'noResponse'])
            ->name('no-response');

        Route::post('no-response-twice', [Backend\LeadStatusController::class, 'noResponseTwice'])
            ->name('no-response-twice');
    });

    Route::get('leads/no-response/index', [Backend\LeadsController::class, 'noResponseIndex'])
        ->name('leads.no-response.index');

    Route::get('leads/no-response-twice/index', [Backend\LeadsController::class, 'noResponseTwiceIndex'])
        ->name('leads.no-response-twice.index');

    // Refund Routes
    Route::resource('refunds', Backend\RefundsController::class)
        ->only(['index', 'edit', 'update']);

    // Technician Routes
    Route::resource('technicians', Backend\TechniciansController::class);

    // Table Routes
    Route::resource('tables', Backend\TablesController::class)
        ->only(['edit', 'update']);
});

// Frontend Routes
Route::redirect('/', '/login');
