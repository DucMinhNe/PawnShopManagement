<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hop_dong_cam_dos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('ten_mon_hang');
            $table->string('hinh_anh_mon_hang')->nullable();
            $table->text('mo_ta')->nullable();
            $table->string('nguoi_cam');
            $table->string('so_dien_thoai')->nullable();
            $table->string('so_cmnd')->nullable();
            $table->date('ngay_cam');
            $table->date('ngay_het_han_cam')->nullable();
            $table->integer('so_ngay_cam')->nullable();
            $table->decimal('lai_suat', 5, 2)->nullable();
            $table->decimal('so_tien_cam', 15, 2);
            $table->decimal('so_tien_lai', 15, 2)->nullable();
            $table->boolean('trang_thai')->nullable()->default(true);
            $table->string('trang_thai_hop_dong')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sinh_viens');
    }
};
