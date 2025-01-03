<?php

use App\Http\Controllers\AsetController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\BarangKeluarController;
use App\Http\Controllers\BarangMasukController;
use App\Http\Controllers\DepartementController;
use App\Http\Controllers\PengajuanController;
use App\Http\Controllers\UserController;
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

Route::redirect('/', '/login');
Route::get('/login',[AuthController::class,'index'])->name('login');
Route::post('/login-submit',[AuthController::class,'login'])->name('login-submit');


// Dashboard
// Route::get('/dashboard',[dashboardController::class,'index'])->name('dashboard');

Route::get('/getDataDepartement', [DepartementController::class, 'getData'])->name('getDataDepartement');
Route::post('/updateDepartement', [DepartementController::class, 'update'])->name('departement.update');
Route::resource('departement',DepartementController::class)->names([
    'index'   => 'departement.index',
    'create'  => 'departement.create',
    'store'   => 'departement.store',
    'show'    => 'departement.show',
    'edit'    => 'departement.edit',
    'destroy' => 'departement.destroy',
])->except('update');

Route::get('/getDataUser', [UserController::class, 'getData'])->name('getDataUser');
Route::post('/updateUser', [UserController::class, 'update'])->name('user.update');
Route::resource('user',UserController::class)->names([
    'index'   => 'user.index',
    'create'  => 'user.create',
    'store'   => 'user.store',
    'show'    => 'user.show',
    'edit'    => 'user.edit',
    'destroy' => 'user.destroy',
])->except('update');


Route::get('/getBarangKeluar', [BarangKeluarController::class, 'getData'])->name('getBarangKeluar');
Route::post('/updateBarangKeluar', [BarangKeluarController::class, 'update'])->name('barangKeluar.update');
Route::resource('barangKeluar',BarangKeluarController::class)->names([
    'index'   => 'barangKeluar.index',
    'create'  => 'barangKeluar.create',
    'store'   => 'barangKeluar.store',
    'show'    => 'barangKeluar.show',
    'edit'    => 'barangKeluar.edit',
    'destroy' => 'barangKeluar.destroy',
])->except('update');

Route::get('/getBarangMasuk', [BarangMasukController::class, 'getData'])->name('getBarangMasuk');
Route::post('/updateBarangMasuk', [BarangMasukController::class, 'update'])->name('barangMasuk.update');
Route::resource('barangMasuk',BarangMasukController::class)->names([
    'index'   => 'barangMasuk.index',
    'create'  => 'barangMasuk.create',
    'store'   => 'barangMasuk.store',
    'show'    => 'barangMasuk.show',
    'edit'    => 'barangMasuk.edit',
    'destroy' => 'barangMasuk.destroy',
])->except('update');

Route::get('/getBarang', [BarangController::class, 'getData'])->name('getBarang');
Route::post('/updateBarang', [BarangController::class, 'update'])->name('barang.update');
Route::resource('barang',BarangController::class)->names([
    'index'   => 'barang.index',
    'create'  => 'barang.create',
    'store'   => 'barang.store',
    'show'    => 'barang.show',
    'edit'    => 'barang.edit',
    'destroy' => 'barang.destroy',
])->except('update');



Route::get('/getDataAset', [AsetController::class, 'getData'])->name('getDataAset');
Route::post('/updateAset', [AsetController::class, 'update'])->name('aset.update');
Route::resource('aset',AsetController::class)->names([
    'index'   => 'aset.index',
    'create'  => 'aset.create',
    'store'   => 'aset.store',
    'show'    => 'aset.show',
    'edit'    => 'aset.edit',
    'destroy' => 'aset.destroy',
])->except('update');

Route::get('/acc', [PengajuanController::class, 'create'])->name('acc');
Route::get('/getDataAcc', [PengajuanController::class, 'getDataAcc'])->name('getDataAcc');
Route::post('/updateAcc', [PengajuanController::class, 'acc'])->name('acc.update');
Route::get('/getDetailDataAcc/{user_id}/{tgl}', [PengajuanController::class, 'getDetailData'])->name('getDetailDataAcc');
Route::get('/detailAcc/{user_id}/{tgl}', [PengajuanController::class, 'edit'])->name('detailAcc');

Route::get('/getDataPengajuan', [PengajuanController::class, 'getData'])->name('getDataPengajuan');
Route::post('/updatePengajuan', [PengajuanController::class, 'update'])->name('pengajuan.update');
Route::resource('pengajuan',PengajuanController::class)->names([
    'index'   => 'pengajuan.index',
    'store'   => 'pengajuan.store',
    'show'    => 'pengajuan.show',
    'destroy' => 'pengajuan.destroy',
])->except('update','create','edit');


// Route::redirect('/', '/dashboard-general-dashboard');

// Dashboard
Route::get('/dashboard-general-dashboard', function () {
    return view('pages.dashboard-general-dashboard', ['type_menu' => 'dashboard']);
});
Route::get('/dashboard-ecommerce-dashboard', function () {
    return view('pages.dashboard-ecommerce-dashboard', ['type_menu' => 'dashboard']);
});
