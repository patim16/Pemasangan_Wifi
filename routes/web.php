<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PaketLayananController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\MetodePembayaranController;
use App\Http\Controllers\KelolaPesananController;

/*
|--------------------------------------------------------------------------
| PUBLIC ROUTES
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('landing');
});

// Auth
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/register', [AuthController::class, 'showRegister']);
Route::post('/register', [AuthController::class, 'register']);


/*
|--------------------------------------------------------------------------
| SUPERADMIN ROUTES
|--------------------------------------------------------------------------
*/
Route::prefix('superadmin')->group(function () {

    // Dashboard
    Route::get('/dashboard', [UserController::class, 'superAdminDashboard'])
        ->name('superadmin.dashboard');

    // Paket Layanan
    Route::get('/paketlayanan', [PaketLayananController::class, 'index'])
        ->name('superadmin.paketlayanan');
    Route::post('/paketlayanan/store', [PaketLayananController::class, 'store']);
    Route::put('/paketlayanan/update/{id}', [PaketLayananController::class, 'update']);
    Route::delete('/paketlayanan/delete/{id}', [PaketLayananController::class, 'destroy']);

    // Kelola Admin
    Route::get('/admin', [UserController::class, 'indexAdmin'])->name('superadmin.admin.index');
    Route::post('/admin/store', [UserController::class, 'storeAdmin'])->name('superadmin.admin.store');
    Route::put('/admin/update/{id}', [UserController::class, 'updateAdmin'])->name('superadmin.admin.update');
    Route::delete('/admin/delete/{id}', [UserController::class, 'deleteAdmin'])->name('superadmin.admin.delete');

    // Kelola Teknisi
    Route::get('/teknisi', [UserController::class, 'indexTeknisi'])->name('superadmin.teknisi.index');
    Route::post('/teknisi/store', [UserController::class, 'storeTeknisi'])->name('superadmin.teknisi.store');
    Route::put('/teknisi/update/{id}', [UserController::class, 'updateTeknisi'])->name('superadmin.teknisi.update');
    Route::delete('/teknisi/delete/{id}', [UserController::class, 'deleteTeknisi'])->name('superadmin.teknisi.delete');

    // Kelola Payment 
    Route::get('/payment', [UserController::class, 'indexPayment'])->name('superadmin.payment.index');
    Route::post('/payment/store', [UserController::class, 'storePayment'])->name('superadmin.payment.store');
    Route::put('/payment/update/{id}', [UserController::class, 'updatePayment'])->name('superadmin.payment.update');
    Route::delete('/payment/delete/{id}', [UserController::class, 'deletePayment'])->name('superadmin.payment.delete');

    // Kelola Pelanggan
    Route::prefix('pelanggan')->name('superadmin.pelanggan.')->group(function () {
        Route::get('/', [UserController::class, 'indexPelanggan'])->name('index');
        Route::put('/update/{id}', [UserController::class, 'updatePelanggan'])->name('update');
        Route::delete('/delete/{id}', [UserController::class, 'deletePelanggan'])->name('delete');
    });

    // Metode Pembayaran
    Route::get('/metodepembayaran', [MetodePembayaranController::class, 'index'])
        ->name('superadmin.metodepembayaran');
    Route::post('/metodepembayaran/store', [MetodePembayaranController::class, 'store'])
        ->name('superadmin.metodepembayaran.store');
    Route::put('/metodepembayaran/update/{id}', [MetodePembayaranController::class, 'update'])
        ->name('superadmin.metodepembayaran.update');
    Route::delete('/metodepembayaran/delete/{id}', [MetodePembayaranController::class, 'destroy'])
        ->name('superadmin.metodepembayaran.delete');

     // Kelola Pesanan WiFi
    Route::get('/kelolapesanan', [KelolaPesananController::class, 'kelolaPesanan'])
        ->name('superadmin.kelolapesanan');
    Route::put('/pesanan/terima/{id}', [KelolaPesananController::class, 'terima'])
        ->name('superadmin.pesanan.terima');
    Route::put('/pesanan/tolak/{id}', [KelolaPesananController::class, 'tolak'])
        ->name('superadmin.pesanan.tolak');
    Route::put('/pesanan/jadwal/{id}', [KelolaPesananController::class, 'aturJadwal'])
        ->name('superadmin.pesanan.jadwal');

});


