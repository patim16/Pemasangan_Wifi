<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PaketLayananController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\MetodePembayaranController;
use App\Http\Controllers\KelolaPesananController;
use App\Http\Controllers\TeknisiController;
use App\Models\PaketLayanan;

/*
|--------------------------------------------------------------------------
| PUBLIC ROUTES
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('welcome');
    $pakets = PaketLayanan::all();
    return view('landing', compact('pakets'));
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

   // SUPERADMIN PELANGGAN
Route::prefix('superadmin/pelanggan')->name('superadmin.pelanggan.')->group(function () {
    Route::get('/', [UserController::class, 'indexPelanggan'])->name('index');
    Route::put('/terima/{id}', [UserController::class, 'terimaPelanggan'])->name('terima');
    Route::put('/tolak/{id}', [UserController::class, 'tolakPelanggan'])->name('tolak');
});

Route::put('/pelanggan/terima/{id}', [UserController::class, 'terimaPelanggan'])
    ->name('superadmin.pelanggan.terima');

Route::put('/pelanggan/tolak/{id}', [UserController::class, 'tolakPelanggan'])
    ->name('superadmin.pelanggan.tolak');

    // Metode Pembayaran
    Route::get('/metodepembayaran', [MetodePembayaranController::class, 'index'])
        ->name('superadmin.metodepembayaran');
    Route::post('/metodepembayaran/store', [MetodePembayaranController::class, 'store']);
    Route::put('/metodepembayaran/update/{id}', [MetodePembayaranController::class, 'update']);
    Route::delete('/metodepembayaran/delete/{id}', [MetodePembayaranController::class, 'destroy']);



     // Kelola Pesanan WiFi
    Route::get('/kelolapesanan', [KelolaPesananController::class, 'index'])

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

    Route::get('/dashboard', [UserController::class, 'adminDashboard'])
        ->name('admin.dashboard');

   
    // Dashboard
    Route::get('/dashboard', [UserController::class, 'adminDashboard'])
        ->name('admin.dashboard');

    // Paket Layanan
    Route::resource('/paketlayanan', PaketLayananController::class)->names([
        'index' => 'admin.paketlayanan'
    ]);

    // Metode Pembayaran
    Route::resource('/metodepembayaran', MetodePembayaranController::class)->names([
        'index' => 'admin.metodepembayaran'
    ]);

    // Kelola Payment
    Route::get('/kelolapayment', [UserController::class, 'indexPayment'])->name('admin.kelolapayment');

    // Kelola Teknisi
    Route::get('/kelolateknisi', [UserController::class, 'indexTeknisi'])->name('admin.kelolateknisi');

    // Kelola Pelanggan
    Route::get('/kelolapelanggan', [UserController::class, 'indexPelanggan'])->name('admin.kelolapelanggan');

    // Pesanan WiFi
    Route::get('/kelolapesanan', [KelolaPesananController::class, 'kelolaPesanan'])
        ->name('admin.kelolapesanan');
    Route::put('/pesanan/terima/{id}', [KelolaPesananController::class, 'terima'])
        ->name('admin.pesanan.terima');
    Route::put('/pesanan/tolak/{id}', [KelolaPesananController::class, 'tolak'])
        ->name('admin.pesanan.tolak');
    Route::put('/pesanan/jadwal/{id}', [KelolaPesananController::class, 'aturJadwal'])
        ->name('admin.pesanan.jadwal');

  /*
|---------------------------------------------
| KELOLA PESANAN WIFI (ADMIN)
|---------------------------------------------
*/


    
    Route::get('/kelolapesanan', [KelolaPesananController::class, 'kelolaPesanan'])
        ->name('admin.kelolapesanan');

    // TERIMA PESANAN
    Route::post('/pesanan/{id}/terima', [KelolaPesananController::class, 'terima'])
        ->name('admin.pesanan.terima');

    // JADWAL SURVEI
    Route::post('/pesanan/{id}/jadwal-survei', [KelolaPesananController::class, 'jadwalSurvei'])
        ->name('admin.pesanan.jadwalSurvei');

    // LAPORAN SURVEI
    Route::post('/pesanan/{id}/laporan-survei', [KelolaPesananController::class, 'laporanSurvei'])
        ->name('admin.pesanan.laporanSurvei');

    // KIRIM TAGIHAN
    Route::post('/pesanan/{id}/kirim-tagihan', [KelolaPesananController::class, 'kirimTagihan'])
        ->name('admin.pesanan.kirimTagihan');

    // KONFIRMASI PEMBAYARAN
    Route::post('/pesanan/{id}/konfirmasi-bayar', [KelolaPesananController::class, 'konfirmasiPembayaran'])
        ->name('admin.pesanan.konfirmasiPembayaran');

    // JADWAL INSTALASI
    Route::post('/pesanan/{id}/jadwal-instalasi', [KelolaPesananController::class, 'jadwalInstalasi'])
        ->name('admin.pesanan.jadwalInstalasi');

    // INSTALASI SELESAI
    Route::post('/pesanan/{id}/instalasi-selesai', [KelolaPesananController::class, 'instalasiSelesai'])
        ->name('admin.pesanan.instalasiSelesai');
