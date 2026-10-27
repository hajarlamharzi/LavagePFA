<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PrestationController;
use App\Http\Controllers\EmployeController;
use App\Http\Controllers\AvanceController;
use App\Http\Controllers\DepenseController;
use App\Http\Controllers\RapportController;
use App\Http\Controllers\PresenceController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TarifController;
use App\Http\Controllers\SocieteController;
use App\Http\Controllers\FacturationController;
// use App\Http\Controllers\ReservationController;
use App\Http\Controllers\ClientReservationController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\AdminReservationController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Api\ReservationController;


Route::get('/', [ClientController::class, 'index'])->name('client.home');


Route::get('/reservation', [ClientReservationController::class, 'create'])->name('reservation.form');
Route::post('/reservation', [ClientReservationController::class, 'store'])->name('reservation.store');
Route::post('/api/reservations', [ReservationController::class, 'store']);
Route::get('/contact', [ContactController::class, 'index'])->name('contact.form');
Route::post('/api/contact', [ContactController::class, 'store']);
Route::post('/api/reservations', [ReservationController::class, 'store']);
Route::middleware('auth')->group(function () {
    Route::post('/notifications/{id}/read', function($id) {
        auth()->user()->unreadNotifications()->where('id', $id)->first()->markAsRead();
        return back();
    })->name('notifications.markAsRead');

    Route::post('/notifications/mark-all-read', function() {
        auth()->user()->unreadNotifications->markAsRead();
        return back();
    })->name('notifications.markAllRead');
});


Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');


Route::get('/home', [HomeController::class, 'index'])->middleware('auth')->name('home');
Route::get('/contact', [ContactController::class, 'index']);

Route::post('/api/contact', [ContactController::class, 'store']);
Route::post('/api/reservations', [ReservationController::class, 'store']);
Route::get('/api/contact', [ContactController::class, 'index']);

Route::middleware(['auth'])->group(function () {
 Route::get('/vehicules', [PrestationController::class, 'selectVehicule'])->name('vehicules.select');
    Route::get('/lavage/select', [PrestationController::class, 'selectLavage'])->name('lavage.select');
    Route::get('/prestations/create', [PrestationController::class, 'create'])->name('prestations.create');
    Route::post('/prestations/store', [PrestationController::class, 'store'])->name('prestations.store');
    Route::get('/prestations', [PrestationController::class, 'index'])->name('prestations.index');
    Route::get('/prestations/{id}/ticket', [PrestationController::class, 'genererTicket'])->name('prestations.ticket');

    Route::resource('prestations', PrestationController::class);
    Route::resource('reservations', AdminReservationController::class);
    Route::get('/reservation', [ClientReservationController::class, 'create'])->name('reservation.form');

    Route::resource('societes', SocieteController::class);
    Route::resource('employes', EmployeController::class);
    Route::resource('presences', PresenceController::class);
    Route::resource('avances', AvanceController::class)->except(['show']);
    Route::resource('depenses', DepenseController::class);
    Route::resource('tarifs', TarifController::class);

    Route::get('/admin/reservations', [ReservationController::class, 'index'])->name('reservations.index');

    Route::get('/profile', [ProfileController::class, 'show'])->name('profile');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');

    Route::match(['get', 'post'], '/avances/calcul', [AvanceController::class, 'calcul'])->name('avances.calcul');
    Route::match(['get', 'post'], '/depenses/calcul', [DepenseController::class, 'calcul'])->name('depenses.calcul');
    Route::match(['get', 'post'], '/rapport/calcul', [RapportController::class, 'calcul'])->name('rapport.calcul');
    Route::get('/rapport/details', [RapportController::class, 'details'])->name('rapport.details');

    // Facturation
    Route::get('/facturation/societe', [FacturationController::class, 'index'])->name('facturation.societe');
    Route::post('/facturation/societe/resultat', [FacturationController::class, 'resultat'])->name('facturation.societe.resultat');
});
