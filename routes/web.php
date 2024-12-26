<?php

use App\Mail\TestEmail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\AuthMiddleware;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\ScanController;
use App\Http\Controllers\AnyrunController;
use App\Http\Controllers\DomainController;
use App\Http\Controllers\ShodanController;
use App\Http\Controllers\MonitorController;
use App\Http\Controllers\DeHashedController;
use App\Http\Controllers\DashboardController;

Route::get('/', [AuthController::class, 'index'])->name('login.index');
Route::post('/', [AuthController::class, 'login'])->name('login.submit');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');


Route::middleware([AuthMiddleware::class])->group(function () {
    //DASHBOARD
    Route::get('/dashboard', [DashboardController::class, 'index']);

    //NEWS
    Route::get('/news', [NewsController::class, 'index'])->name('news.index');
    Route::get('/malware-trends', [NewsController::class, 'malware'])->name('malware.index');
    Route::get('/malware/{name}', [NewsController::class, 'detail'])->name('malware.detail');
    Route::get('/vulnerabilities', [NewsController::class, 'cve'])->name('cve.index');
    Route::get('/feeds', [NewsController::class, 'Feeds']);
    Route::get('/hackernews', [NewsController::class, 'hackernews'])->name('hackernews');


    //DASHBOARD
    Route::get('/port-monitor', [MonitorController::class, 'index'])->name('dashboard.index');
    Route::post('/scan', [MonitorController::class, 'scan'])->name('scan');
    Route::get('/result/{id}', [MonitorController::class, 'showResult'])->name('result');
    Route::get('/result/{id}/export', [MonitorController::class, 'exportPdf'])->name('dashboard.exportPdf');
    Route::post('/shodan/new-port', [MonitorController::class, 'handleNewPortData']);

    // OSINT
    Route::get('/shodan', [ShodanController::class, 'index'])->name('search.index');
    Route::get('/shodan/search', [ShodanController::class, 'search'])->name('shodan.search');

    // SCANNING
    Route::get('/scan', [ScanController::class, 'index'])->name('ipscanner');
    Route::post('/shodan/scan', [ScanController::class, 'scan']); // Rute untuk melakukan pemindaian

    //DOMAIN
    Route::get('/domains', [DomainController::class, 'index'])->name('domains.index');
    Route::post('/domains', [DomainController::class, 'fetchAndStoreDomainData'])->name('domains.store');
    Route::get('/domains/download-pdf', [DomainController::class, 'downloadPdf'])->name('domains.downloadPdf');

    //ANYRUN
    Route::get('/anyrun/threat-intel', [AnyrunController::class, 'getThreatIntel']);

    Route::get('/search', [DeHashedController::class, 'index'])->name('databreach.index');
    Route::post('/search', [DeHashedController::class, 'search'])->name('databreach.search');

    // Route::post('/scan', [ScanController::class, 'storeScan'])->name('scan.store');
});

Route::get('/send-email', function () {
    Mail::to('revanzalenovo@gmail.com')->send(new \App\Mail\TestEmail());
    return 'Email Sent!';
});
