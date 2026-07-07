<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

use App\Http\Controllers\LoginController;
use App\Http\Controllers\DischargingController;
use App\Http\Controllers\TallyController;
use App\Http\Controllers\GateoutChartController;



Route::get('/', function () {
    return redirect()->route('login');
});

// LOGIN
Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/authenticate', [LoginController::class, 'authenticate'])->name('authenticate');

Route::post('/logout', function () {
    Session::flush();
    return redirect()->route('login');
})->name('logout');

// TALLY
Route::get('/tally-pilih-kapal', [TallyController::class, 'pilihKapal'])->name('tally.pilihKapal');
Route::post('/tally-set-kapal', [TallyController::class, 'setKapal'])->name('tally.setKapal');

Route::get('/tally-konfirmasi', [TallyController::class, 'index'])->name('tally.konfirmasi');
Route::get('/tally-get-data', [TallyController::class, 'getData'])->name('tally.getData');
Route::post('/tally-submit', [TallyController::class, 'submit'])->name('tally.submit');

// DISCHARGING
Route::get('/dischargingcardsystem', [DischargingController::class, 'index'])->name('discharging');
Route::get('/discharging/edit/{NO_CTR}', [DischargingController::class, 'editForm'])->name('discharging.edit.form');
Route::post('/discharging/edit/{NO_CTR}', [DischargingController::class, 'edit'])->name('discharging.edit');
Route::get('/discharging/print/{NO_CTR}', [DischargingController::class, 'print'])->name('discharging.print');
Route::get('/gateout-database', function () {

    $gateout = DB::table('dc_gateout')
        ->orderBy('id', 'DESC')
        ->get();

    return view('gateout_database', [
        'gateout' => $gateout
    ]);

})->name('gateout.database');
Route::post('/discharging/gateout/{NO_CTR}',[DischargingController::class, 'gateout'])->name('discharging.gateout');

// API autocomplete
Route::get('/api/cari-container', [TallyController::class, 'cariContainer']);
Route::get('/api/cari-lambung', [TallyController::class, 'cariLambung']);

// GATEOUT DATABASE
Route::get('/gateout-database', function () {
    $data = DB::table('dc_gateout')->orderBy('id','DESC')->get();
    return view('gateout_database', compact('data'));
})->name('gateout.database');

Route::get('/gateout-chart', [GateoutChartController::class, 'index'])->name('gateout.chart');


// EXPORT
Route::get('/gateout/export/pdf', [DischargingController::class, 'exportPDF'])->name('export.gateout.pdf');

// EMAIL
Route::post('/gateout/email/pdf',[DischargingController::class, 'sendPdfEmail'])->name('gateout.email.pdf');