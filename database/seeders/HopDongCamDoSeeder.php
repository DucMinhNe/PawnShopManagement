<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HopDongCamDoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('hop_dong_cam_dos')->insert([
            // [
            //     'ten_mon_hang' => 'Nhẫn vàng',
            //     'hinh_anh_mon_hang' => null,
            //     'mo_ta' => 'Nhẫn vàng 18k, trọng lượng 5 chỉ',
            //     'nguoi_cam' => 'Nguyễn Văn A',
            //     'so_dien_thoai' => '0906123456',
            //     'so_cmnd' => '123456789',
            //     'ngay_cam' => '2024-01-15',
            //     'ngay_het_han_cam' => '2024-04-15',
            //     'lai_suat' => 3.00,
            //     'so_tien_cam' => 50000000.00,
            //     'so_tien_lai' => 1500000.00,
            //     'trang_thai' => true,
            //     'trang_thai_hop_dong' => 'DANG_CAM',
            // ],
        ]);
    }
}
