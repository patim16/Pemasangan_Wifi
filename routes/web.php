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
use App\Http\Controllers\TagihanBulananController;


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
Route::get('/metodepembayaran', [MetodePembayaranController::class, 'index'])
    ->name('superadmin.metodepembayaran');

Route::post('/metodepembayaran/store', [MetodePembayaranController::class, 'store'])
    ->name('superadmin.metodepembayaran.store');

Route::put('/metodepembayaran/update/{id}', [MetodePembayaranController::class, 'update'])
    ->name('superadmin.metodepembayaran.update');

Route::delete('/metodepembayaran/delete/{id}', [MetodePembayaranController::class, 'destroy'])
    ->name('superadmin.metodepembayaran.delete');

     // Kelola Pesanan WiFi
    Route::get('/kelolapesanan', [KelolaPesananController::class, 'KelolaPesanan'])

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
        ->name('dashboard');

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


    // Kelola Payment
    Route::get('/kelolapayment', [UserController::class, 'indexPayment'])->name('admin.kelolapayment');

    // Kelola Teknisi
    Route::get('/kelolateknisi', [UserController::class, 'indexTeknisi'])->name('admin.kelolateknisi');

    // Kelola Pelanggan
    Route::get('/kelolapelanggan', [UserController::class, 'indexPelanggan'])->name('admin.kelolapelanggan');


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

    Route::delete('/admin/pesanan/delete/{id}', [KelolaPesananController::class, 'deletePesanan'])
    ->name('pesanan.delete');

    Route::get('/pesanan', [KelolaPesananController::class, 'index'])
        ->name('admin.pesanan.index');

    Route::get('/pesanan/{id}', [KelolaPesananController::class, 'show'])
        ->name('admin.pesanan.show');


});

/*
|--------------------------------------------------------------------------
| TEKNISI ROUTES
|--------------------------------------------------------------------------
*/
Route::prefix('teknisi')->name('teknisi.')->group(function () {

    // Dashboard
    Route::get('/dashboard', [TeknisiController::class, 'dashboard'])
        ->name('dashboard');

    // ======================
    // SURVEI
    // ======================
    Route::get('/jadwal-survei', [TeknisiController::class, 'jadwalSurveyTeknisi'])
        ->name('jadwal-survei');

    Route::get('/jadwal-survei/detail/{id}', [TeknisiController::class, 'detailSurvei'])
        ->name('detail-survei');

    // ======================
    // PEMASANGAN
    // ======================
    Route::get('/jadwal-pemasangan', [TeknisiController::class, 'jadwalPemasangan'])
        ->name('jadwal-pemasangan');

    Route::get('/detail-pemasangan/{id}', [TeknisiController::class, 'detailPemasangan'])
        ->name('detail-pemasangan');
     Route::post('/jadwal-pemasangan/simpan',
    [TeknisiController::class, 'simpanJadwal'])
    ->name('jadwal-pemasangan.simpan');


    // ======================
    // LAPORAN PEMASANGAN
    // ======================
    Route::get('/laporan', [TeknisiController::class, 'formLaporan'])
        ->name('laporan');

    Route::post('/laporan', [TeknisiController::class, 'kirimLaporanPemasangan'])
        ->name('laporan.store');
   Route::post('/laporan', [TeknisiController::class, 'kirimLaporanPemasangan'])
        ->name('kirim-laporan');

    // ======================
    // INSTALASI
    // ======================
    Route::get('/instalasi/{id}/detail', [TeknisiController::class, 'detailInstalasi'])
        ->name('instalasi.detail');

    Route::get('/status', [TeknisiController::class, 'updateStatus'])
        ->name('status');

    Route::post('/status/update', [TeknisiController::class, 'updateStatusSubmit'])
        ->name('status.update');
     Route::post('/instalasi/{id}/selesai', [KelolaPesananController::class, 'instalasiSelesai'])
        ->name('instalasi.selesai');
    Route::get('/riwayat-instalasi', [TeknisiController::class, 'riwayatInstalasi'])
        ->name('riwayat-instalasi');
    Route::post('/teknisi/instalasi/{id}/selesai',   [TeknisiController::class, 'selesaiInstalasi'])
    ->name('instalasi.selesai');

    Route::get('/survei/{id}', [TeknisiController::class,'detailSurvei'])
    ->name('detail-survei');

Route::get('/pemasangan/{id}', [TeknisiController::class,'detailPemasangan'])
    ->name('detail-pemasangan');


});
    



