<?php
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\UmumController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WaController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ApiWaController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\RolesItemController;
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

Route::get('/', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'login']);

// wa
Route::post('/sent_wa', [WaController::class, 'sent_wa']);
Route::post('/sent_wa_excel', [WaController::class, 'sent_wa_excel']);
Route::get('/sent_wa_cek', [WaController::class, 'sent_wa_cek']);

// kontak
Route::get('/data_contact', [ContactController::class, 'data_contact_all']);
Route::get('/data_contact/{id}', [ContactController::class, 'data_contact']);
Route::get('/delete_contact/{id}', [ContactController::class, 'delete_contact']);
Route::get('/edit_contact/{id}', [ContactController::class, 'edit_contact']);
Route::post('/edit_aksi_contact', [ContactController::class, 'update_contact']);
Route::post('/save_contact', [ContactController::class, 'save_contact'])->name('save_contact');

// Route::get('/cek_random_api', [WaController::class, 'random_api'])->name('random_api');


// api_wa
Route::get('/data_api_wa', [ApiWaController::class, 'data_api_wa_all']);
Route::get('/data_api_wa_cek', [ApiWaController::class, 'data_api_wa_cek']);
Route::get('/data_api_wa/{id}', [ApiWaController::class, 'data_api_wa']);
Route::get('/delete_api_wa/{id}', [ApiWaController::class, 'delete_api_wa']);
Route::get('/edit_api_wa/{id}', [ApiWaController::class, 'edit_api_wa']);
Route::post('/edit_aksi_api_wa', [ApiWaController::class, 'update_api_wa']);
Route::post('/save_api_wa', [ApiWaController::class, 'save_api_wa'])->name('save_api_wa');

// history
Route::get('/data_history', [HistoryController::class, 'data_history_all']);
Route::get('/data_history/{id}', [HistoryController::class, 'data_history']);
Route::post('/download_excel', [HistoryController::class, 'download_excel']);
Route::post('/search_history', [HistoryController::class, 'search_history']);




Route::middleware(['auth'])->group(function () {
    // home
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::get('/sender', [HomeController::class, 'sender'])->name('sender');
    Route::get('/bulk', [HomeController::class, 'bulk'])->name('bulk');
    Route::get('/contact', [HomeController::class, 'contact'])->name('contact');
    Route::get('/api_wa', [HomeController::class, 'api_wa'])->name('api_wa');
    Route::get('/history', [HomeController::class, 'history'])->name('history');
    Route::get('/getMaps', [HomeController::class, 'getMaps']);
    Route::get('/ajaxGetDivisi/{cluster}', [HomeController::class, 'getDivisi']);
    Route::post('/dashboard', [HomeController::class, 'dashboard']);

    Route::get('/logout', [LoginController::class, 'logout']);
    Route::get('/profil', [ProfilController::class, 'index']);
    Route::patch('/profil/{profil}', [ProfilController::class, 'update']);
    Route::get('/profil/password', [ProfilController::class, 'password']);
    Route::patch('/ganti-password/{profil}', [ProfilController::class, 'ganti_password']);
    Route::resource('umum', UmumController::class);

    // User
    Route::resource('user', UserController::class);
    Route::get('/user/delete/{id}', [UserController::class, 'delete']);
    Route::post('/ajaxUser', [UserController::class, 'ajax']);

    // Roles
    Route::get('/roles/pilihan', [RolesController::class, 'pilihan']);
    Route::get('/roles/pilih/{roles}', [RolesController::class, 'pilih']);
    Route::post('/ajaxRoles', [RolesController::class, 'ajax']);
    Route::get('/roles/delete/{id}', [RolesController::class, 'delete']);
    Route::resource('roles', RolesController::class);

    // Role Item
    Route::post('/ajaxRolesItem', [RolesItemController::class, 'ajax']);
    Route::get('/rolesitem/delete/{id}', [RolesItemController::class, 'delete']);
    Route::resource('rolesitem', RolesItemController::class);

    Route::view('/403', '403');
});
