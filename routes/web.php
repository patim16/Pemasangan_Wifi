<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PaketLayananController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\MetodePembayaranController;
use App\Http\Controllers\KelolaPesananController;
use App\Models\PaketLayanan;

/*
|--------------------------------------------------------------------------
| PUBLIC ROUTES
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    $pakets = PaketLayanan::all();
    return view('landing', compact('pakets'));
});

// AUTH
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

    Route::get('/dashboard', [UserController::class, 'superAdminDashboard'])
        ->name('superadmin.dashboard');

    // Paket Layanan
    Route::get('/paketlayanan', [PaketLayananController::class, 'index'])->name('superadmin.paketlayanan');
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
        Route::put('/terima/{id}', [UserController::class, 'terimaPelanggan'])->name('terima');
        Route::put('/tolak/{id}', [UserController::class, 'tolakPelanggan'])->name('tolak');
    });

    // Metode Pembayaran
    Route::get('/metodepembayaran', [MetodePembayaranController::class, 'index'])->name('superadmin.metodepembayaran');
    Route::post('/metodepembayaran/store', [MetodePembayaranController::class, 'store']);
    Route::put('/metodepembayaran/update/{id}', [MetodePembayaranController::class, 'update']);
    Route::delete('/metodepembayaran/delete/{id}', [MetodePembayaranController::class, 'destroy']);

    // Kelola Pesanan
    Route::get('/kelolapesanan', [KelolaPesananController::class, 'kelolaPesanan'])->name('superadmin.kelolapesanan');
    Route::put('/pesanan/terima/{id}', [KelolaPesananController::class, 'terima'])->name('superadmin.pesanan.terima');
    Route::put('/pesanan/tolak/{id}', [KelolaPesananController::class, 'tolak'])->name('superadmin.pesanan.tolak');
    Route::put('/pesanan/jadwal/{id}', [KelolaPesananController::class, 'aturJadwal'])->name('superadmin.pesanan.jadwal');
});

/*
|--------------------------------------------------------------------------
| ADMIN ROUTES
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->group(function () {

    Route::get('/dashboard', [UserController::class, 'adminDashboard'])->name('admin.dashboard');

    // Paket Layanan
    Route::get('/paketlayanan', [PaketLayananController::class, 'index'])->name('admin.paketlayanan');
    Route::post('/paketlayanan/store', [PaketLayananController::class, 'store']);
    Route::put('/paketlayanan/update/{id}', [PaketLayananController::class, 'update']);
    Route::delete('/paketlayanan/delete/{id}', [PaketLayananController::class, 'destroy']);

    // Metode Pembayaran
    Route::get('/metodepembayaran', [MetodePembayaranController::class, 'index'])->name('admin.metodepembayaran');
    Route::post('/metodepembayaran/store', [MetodePembayaranController::class, 'store']);
    Route::put('/metodepembayaran/update/{id}', [MetodePembayaranController::class, 'update']);
    Route::delete('/metodepembayaran/delete/{id}', [MetodePembayaranController::class, 'destroy']);

    // Kelola Pesanan
    Route::get('/kelolapesanan', [KelolaPesananController::class, 'kelolaPesanan'])->name('admin.kelolapesanan');
    Route::post('/pesanan/{id}/terima', [KelolaPesananController::class, 'terima'])->name('admin.pesanan.terima');
    Route::post('/pesanan/{id}/jadwal-survei', [KelolaPesananController::class, 'jadwalSurvei'])->name('admin.pesanan.jadwalSurvei');
    Route::post('/pesanan/{id}/laporan-survei', [KelolaPesananController::class, 'laporanSurvei'])->name('admin.pesanan.laporanSurvei');
    Route::post('/pesanan/{id}/kirim-tagihan', [KelolaPesananController::class, 'kirimTagihan'])->name('admin.pesanan.kirimTagihan');
    Route::post('/pesanan/{id}/konfirmasi-bayar', [KelolaPesananController::class, 'konfirmasiPembayaran'])->name('admin.pesanan.konfirmasiPembayaran');
    Route::post('/pesanan/{id}/jadwal-instalasi', [KelolaPesananController::class, 'jadwalInstalasi'])->name('admin.pesanan.jadwalInstalasi');
    Route::post('/pesanan/{id}/instalasi-selesai', [KelolaPesananController::class, 'instalasiSelesai'])->name('admin.pesanan.instalasiSelesai');
    Route::put('/pesanan/{id}/jadwal-survei/update', [KelolaPesananController::class, 'updateJadwalSurvei'])->name('admin.pesanan.jadwalSurvei.update');
});
    // Kelola Payment
    Route::get('/kelolapayment', [UserController::class, 'indexPayment'])->name('admin.kelolapayment');

    // Kelola Teknisi
    Route::get('/kelolateknisi', [UserController::class, 'indexTeknisi'])->name('admin.kelolateknisi');

    // Kelola Pelanggan
    Route::get('/kelolapelanggan', [UserController::class, 'indexPelanggan'])->name('admin.kelolapelanggan');

/*
|--------------------------------------------------------------------------
| PELANGGAN ROUTES
|--------------------------------------------------------------------------
*/
Route::prefix('pelanggan')->group(function () {
    Route::get('/dashboard', [PelangganController::class, 'dashboard'])->name('pelanggan.dashboard');
    Route::get('/pesan-wifi', [PelangganController::class, 'pilihPaket'])->name('pelanggan.pesanwifi');
    Route::get('/pesan-wifi/{id}', [PelangganController::class, 'detailPaket'])->name('pelanggan.detailpaket');
    Route::get('/pesan-wifi/{id}/jadwal', [PelangganController::class, 'pilihJadwal'])->name('pelanggan.jadwal');
    Route::post('/pesan-wifi/{id}/jadwal', [PelangganController::class, 'simpanJadwal'])->name('pelanggan.jadwal.simpan');
    Route::get('/pesan-wifi/{id}/input-data', [PelangganController::class, 'inputData'])->name('pelanggan.inputdata');
    Route::post('/pesan-wifi/{paket_id}/input-data', [PelangganController::class, 'simpanInputData'])->name('pelanggan.inputdata.simpan');
    Route::get('/invoice/{paket_id}', [PelangganController::class, 'invoice'])->name('pelanggan.invoice');
    Route::post('/invoice/{paket_id}/konfirmasi', [PelangganController::class, 'konfirmasiPemesanan'])->name('pelanggan.konfirmasi');
    Route::get('/invoice/cetak/{id}', [PelangganController::class, 'cetakInvoice'])->name('pelanggan.invoice.cetak');
    Route::get('/riwayat', [PelangganController::class, 'riwayat'])->name('pelanggan.riwayat');
});

