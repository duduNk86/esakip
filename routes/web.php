<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Livewire\Dashboard\Index as DashboardIndex;
use App\Livewire\Periode\Index as PeriodeIndex;
use App\Livewire\Periode\Form as PeriodeForm;
use App\Livewire\Opd\Index as OpdIndex;
use App\Livewire\Opd\Form as OpdForm;
use App\Livewire\Users\Index as UsersIndex;
use App\Livewire\Users\Form as UsersForm;
use App\Livewire\Appsetup\Index as AppsetupIndex;
use App\Livewire\Aspek\Index as AspekIndex;
use App\Livewire\Komponen\Index as KomponenIndex;
use App\Livewire\Subkomponen\Index as SubkomponenIndex;
use App\Livewire\Penilaianopd\Index as PenilaianopdIndex;
use App\Livewire\Evaluasi\Index as EvaluasiIndex;
use App\Livewire\Reporting\Index as ReportingIndex;
use App\Http\Controllers\LkePdfController;
use App\Http\Controllers\LandingpageController;

// Landingpage
// Route::get('/', function () {
//     if (Auth::check()) {
//         return redirect()->route('dashboard.index');
//     }
//     return view('welcome');
// });

Route::get('/', [LandingpageController::class, 'index'])->name('landingpage.index');

// Dashboard
// Route::view('/dashboard', 'dashboard.index')
//     ->middleware(['auth', 'verified'])
//     ->name('dashboard.index');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', DashboardIndex::class)->name('dashboard.index');
});

// Setting
Route::middleware(['auth', 'role:superadmin'])->group(function () {
    // Periode
    Route::get('/periode', PeriodeIndex::class)->name('periode.index');
    Route::get('/periode/create', PeriodeForm::class)->name('periode.create');
    Route::get('/periode/{id}/edit', PeriodeForm::class)->name('periode.edit');

    // Sakip - Aspek
    Route::get('/aspek', AspekIndex::class)->name('aspek.index');

    // Sakip - Komponen
    Route::get('/komponen', KomponenIndex::class)->name('komponen.index');

    // Sakip - Sub Komponen
    Route::get('/subkomponen', SubkomponenIndex::class)->name('subkomponen.index');

    // Opds
    Route::get('/opd', OpdIndex::class)->name('opd.index');
    Route::get('/opd/create', OpdForm::class)->name('opd.create');
    Route::get('/opd/{id}/edit', OpdForm::class)->name('opd.edit');

    // Users
    Route::get('/users', UsersIndex::class)->name('users.index');
    Route::get('/users/create', UsersForm::class)->name('users.create');
    Route::get('/users/{id}/edit', UsersForm::class)->name('users.edit');

    // Setup Aplikasi
    Route::get('/appsetup', AppsetupIndex::class)->name('appsetup.index');
});

// Penilaian Sakip
Route::get('/penilaianopd', PenilaianopdIndex::class)->name('penilaianopd.index');
Route::get('/print-lke/{penilaian_opd_id}', [LkePdfController::class, 'generatePdf'])
    ->name('print.lke');

// Evaluasi Sakip
Route::get('/evaluasi/{penilaian_opd_id}', EvaluasiIndex::class)->name('evaluasi.index');

Route::middleware(['auth', 'role:superadmin,penilai,viewer'])->group(function () {
    // Reporting Sakip
    Route::get('/reporting', ReportingIndex::class)->name('reporting.index');
});

// Profile
Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

// Logout
Route::any('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/');
})->name('logout');

require __DIR__ . '/auth.php';