//UPDATE JADWAL SURVEI
    Route::put('/pesanan/{id}/jadwal-survei/update', [KelolaPesananController::class, 'updateJadwalSurvei'])
    ->name('pesanan.jadwalSurvei.update');

});

/*
|--------------------------------------------------------------------------
| TEKNISI ROUTES
|--------------------------------------------------------------------------
*/
Route::prefix('teknisi')->name('teknisi.')->group(function () {

    // Dashboard
    Route::get('/dashboard', [TeknisiController::class, 'dashboard'])->name('dashboard');

    // Laporan Pemasangan
    Route::get('/laporan', [TeknisiController::class, 'formLaporan'])->name('laporan.form');
    Route::post('/laporan', [TeknisiController::class, 'kirimLaporanPemasangan'])->name('laporan.store');

    // Jadwal Survei
    Route::get('/jadwal-survei', [TeknisiController::class, 'jadwalSurveyTeknisi'])->name('jadwal-survei');
    Route::get('/jadwal-survei/detail/{id}', [TeknisiController::class, 'detailSurvei'])->name('detail-survei');

    // Jadwal Pemasangan
    Route::get('/jadwal-pemasangan', [TeknisiController::class, 'jadwalPemasangan'])
        ->name('jadwal-pemasangan');

    Route::post('/jadwal-pemasangan/simpan', [TeknisiController::class, 'simpanJadwalPemasangan'])
        ->name('jadwal-pemasangan.simpan');

    // Detail Pemasangan
    // Route::get('/detail-pemasangan/{kode}', [TeknisiController::class, 'detailPemasangan'])
    //     ->name('detail-pemasangan');

    // Detail Instalasi
    Route::get('/instalasi/{id}/detail', [TeknisiController::class, 'detailInstalasi'])
        ->name('instalasi.detail');

    // Status Pemasangan
    Route::get('/status', [TeknisiController::class, 'updateStatus'])->name('status');
    Route::post('/status/update', [TeknisiController::class, 'updateStatusSubmit'])->name('status.update');


    Route::get('/jadwal-pemasangan', [TeknisiController::class, 'jadwalPemasangan'])
        ->name('jadwal-pemasangan');

    Route::get('/detail-pemasangan/{id}', [TeknisiController::class, 'detailPemasangan'])
        ->name('detail-pemasangan');
});



/*
|--------------------------------------------------------------------------
| PELANGGAN ROUTES
|--------------------------------------------------------------------------
*/

Route::prefix('pelanggan')->group(function () {

    Route::get('/dashboard', [PelangganController::class, 'dashboard'])
        ->name('pelanggan.dashboard');

    // Pesan WiFi
    Route::get('/pesan-wifi', [PelangganController::class, 'pilihPaket'])
        ->name('pelanggan.pesanwifi');

    Route::get('/pesan-wifi/{id}', [PelangganController::class, 'detailPaket'])
        ->name('pelanggan.detailpaket');

    // Jadwal
    Route::get('/pesan-wifi/{id}/jadwal', [PelangganController::class, 'pilihJadwal'])
        ->name('pelanggan.jadwal');
    Route::post('/pesan-wifi/{id}/jadwal', [PelangganController::class, 'simpanJadwal'])
        ->name('pelanggan.jadwal.simpan');

    // Input Data
    Route::get('/pesan-wifi/{id}/input-data', [PelangganController::class, 'inputData'])
        ->name('pelanggan.inputdata');
    Route::post('/pesan-wifi/{paket_id}/input-data', [PelangganController::class, 'simpanInputData'])
        ->name('pelanggan.inputdata.simpan');

    // Invoice
    Route::get('/invoice/{paket_id}', [PelangganController::class, 'invoice'])
        ->name('pelanggan.invoice');
    Route::post('/invoice/{paket_id}/konfirmasi', [PelangganController::class, 'konfirmasiPemesanan'])
        ->name('pelanggan.konfirmasi');
    Route::get('/invoice/cetak/{id}', [PelangganController::class, 'cetakInvoice'])
        ->name('pelanggan.invoice.cetak');

    // Riwayat
    Route::get('/riwayat', [PelangganController::class, 'riwayat'])
        ->name('pelanggan.riwayat');
});

// PAYMENT
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



//pelanggan

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
    Route::get('/pelanggan/paket/{id}', [PelangganController::class, 'detailPaket'])->name('pelanggan.paket.detail');

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
