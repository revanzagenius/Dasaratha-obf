<?php

use App\Mail\TestEmail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CVEController;
use App\Http\Middleware\AuthMiddleware;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\ScanController;
use App\Http\Controllers\AnyrunController;
use App\Http\Controllers\DomainController;
use App\Http\Controllers\ShodanController;
use App\Http\Controllers\ThreatController;
use App\Http\Controllers\MonitorController;
use App\Http\Controllers\DeHashedController;
use App\Http\Controllers\DashboardController;

Route::get('/', [AuthController::class, 'index'])->name('login.index');
Route::post('/', [AuthController::class, 'login'])->name('login.submit');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');


Route::middleware([AuthMiddleware::class])->group(function () {
    Route::get('/user-management', [AuthController::class, 'usermanagement'])->name('user.management');
    Route::get('/login-logs', [AuthController::class, 'loglogin'])->name('login-logs');
    Route::post('/user-management', [AuthController::class, 'store'])->name('user.store');
    Route::get('user/{id}/edit', [AuthController::class, 'edit'])->name('user.edit');
    Route::put('user/{id}', [AuthController::class, 'update'])->name('user.update');
    Route::delete('user/{id}', [AuthController::class, 'destroy'])->name('user.destroy');

    //DASHBOARD
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.indexd');

    //NEWS
    Route::get('/news', [NewsController::class, 'index'])->name('news.index');
    Route::get('/malware-trends', [NewsController::class, 'malware'])->name('malware.index');
    Route::get('/malware/{name}', [NewsController::class, 'detail'])->name('malware.detail');
    Route::get('/feeds', [NewsController::class, 'Feeds']);
    Route::get('/hackernews', [NewsController::class, 'hackernews'])->name('hackernews');

    //CVE
    Route::get('/vulnerabilities-dashboard', [CVEController::class, 'index'])->name('vulndashboard.index');
    Route::get('/open-cve', [CVEController::class, 'opencve'])->name('opencve.index');
    Route::get('/cve/{id}', [CVEController::class, 'showCVE'])->name('cve.show');
    Route::get('/cve', [CVEController::class, 'circl'])->name('cve.index');
    // Route::get('cve/{cveId}/details', [CveController::class, 'showDetail'])->name('cve.detail');
    // Route::get('/vulnerabilities', [CVEController::class, 'cve'])->name('cve.index');
    // Route::get('/nvd-feeds', [CVEController::class, 'nvd'])->name('cvenvd.index');
    // Route::get('/circl.lu-others', [CVEController::class, 'others'])->name('others.index');

    //THREAT
    Route::get('/threats', [ThreatController::class, 'index'])->name('threats.index');

    //DASHBOARD
    Route::get('/port-monitor', [MonitorController::class, 'index'])->name('monitor.index');
    Route::delete('/hosts/{id}', [MonitorController::class, 'destroy'])->name('hosts.destroy');
    Route::post('/scan', [MonitorController::class, 'scan'])->name('scan');
    Route::get('/result/{id}', [MonitorController::class, 'showResult'])->name('result');
    Route::get('/result/{id}/export', [MonitorController::class, 'exportPdf'])->name('monitor.exportPdf');
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
    Route::delete('/domains/{id}', [DomainController::class, 'destroy'])->name('domains.destroy');
    Route::get('/subdomain', [DomainController::class, 'subdomain'])->name('subdomain.index');
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