/*
|--------------------------------------------------------------------------
| PELANGGAN ROUTES
|--------------------------------------------------------------------------
*/
Route::prefix('pelanggan')->group(function () {
    Route::get('/dashboard', [PelangganController::class, 'dashboard'])->name('pelanggan.dashboard');
    Route::get('/pesan-wifi', [PelangganController::class, 'pilihPaket'])->name('pelanggan.pesanwifi');
    Route::get('/pesan-wifi/{id}', [PelangganController::class, 'detailPaket'])->name('pelanggan.paket.detail');
    Route::get('/pesan-wifi/{id}/jadwal', [PelangganController::class, 'pilihJadwal'])->name('pelanggan.jadwal');
    Route::post('/pesan-wifi/{id}/jadwal', [PelangganController::class, 'simpanJadwal'])->name('pelanggan.jadwal.simpan');
    Route::get('/pesan-wifi/{id}/input-data', [PelangganController::class, 'inputData'])->name('pelanggan.inputdata');
    Route::post('/pesan-wifi/{paket_id}/input-data', [PelangganController::class, 'simpanInputData'])->name('pelanggan.inputdata.simpan');
    Route::get('/invoice/{paket_id}', [PelangganController::class, 'invoice'])->name('pelanggan.invoice');
    Route::post('/invoice/{paket_id}/konfirmasi', [PelangganController::class, 'konfirmasiPemesanan'])->name('pelanggan.konfirmasi');
    Route::get('/invoice/cetak/{id}', [PelangganController::class, 'cetakInvoice'])->name('pelanggan.invoice.cetak');
    Route::get('/riwayat', [PelangganController::class, 'riwayat'])->name('pelanggan.riwayat');
    Route::get('/riwayat-transaksi', [PelangganController::class, 'riwayatTransaksi'])  ->name('pelanggan.riwayat-transaksi');
    Route::get('/tagihan', [PelangganController::class, 'tagihan']) ->name('pelanggan.tagihan');
    Route::get('/tagihan/awal', [PelangganController::class, 'tagihanAwal']) ->name('pelanggan.tagihan.awal');
        Route::get('/tagihan/{tagihan}/bayar', [PelangganController::class, 'formBayar']) ->name('pelanggan.tagihan.bayar');
    Route::get('/tagihan/{tagihan}/bayar/tagihan/awal', [PelangganController::class, 'formBayarTagihanAwal']) ->name('pelanggan.tagihan.bayar.awal');
    Route::post('/tagihan/{tagihan}/pilih-metode', [PelangganController::class, 'pilihMetode'])  ->name('pelanggan.tagihan.pilihmetode');
    Route::get('/tagihan/{tagihan}/upload', [PelangganController::class, 'uploadBukti']) ->name('pelanggan.tagihan.upload');
    Route::post('/tagihan/{tagihan}/upload', [PelangganController::class, 'storeUpload']) ->name('pelanggan.tagihan.storeupload');

    Route::get('pelanggan/input-data/{id}', 
    [PelangganController::class, 'inputData'])
    ->name('pelanggan.input-data');

Route::post('pelanggan/input-data/{id}', 
    [PelangganController::class, 'simpanInputData'])
    ->name('pelanggan.input-data.simpan');



    // TAGIHAN BULANAN — FORM BAYAR
Route::get('/tagihan-bulanan/{tagihan}/bayar',
    [PelangganController::class, 'formBayarBulanan']
)->name('pelanggan.tagihan.bulanan.bayar');

// PILIH METODE PEMBAYARAN
Route::post('/tagihan-bulanan/{tagihan}/pilih-metode',
    [PelangganController::class, 'pilihMetodeBulanan']
)->name('pelanggan.tagihan.bulanan.pilihmetode');


/// FORM UPLOAD
Route::get('/tagihan-bulanan/{tagihan}/upload',
    [PelangganController::class, 'uploadBuktiBulanan']
)->name('pelanggan.tagihan.bulanan.upload');


// SIMPAN BUKTI
Route::post('/tagihan-bulanan/{tagihan}/upload',
    [PelangganController::class, 'storeUploadBulanan']
)->name('pelanggan.tagihan.bulanan.storeupload');


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
   Route::get('/verifikasi', [PaymentController::class, 'list']) ->name('payment.verifikasi');
    Route::post('/valid/{id}', [PaymentController::class, 'valid'])->name('valid');
    Route::post('/invalid/{id}', [PaymentController::class, 'invalid']) ->name('invalid');
    Route::post('/invalid/bulanan/{id}', [PaymentController::class, 'invalidBulanan']) ->name('invalid.bulanan');
    Route::get('/rekap', [PaymentController::class, 'rekapIndex'])->name('payment.rekap.index');
    Route::get('/rekap/pdf', [PaymentController::class, 'rekapPDF'])->name('payment.rekap.pdf');
    Route::get('/rekap/export-excel', [PaymentController::class, 'exportExcel'])->name('payment.rekap.excel');
    Route::post('/tagihan/kirim/{id}', [PaymentController::class, 'kirimTagihan'])->name('payment.tagihan.kirim');
    Route::get('/paket/{id}', [PaketLayananController::class, 'detail'])->name('paket.detail');



    Route::prefix('tagihan')->group(function () {
        Route::get('/', [PaymentController::class, 'tagihanBulanan'])->name('payment.tagihan.bulanan');
        Route::get('/detail/{id}', [PaymentController::class, 'tagihanDetail'])->name('payment.tagihan.detail');
        Route::post('/konfirmasi/{id}', [PaymentController::class, 'tagihanKonfirmasi'])->name('payment.tagihan.konfirmasi');


          // TAGIHAN AWAL
    Route::get('/tagihan-awal', [PaymentController::class, 'tagihanAwal'])
        ->name('payment.tagihan.awal');

    Route::post('/tagihan-awal/kirim/{pemesanan}', [PaymentController::class, 'kirimTagihanAwal'])
        ->name('payment.tagihan.awal.kirim');
   Route::get('/generate-tagihan-bulanan', [TagihanBulananController::class, 'generate'])->name('tagihan.generate');


   // ================== VERIFIKASI TAGIHAN BULANAN ==================

Route::post('/payment/tagihan-bulanan/{id}/terima',
    [PaymentController::class, 'verifikasiBulananTerima']
)->name('verifikasi.tagihan.terima');

Route::post('/payment/tagihan-bulanan/{id}/tolak',
    [PaymentController::class, 'verifikasiBulananTolak']
)->name('verifikasi.tagihan.tolak');

    });

    Route::get('/pesan-wifi', [pelangganController::class, 'create'])
    ->name('pesan.wifi');
  Route::post(
    '/pelanggan/tagihan-bulanan/{tagihan}/upload',
    [PelangganController::class, 'storeUploadBulanan']
)->name('pelanggan.tagihan.bulanan.upload.store');
});

    // Route::get('/pelanggan/tagihan/bulanan', [TagihanBulananController::class, 'index']) ->name('pelanggan.tagihan.bulanan');

    // Route::get('/tagihan/bulanan', function(){
    //     return view('payment.tagihan.bulanan');
    // });