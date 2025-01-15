<?php

use App\Http\Controllers\AsetController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\BarangKeluarController;
use App\Http\Controllers\BarangMasukController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DepartementController;
use App\Http\Controllers\HeaderBarangController;
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
Route::get('/login',[AuthController::class,'index'])->name('login')->middleware('guest');
Route::post('/login-submit',[AuthController::class,'login'])->name('login-submit');
Route::post('/logout',[AuthController::class,'logout'])->name('logout');


// Dashboard
// Route::get('/dashboard',[dashboardController::class,'index'])->name('dashboard');

Route::get('/getDataDepartement', [DepartementController::class, 'getData'])->name('getDataDepartement')->middleware('auth');
Route::post('/updateDepartement', [DepartementController::class, 'update'])->name('departement.update')->middleware('auth');
Route::resource('departement',DepartementController::class)->names([
    'index'   => 'departement.index',
    'create'  => 'departement.create',
    'store'   => 'departement.store',
    'show'    => 'departement.show',
    'edit'    => 'departement.edit',
    'destroy' => 'departement.destroy',
])->except('update')->middleware('auth');

Route::get('/getDataHeader', [HeaderBarangController::class, 'getData'])->name('getDataHeader')->middleware('auth');
Route::post('/updateHeader', [HeaderBarangController::class, 'update'])->name('header.update')->middleware('auth');
Route::resource('header',HeaderBarangController::class)->names([
    'index'   => 'header.index',
    'create'  => 'header.create',
    'store'   => 'header.store',
    'show'    => 'header.show',
    'edit'    => 'header.edit',
    'destroy' => 'header.destroy',
])->except('update')->middleware('auth');

Route::get('/getDataUser', [UserController::class, 'getData'])->name('getDataUser')->middleware('auth');
Route::post('/updateUser', [UserController::class, 'update'])->name('user.update')->middleware('auth');
Route::resource('user',UserController::class)->names([
    'index'   => 'user.index',
    'create'  => 'user.create',
    'store'   => 'user.store',
    'show'    => 'user.show',
    'edit'    => 'user.edit',
    'destroy' => 'user.destroy',
])->except('update')->middleware('auth');


Route::get('/getBarangKeluar', [BarangKeluarController::class, 'getData'])->name('getBarangKeluar')->middleware('auth');
Route::get('/reportBarangKeluar', [BarangKeluarController::class, 'create'])->name('reportBarangKeluar')->middleware('auth');
Route::get('/printBarangKeluar/{tgl_awal}/{tgl_akhir}', [BarangKeluarController::class, 'print'])->name('printBarangKeluar')->middleware('auth');
Route::post('/updateBarangKeluar', [BarangKeluarController::class, 'update'])->name('barangKeluar.update')->middleware('auth');
Route::resource('barangKeluar',BarangKeluarController::class)->names([
    'index'   => 'barangKeluar.index',
    'store'   => 'barangKeluar.store',
    'show'    => 'barangKeluar.show',
    'edit'    => 'barangKeluar.edit',
    'destroy' => 'barangKeluar.destroy',
])->except('update')->middleware('auth');

Route::get('/getBarangMasuk', [BarangMasukController::class, 'getData'])->name('getBarangMasuk')->middleware('auth');
Route::get('/reportBarangMasuk', [BarangMasukController::class, 'create'])->name('reportBarangMasuk')->middleware('auth');
Route::get('/printBarangMasuk/{tgl_awal}/{tgl_akhir}', [BarangMasukController::class, 'print'])->name('printBarangMasuk')->middleware('auth');
Route::post('/updateBarangMasuk', [BarangMasukController::class, 'update'])->name('barangMasuk.update')->middleware('auth');
Route::resource('barangMasuk',BarangMasukController::class)->names([
    'index'   => 'barangMasuk.index',
    'store'   => 'barangMasuk.store',
    'show'    => 'barangMasuk.show',
    'edit'    => 'barangMasuk.edit',
    'destroy' => 'barangMasuk.destroy',
])->except('update')->middleware('auth');

Route::get('/getBarang', [BarangController::class, 'getData'])->name('getBarang');
Route::get('/reportBarang', [BarangController::class, 'create'])->name('reportBarang');
Route::get('/printBarang/{tgl_awal}/{tgl_akhir}', [BarangController::class, 'print'])->name('printBarang');
Route::post('/updateBarang', [BarangController::class, 'update'])->name('barang.update');
Route::resource('barang',BarangController::class)->names([
    'index'   => 'barang.index',
    'store'   => 'barang.store',
    'show'    => 'barang.show',
    'edit'    => 'barang.edit',
    'destroy' => 'barang.destroy',
])->except('update')->middleware('auth');



Route::get('/getDataAset', [AsetController::class, 'getData'])->name('getDataAset');
Route::post('/updateAset', [AsetController::class, 'update'])->name('aset.update');
Route::resource('aset',AsetController::class)->names([
    'index'   => 'aset.index',
    'store'   => 'aset.store',
    'show'    => 'aset.show',
    'edit'    => 'aset.edit',
    'destroy' => 'aset.destroy',
])->except('update')->middleware('auth');

Route::get('/acc', [PengajuanController::class, 'create'])->name('acc')->middleware('auth');
Route::get('/getDataAcc', [PengajuanController::class, 'getDataAcc'])->name('getDataAcc');
Route::post('/updateAcc', [PengajuanController::class, 'acc'])->name('acc.update');
Route::get('/getDetailDataAcc/{user_id}/{tgl}', [PengajuanController::class, 'getDetailData'])->name('getDetailDataAcc');
Route::get('/detailAcc/{user_id}/{tgl}', [PengajuanController::class, 'edit'])->name('detailAcc')->middleware('auth');

Route::get('/getDataPengajuan', [PengajuanController::class, 'getData'])->name('getDataPengajuan');
Route::post('/updatePengajuan', [PengajuanController::class, 'update'])->name('pengajuan.update');
Route::resource('pengajuan',PengajuanController::class)->names([
    'index'   => 'pengajuan.index',
    'store'   => 'pengajuan.store',
    'show'    => 'pengajuan.show',
    'destroy' => 'pengajuan.destroy',
])->except('update','create','edit')->middleware('auth');

Route::get('/reportPengajuan', [PengajuanController::class, 'edit'])->name('reportPengajuan')->middleware('auth');


// Route::redirect('/', '/dashboard-general-dashboard');

// Dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard')->middleware('auth');