/*
|--------------------------------------------------------------------------
| PAYMENT ROUTES
|--------------------------------------------------------------------------
*/
Route::prefix('payment')->group(function () {
    Route::get('/dashboard', [PaymentController::class, 'dashboard'])->name('payment.dashboard');
    Route::get('/pembayaran', [PaymentController::class, 'list'])->name('payment.list');
    Route::get('/pembayaran/{id}', [PaymentController::class, 'detail'])->name('payment.detail');
    Route::post('/pembayaran/{id}/valid', [PaymentController::class, 'valid'])->name('payment.valid');
    Route::post('/pembayaran/{id}/invalid', [PaymentController::class, 'invalid'])->name('payment.invalid');

    Route::get('/rekap', [PaymentController::class, 'rekapIndex'])->name('payment.rekap.index');
    Route::get('/rekap/pdf', [PaymentController::class, 'rekapPDF'])->name('payment.rekap.pdf');
    Route::get('/rekap/export-excel', [PaymentController::class, 'exportExcel'])->name('payment.rekap.excel');

    Route::post('/tagihan/kirim/{id}', [PaymentController::class, 'kirimTagihan'])->name('payment.tagihan.kirim');
    Route::get('/status', [PaymentController::class, 'statusPage'])->name('payment.status');
    Route::post('/status/update/{id}', [PaymentController::class, 'updateStatus'])->name('payment.status.update');

    Route::prefix('tagihan')->group(function () {
        Route::get('/', [PaymentController::class, 'tagihanBulanan'])->name('payment.tagihan.bulanan');
        Route::get('/detail/{id}', [PaymentController::class, 'tagihanDetail'])->name('payment.tagihan.detail');
        Route::post('/konfirmasi/{id}', [PaymentController::class, 'tagihanKonfirmasi'])->name('payment.tagihan.konfirmasi');
    });
});
