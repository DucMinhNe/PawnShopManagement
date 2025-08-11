<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HopDongCamDo extends Model
{
    use HasFactory;
    protected $table = 'hop_dong_cam_dos';
    protected $fillable = [
        'ten_mon_hang',
        'hinh_anh_mon_hang',
        'mo_ta',
        'nguoi_cam',
        'so_dien_thoai',
        'so_cmnd',
        'ngay_cap_cmnd',
        'ngay_cam',
        'lai_suat',
        'so_tien_cam',
        'trang_thai',
        'trang_thai_hop_dong'
    ];
}   
