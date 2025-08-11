<?php
use Illuminate\Support\Facades\Auth;
use App\Models\GiangVien;

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DangNhapController;
use App\Http\Controllers\ThongTinCaNhanController;
use App\Http\Controllers\KhoaController;

use App\Http\Controllers\ChuongTrinhDaoTaoController;
use App\Http\Controllers\CTChuongTrinhDaoTaoController;

use App\Http\Controllers\GiangVienController;
use App\Http\Controllers\ChucVuGiangVienController;
use App\Http\Controllers\HopDongCamDoController;

use App\Http\Controllers\SinhVienController;
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

// $user = Auth::user();
// dd($user);
Route::get('khongcoquyen', function () {
    // Auth::logout();
    return view('errors.403');
})->name('khongcoquyen');

Route::get('/admin/quenmatkhau', [DangNhapController::class,'hienFormGuiEmail'])->name('password.request');
Route::post('/admin/quenmatkhau', [DangNhapController::class,'guiEmailReset'])->name('password.email');
Route::get('/admin/datlaimatkhau/{token}', [DangNhapController::class,'hienFormDatLai'])->name('password.reset');
Route::post('/admin/datlaimatkhau', [DangNhapController::class,'reset'])->name('password.update');

Route::get('/admin/dangnhap', [DangNhapController::class,'dangNhap'])->name('login');
Route::post('/admin/dangnhap', [DangNhapController::class,'kiemTraDangNhap']);
Route::get('/admin/dangxuat', [DangNhapController::class,'dangXuat']);
Route::get('/', function () {return redirect('/admin');})->middleware('auth');
Route::group(['middleware' => 'auth', 'prefix' => 'admin'], function () {

    Route::get('/', function () {
        return view('admin.index');
    });
    Route::group(['middleware' => 'checkchucvu:1|2'], function () {
        Route::get('/khoa/getInactiveData', [KhoaController::class, 'getInactiveData'])->name('khoa.getInactiveData');
        Route::get('/khoa/restore/{id}', [KhoaController::class, 'restore'])->name('khoa.restore');
        Route::resource('khoa', KhoaController::class);


        Route::get('/sinhvien/taothesinhvien/{ma_sv}', [SinhVienController::class, 'taoTheSinhVien'])->name('sinhvien.taothesinhvien');
        Route::get('/sinhvien/getInactiveData', [SinhVienController::class, 'getInactiveData'])->name('sinhvien.getInactiveData');
        Route::get('/sinhvien/restore/{id}', [SinhVienController::class, 'restore'])->name('sinhvien.restore');
        Route::resource('sinhvien', SinhVienController::class);

        Route::get('/hopdongcamdo/taothesinhvien/{ma_sv}', [HopDongCamDoController::class, 'taoTheSinhVien'])->name('hopdongcamdo.taohoadon');
        Route::get('/hopdongcamdo/getInactiveData', [HopDongCamDoController::class, 'getInactiveData'])->name('hopdongcamdo.getInactiveData');
        Route::get('/hopdongcamdo/restore/{id}', [HopDongCamDoController::class, 'restore'])->name('hopdongcamdo.restore');
        Route::resource('hopdongcamdo', HopDongCamDoController::class);
    });
    Route::group(['middleware' => 'checkchucvu:1'], function () {
        Route::get('/giangvien/getBoMonByKhoa/{id_khoa}', [GiangVienController::class, 'getBoMonByKhoa'])->name('giangvien.getBoMonByKhoa');
        Route::get('/giangvien/getGiangVienByIdKhoa/{id_khoa}', [GiangVienController::class, 'getGiangVienByIdKhoa'])->name('giangvien.getGiangVienByIdKhoa');
        Route::get('/giangvien/getGiangVienByIdBoMon/{id_bo_mon}', [GiangVienController::class, 'getGiangVienByIdBoMon'])->name('giangvien.getGiangVienByIdBoMon');
        Route::get('/giangvien/getInactiveData', [GiangVienController::class, 'getInactiveData'])->name('giangvien.getInactiveData');
        Route::get('/giangvien/restore/{id}', [GiangVienController::class, 'restore'])->name('giangvien.restore');
        Route::resource('giangvien', GiangVienController::class);

        Route::get('/chucvugiangvien/getInactiveData', [ChucVuGiangVienController::class, 'getInactiveData'])->name('chucvugiangvien.getInactiveData');
        Route::get('/chucvugiangvien/restore/{id}', [ChucVuGiangVienController::class, 'restore'])->name('chucvugiangvien.restore');
        Route::resource('chucvugiangvien', ChucVuGiangVienController::class);
    });

    Route::resource('thongtincanhan', ThongTinCaNhanController::class);

    Route::post('/giangvien/thongTinCaNhanstore', [GiangVienController::class, 'thongTinCaNhanstore'])->name('giangvien.thongTinCaNhanstore');
    Route::get('/get-thong-tin-lop-hoc-phan', [NhapDiemController::class, 'getThongTinLopHocPhan']);
    Route::resource('nhapdiem', NhapDiemController::class);
    Route::get('/lay-tong-giang-vien', [GiangVienController::class, 'layTongGiangVien'])->name('lay-tong-giang-vien');
    Route::get('/lay-tong-khoa', [KhoaController::class, 'layTongKhoa'])->name('lay-tong-khoa');
    Route::get('/lay-tong-chuyen-nganh', [ChuyenNganhController::class, 'layTongChuyenNganh'])->name('lay-tong-chuyen-nganh');
});
Route::get('/lay-thong-tin-quan-tri-vien', [GiangVienController::class, 'layThongTinQuanTriVien'])->name('lay-thong-tin-quan-tri-vien');