/*
|--------------------------------------------------------------------------
| ADMIN ROUTES 
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->group(function () {

    // Dashboard
    Route::get('/dashboard', [UserController::class, 'adminDashboard'])
        ->name('admin.dashboard');

    /*
    |---------------------------------------------
    | PAKET LAYANAN
    |---------------------------------------------
    */
    Route::get('/paketlayanan', [PaketLayananController::class, 'index'])
        ->name('admin.paketlayanan');
    Route::post('/paketlayanan/store', [PaketLayananController::class, 'store'])
        ->name('admin.paketlayanan.store');
    Route::put('/paketlayanan/update/{id}', [PaketLayananController::class, 'update'])
        ->name('admin.paketlayanan.update');
    Route::delete('/paketlayanan/delete/{id}', [PaketLayananController::class, 'destroy'])
        ->name('admin.paketlayanan.delete');

    /*
    |---------------------------------------------
    | METODE PEMBAYARAN
    |---------------------------------------------
    */
    Route::get('/metodepembayaran', [MetodePembayaranController::class, 'index'])
        ->name('admin.metodepembayaran');
    Route::post('/metodepembayaran/store', [MetodePembayaranController::class, 'store'])
        ->name('admin.metodepembayaran.store');
    Route::put('/metodepembayaran/update/{id}', [MetodePembayaranController::class, 'update'])
        ->name('admin.metodepembayaran.update');
    Route::delete('/metodepembayaran/delete/{id}', [MetodePembayaranController::class, 'destroy'])
        ->name('admin.metodepembayaran.delete');

    /*
    |---------------------------------------------
    | KELOLA PAYMENT
    |---------------------------------------------
    */
    Route::get('/kelolapayment', [UserController::class, 'indexPayment'])
        ->name('admin.kelolapayment');
    Route::post('/kelolapayment/store', [UserController::class, 'storePayment'])
        ->name('admin.kelolapayment.store');
    Route::put('/kelolapayment/update/{id}', [UserController::class, 'updatePayment'])
        ->name('admin.kelolapayment.update');
    Route::delete('/kelolapayment/delete/{id}', [UserController::class, 'deletePayment'])
        ->name('admin.kelolapayment.delete');

    /*
    |---------------------------------------------
    | KELOLA TEKNISI
    |---------------------------------------------
    */
    Route::get('/kelolateknisi', [UserController::class, 'indexTeknisi'])
        ->name('admin.kelolateknisi');
    Route::post('/kelolateknisi/store', [UserController::class, 'storeTeknisi'])
        ->name('admin.kelolateknisi.store');
    Route::put('/kelolateknisi/update/{id}', [UserController::class, 'updateTeknisi'])
        ->name('admin.kelolateknisi.update');
    Route::delete('/kelolateknisi/delete/{id}', [UserController::class, 'deleteTeknisi'])
        ->name('admin.kelolateknisi.delete');

    /*
    |---------------------------------------------
    | KELOLA PELANGGAN
    |---------------------------------------------
    */
    Route::get('/kelolapelanggan', [UserController::class, 'indexPelanggan'])
        ->name('admin.kelolapelanggan');
    Route::put('/kelolapelanggan/update/{id}', [UserController::class, 'updatePelanggan'])
        ->name('admin.kelolapelanggan.update');
    Route::delete('/kelolapelanggan/delete/{id}', [UserController::class, 'deletePelanggan'])
        ->name('admin.kelolapelanggan.delete');

    /*
    |---------------------------------------------
    | KELOLA PESANAN WiFi
    |---------------------------------------------
    */
    Route::get('/kelolapesanan', [KelolaPesananController::class, 'kelolaPesanan'])
        ->name('admin.kelolapesanan');

    Route::put('/pesanan/terima/{id}', [KelolaPesananController::class, 'terima'])
        ->name('admin.pesanan.terima');

    Route::put('/pesanan/tolak/{id}', [KelolaPesananController::class, 'tolak'])
        ->name('admin.pesanan.tolak');

    Route::put('/pesanan/jadwal/{id}', [KelolaPesananController::class, 'aturJadwal'])
        ->name('admin.pesanan.jadwal');
});


/*
|--------------------------------------------------------------------------
| TEKNISI ROUTES
|--------------------------------------------------------------------------
*/
Route::prefix('teknisi')->group(function () {
    Route::get('/dashboard', [UserController::class, 'teknisiDashboard'])
        ->name('teknisi.dashboard');
});


/*
|--------------------------------------------------------------------------
| PAYMENT ROUTES
|--------------------------------------------------------------------------
*/
Route::prefix('payment')->group(function () {

    Route::get('/dashboard', [PaymentController::class, 'dashboard'])
        ->name('payment.dashboard');

    // Pembayaran
    Route::get('/pembayaran', [PaymentController::class, 'list'])
        ->name('payment.list');

    Route::get('/pembayaran/{id}', [PaymentController::class, 'detail'])
        ->name('payment.detail');

   // (valid / invalid)
    Route::post('/pembayaran/{id}/valid', [PaymentController::class, 'valid'])
        ->name('payment.valid');

    Route::post('/pembayaran/{id}/invalid', [PaymentController::class, 'invalid'])
        ->name('payment.invalid');

    // REKAP HARIAN & BULANAN
    Route::prefix('payment')->group(function () {
    Route::get('/rekap', [PaymentController::class, 'rekapIndex'])->name('payment.rekap.index');
    Route::get('/rekap/pdf', [PaymentController::class, 'rekapPDF'])->name('payment.rekap.pdf');
});    


    //Halaman update status
    Route::get('/payment/status', [PaymentController::class, 'statusPage'])
    ->name('payment.status');
    Route::post('/payment/status/update/{id}', [PaymentController::class, 'updateStatus'])
    ->name('payment.status.update');

});



/*
|--------------------------------------------------------------------------
| PELANGGAN ROUTE
|--------------------------------------------------------------------------
*/// Dashboard Pelanggan
Route::get('/pelanggan/dashboard', [PelangganController::class, 'dashboard'])
     ->name('pelanggan.dashboard');
//pilih paket
    Route::get('/pelanggan/pesan-wifi', [PelangganController::class, 'pilihPaket'])
     ->name('pelanggan.pesanwifi');
//detail paket
     Route::get('/pelanggan/pesan-wifi/{id}', [PelangganController::class, 'detailPaket'])
     ->name('pelanggan.detailpaket');
//pilih jadwal
     Route::get('/pelanggan/pesan-wifi/{id}/jadwal', [PelangganController::class, 'pilihJadwal'])
    ->name('pelanggan.jadwal');
    Route::post('/pelanggan/pesan-wifi/{id}/jadwal', [PelangganController::class, 'simpanJadwal'])
    ->name('pelanggan.jadwal.simpan');
//input data
    Route::get('/pelanggan/pesan-wifi/{id}/input-data', [PelangganController::class, 'inputData'])
    ->name('pelanggan.inputdata');
    Route::post('/pelanggan/pesan-wifi/{paket_id}/input-data', [PelangganController::class, 'simpanInputData'])
    ->name('pelanggan.inputdata.simpan');
//invoice
    Route::get('/pelanggan/invoice/{paket_id}', [PelangganController::class, 'invoice'])
    ->name('pelanggan.invoice');
//konfirmasi pemesanan
    Route::post('/pelanggan/invoice/{paket_id}/konfirmasi', [PelangganController::class, 'konfirmasiPemesanan'])
    ->name('pelanggan.konfirmasi');
// riwayat pemesanan
    Route::get('/pelanggan/riwayat', [PelangganController::class, 'riwayat'])
    ->name('pelanggan.riwayat');
// cetak invoice    
Route::get('/pelanggan/invoice/cetak/{id}', [PelangganController::class, 'cetakInvoice'])->name('pelanggan.invoice.cetak');







    

// Pelanggan (belum diisi)
Route::prefix('pelanggan')->group(function () {
    // nanti diisi
});
