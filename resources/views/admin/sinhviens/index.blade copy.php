@extends('admin.layouts.layout')
@section('content')
    <style>
        .select2-selection__rendered {
            line-height: 29px !important;
        }

        .select2-container .select2-selection--single {
            height: 38px !important;
        }

        .select2-selection__arrow {
            height: 35px !important;
        }
    </style>
    <style>
        th,
        td {
            white-space: nowrap;
            width: auto;
        }
    </style>

    <style>
        /* =========================
       LIQUID GLASS ULTRA+ (ADD-ONLY, 2s sweep)
       ========================= */

        /* Vars scoped riêng modal để không ảnh hưởng chỗ khác */
        #ajaxModelexa {
            --lg-bg: rgba(255, 255, 255, .06);
            --lg-brd: rgba(255, 255, 255, .26);
            --lg-blur: 32px;
            --lg-sat: 190%;
            --lg-accent: 168, 185, 255;
            /* r,g,b */
            --lg-edge: linear-gradient(160deg, #eaf0ff 0%, #fee9ff 48%, #defeff 100%);
            --lg-sweep-speed: 2s;
            /* ánh sáng lướt mỗi 2s */
            --lg-blob-a: 34s;
            --lg-blob-b: 38s;
        }

        /* Backdrop: blur sâu + gradient + film grain tinh */
        .modal-backdrop.show {
            backdrop-filter: blur(16px) saturate(130%);
            -webkit-backdrop-filter: blur(16px) saturate(130%);
            background:
                radial-gradient(120vmax 90vmax at 50% 0%, rgba(160, 180, 255, .12), transparent 60%),
                radial-gradient(120vmax 90vmax at 50% 100%, rgba(255, 205, 235, .10), transparent 60%),
                radial-gradient(100vmax 80vmax at 0% 100%, rgba(90, 120, 255, .08), transparent 55%),
                rgba(8, 12, 24, .74);
            background-blend-mode: screen, screen, screen, normal;
        }

        .modal-backdrop.show::after {
            content: "";
            position: fixed;
            inset: 0;
            pointer-events: none;
            mix-blend-mode: overlay;
            opacity: .06;
            background:
                repeating-linear-gradient(0deg, rgba(255, 255, 255, .016) 0 1px, transparent 1px 2px),
                repeating-linear-gradient(90deg, rgba(0, 0, 0, .016) 0 1px, transparent 1px 2px);
        }

        /* Tấm kính: thêm Fresnel vignette ở mép + bóng nhiều lớp */
        #ajaxModelexa .modal-content {
            position: relative;
            overflow: hidden;
            background: var(--lg-bg);
            border: .65px solid var(--lg-brd);
            border-radius: 22px;
            backdrop-filter: blur(var(--lg-blur)) saturate(var(--lg-sat));
            -webkit-backdrop-filter: blur(var(--lg-blur)) saturate(var(--lg-sat));
            box-shadow:
                0 32px 96px rgba(0, 0, 0, .52),
                0 14px 32px rgba(0, 0, 0, .30),
                inset 0 0 0.6px rgba(255, 255, 255, .48),
                inset 0 0 30px rgba(255, 255, 255, .04);
            /* Fresnel glow nhẹ bên trong */
            /* micro-contrast để kính nổi khối hơn */
            outline: 1px solid rgba(255, 255, 255, .04);
            outline-offset: -1px;
            will-change: transform;
        }

        /* Viền quang học 2 tầng (dispersion edge) */
        #ajaxModelexa .modal-content::before {
            content: "";
            position: absolute;
            inset: 0;
            border-radius: 22px;
            padding: 1px;
            background:
                var(--lg-edge),
                radial-gradient(140% 100% at 50% 0%, rgba(255, 255, 255, .16), transparent 60%);
            /* glow mép */
            background-blend-mode: screen;
            opacity: .42;
            -webkit-mask:
                linear-gradient(#000 0 0) content-box,
                linear-gradient(#000 0 0);
            -webkit-mask-composite: xor;
            mask-composite: exclude;
            pointer-events: none;
        }

        /* Sheen lướt 2s + caustics + anisotropic grain (overlay) */
        #ajaxModelexa .modal-content::after {
            content: "";
            position: absolute;
            inset: 0;
            border-radius: inherit;
            pointer-events: none;
            background:
                linear-gradient(112deg, rgba(255, 255, 255, 0) 34%, rgba(255, 255, 255, .28) 50%, rgba(255, 255, 255, 0) 66%),
                conic-gradient(from 210deg at 18% 12%, rgba(180, 210, 255, .18), transparent 40%),
                conic-gradient(from -30deg at 82% 88%, rgba(255, 200, 235, .16), transparent 45%),
                repeating-conic-gradient(from 0deg, rgba(255, 255, 255, .015) 0 8deg, transparent 8deg 16deg);
            /* “brushed” rất nhẹ */
            mix-blend-mode: soft-light;
            background-repeat: no-repeat;
            background-size: 220% 220%, 140% 140%, 120% 120%, 100% 100%;
            animation: lg-ultra-sweep var(--lg-sweep-speed) cubic-bezier(.22, .61, .36, 1) infinite;
            opacity: .98;
        }

        /* Blob nền mơ hơn, ít bão hoà để không lấn nội dung */
        #ajaxModelexa .modal-dialog {
            position: relative;
        }

        #ajaxModelexa .modal-dialog::before,
        #ajaxModelexa .modal-dialog::after {
            content: "";
            position: absolute;
            inset: auto;
            pointer-events: none;
            z-index: 0;
            width: 58vmax;
            aspect-ratio: 1/1;
            border-radius: 50%;
            filter: blur(80px) saturate(118%);
            opacity: .32;
            background:
                radial-gradient(circle at 28% 30%, #a1b8ff 0 26%, transparent 30%),
                radial-gradient(circle at 72% 60%, #bff4ff 0 22%, transparent 28%),
                radial-gradient(circle at 42% 78%, #ffd9ef 0 18%, transparent 22%);
            transform: translate3d(-38vmax, -28vmax, 0);
            animation: lg-ultra-float-a var(--lg-blob-a) ease-in-out infinite;
        }

        #ajaxModelexa .modal-dialog::after {
            width: 44vmax;
            filter: blur(66px);
            animation: lg-ultra-float-b var(--lg-blob-b) ease-in-out infinite;
            transform: translate3d(30vmax, 24vmax, 0);
        }

        /* Nội dung nổi trên blob */
        #ajaxModelexa .modal-header,
        #ajaxModelexa .modal-body,
        #ajaxModelexa .modal-footer,
        #ajaxModelexa .modal-content {
            position: relative;
            z-index: 1;
        }

        /* Inputs / Buttons: ring mượt + glow theo accent */
        #ajaxModelexa .form-control {
            background: rgba(255, 255, 255, .10);
            border: 1px solid rgba(255, 255, 255, .24);
            color: #f7f9ff;
            backdrop-filter: blur(12px) saturate(165%);
            -webkit-backdrop-filter: blur(12px) saturate(165%);
            transition: border-color .2s ease, box-shadow .25s ease, background .2s ease, transform .08s ease;
        }

        #ajaxModelexa .form-control:focus {
            background: rgba(255, 255, 255, .15);
            border-color: rgba(var(--lg-accent), .65);
            box-shadow:
                0 12px 36px rgba(var(--lg-accent), .22),
                0 0 0 3px rgba(var(--lg-accent), .32);
            transform: scale(1.01);
        }

        #ajaxModelexa .form-control::placeholder {
            color: rgba(255, 255, 255, .64);
        }

        #ajaxModelexa .btn {
            border-radius: 12px;
            backdrop-filter: blur(12px) saturate(165%);
            -webkit-backdrop-filter: blur(12px) saturate(165%);
            box-shadow: 0 12px 28px rgba(var(--lg-accent), .20);
            transition: transform .15s ease, box-shadow .25s ease, filter .25s ease;
        }

        #ajaxModelexa .btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 16px 42px rgba(var(--lg-accent), .30);
            filter: brightness(1.03);
        }

        #ajaxModelexa .btn:active {
            transform: translateY(0);
            filter: brightness(.98);
        }

        /* Typography: tiêu đề có chiều sâu hơn */
        #ajaxModelexa .modal-title {
            font-weight: 760;
            letter-spacing: .2px;
            background: linear-gradient(180deg, #ffffff, #e8eeff 60%, #c6d4ff);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            text-shadow: 0 9px 38px rgba(160, 190, 255, .30);
        }

        /* Light mode tinh chỉnh */
        @media (prefers-color-scheme: light) {
            .modal-backdrop.show {
                background:
                    radial-gradient(110vmax 80vmax at 50% 0%, rgba(195, 210, 255, .18), transparent 60%),
                    radial-gradient(110vmax 80vmax at 50% 100%, rgba(255, 215, 238, .12), transparent 60%),
                    rgba(247, 249, 255, .80);
            }

            #ajaxModelexa {
                --lg-bg: rgba(255, 255, 255, .58);
                --lg-brd: rgba(210, 220, 255, .56);
            }

            #ajaxModelexa .modal-content {
                box-shadow:
                    0 32px 96px rgba(40, 60, 100, .22),
                    inset 0 0 0.6px rgba(255, 255, 255, .68);
            }

            #ajaxModelexa .form-control {
                color: #0b1220;
                background: rgba(255, 255, 255, .74);
            }

            #ajaxModelexa .form-control::placeholder {
                color: rgba(20, 30, 50, .58);
            }
        }

        /* Reduced motion: tắt chuyển động */
        @media (prefers-reduced-motion: reduce) {

            #ajaxModelexa .modal-dialog::before,
            #ajaxModelexa .modal-dialog::after {
                animation: none;
            }

            #ajaxModelexa .modal-content::after {
                animation: none;
            }
        }

        /* Keyframes */
        @keyframes lg-ultra-float-a {
            0% {
                transform: translate3d(-38vmax, -28vmax, 0) scale(1) rotate(0);
            }

            50% {
                transform: translate3d(-28vmax, -18vmax, 0) scale(1.06) rotate(40deg);
            }

            100% {
                transform: translate3d(-38vmax, -28vmax, 0) scale(1) rotate(80deg);
            }
        }

        @keyframes lg-ultra-float-b {
            0% {
                transform: translate3d(30vmax, 24vmax, 0) scale(1) rotate(0);
            }

            50% {
                transform: translate3d(22vmax, 30vmax, 0) scale(1.05) rotate(-35deg);
            }

            100% {
                transform: translate3d(30vmax, 24vmax, 0) scale(1) rotate(-70deg);
            }
        }

        @keyframes lg-ultra-sweep {
            0% {
                background-position: -120% -80%, 0 0, 0 0, 0 0;
            }

            50% {
                background-position: 10% 20%, 0 0, 0 0, 0 0;
            }

            100% {
                background-position: 220% 120%, 0 0, 0 0, 0 0;
            }
        }

        /* Fallback nếu thiếu backdrop-filter */
        @supports not ((backdrop-filter: blur(1px)) or (-webkit-backdrop-filter: blur(1px))) {
            #ajaxModelexa .modal-content {
                background: rgba(255, 255, 255, .12);
            }
        }
    </style>
    <section>
        <div class="container">
            <ul class="nav nav-pills nav-pills-bg-soft ml-auto mb-3">
                <li class="nav-item mr-1">
                    <button id="showInactiveBtn" class="btn btn-primary" type="button" value=''>Hiển thị danh sách đã
                        xóa</button>
                </li>
                <li class="nav-item">
                    <button class="btn btn-success" type="button" id="createNewBtn">
                        <i class="fa-solid fa-circle-plus"></i> Thêm
                    </button>
                </li>
            </ul>
        </div>

        <div class="card-body">
            <table id="example1" class="table table-bordered table-striped data-table">
                <thead>
                    <tr>
                        <th width="80px">Tên Món Hàng</th>
                        <th>Mô Tả</th>
                        <th>Người Cầm</th>
                        <th>Số Điện Thoại</th>
                        <th>Số CMND</th>
                        <th>Ngày Cấp CMND</th>
                        <th>Ngày Cầm</th>
                        <th>Ngày hết hạn cầm</th>
                        <th>Lãi suất</th>
                        <th>Số tiền cầm</th>
                        <th width="72px" class="text-center"><a href="#" id="filterToggle">Bộ Lọc</a></th>
                    </tr>
                    <tr class="filter-row">
                        <th width="80px"></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th width="72px" class="text-center">
                            <div class="mb-2">
                                <a href="#" class="pb-2 reset-filter">↺</a>
                            </div>
                        </th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
                <tfoot>
                    <tr>
                        <th width="80px">Tên Món Hàng</th>
                        <th>Mô Tả</th>
                        <th>Người Cầm</th>
                        <th>Số Điện Thoại</th>
                        <th>Số CMND</th>
                        <th>Ngày Cấp CMND</th>
                        <th>Ngày Cầm</th>
                        <th>Ngày hết hạn cầm</th>
                        <th>Lãi suất</th>
                        <th>Số tiền cầm</th>
                        <th width="72px"></th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </section>

    <div class="modal fade" id="ajaxModelexa" aria-hidden="true" style="">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modelHeading"></h4>
                </div>
                <div class="modal-body">

                    <form id="modalForm" name="modalForm" class="form-horizontal" enctype="multipart/form-data">
                        <div class="card-body">

                            <div class="row">
                                <div class="col-md-4">

                                    <div class="form-group">
                                        <label for="ten_mon_hang">Tên Món Hàng</label>
                                        <input type="text" class="form-control" id="ten_mon_hang" name="ten_mon_hang"
                                            placeholder="Tên Món Hàng" value="" required>
                                        <div class="invalid-feedback">
                                            Vui lòng nhập tên món hàng.
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="so_cmnd">Số CMND</label>
                                        <input type="text" class="form-control" id="so_cmnd" name="so_cmnd"
                                            placeholder="Số CMND" value="" required pattern="\d{9}|\d{12}">
                                        <div class="invalid-feedback">
                                            Vui lòng nhập số chứng minh thư 9 số(CMND) hoặc 12 số (CCCD).
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="Ngay_cap_cmnd">Ngày Cấp CMND</label>
                                        <input type="text" class="form-control" id="Ngay_cap_cmnd" name="Ngay_cap_cmnd"
                                            placeholder="Ngày Cấp CMND" value="" required pattern="\d{2}/\d{2}/\d{4}">
                                        <div class="invalid-feedback">
                                            Vui lòng nhập ngày cấp CMND hợp lệ.
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="so_dien_thoai">Số Điện Thoại</label>
                                        <input type="text" class="form-control" id="so_dien_thoai" name="so_dien_thoai"
                                            placeholder="Số Điện Thoại" value="" required pattern="^(0|\+84)?([3-9]\d{8})$">
                                        <div class="invalid-feedback">
                                            Vui lòng nhập số điện thoại hợp lệ.
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="nguoi_cam">Tên Người Cầm</label>
                                        <input type="text" class="form-control" id="nguoi_cam" name="nguoi_cam"
                                            placeholder="Người Cầm" value="" required>
                                        <div class="invalid-feedback">
                                            Vui lòng nhập tên người cầm.
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="ngay_cam">Ngày Cầm Món Hàng</label>
                                        <input type="text" class="form-control" id="ngay_cam" name="ngay_cam"
                                            placeholder="Ngày Cầm Món Hàng" value="" required>
                                        <div class="invalid-feedback">
                                            Vui lòng nhập ngày cầm hợp lệ.
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="Lai_suat">Lãi suất</label>
                                        <input type="text" class="form-control" id="Lai_suat" name="Lai_suat"
                                            placeholder="Lãi suất" value="" required>
                                        <div class="invalid-feedback">
                                            Vui lòng nhập lãi suất hợp lệ.
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="So_tien_cam">Số tiền cầm</label>
                                        <input type="text" class="form-control" id="So_tien_cam" name="So_tien_cam"
                                            placeholder="Số tiền cầm" value="" required>
                                        <div class="invalid-feedback">
                                            Vui lòng nhập số tiền cầm hợp lệ.
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="ngay_het_han_cam">Ngày hết hạn cầm</label>
                                        <input type="text" class="form-control" id="ngay_het_han_cam"
                                            name="ngay_het_han_cam" placeholder="Ngày hết hạn cầm" value="" required>
                                        <div class="invalid-feedback">
                                            Vui lòng nhập ngày hết hạn cầm hợp lệ.
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary" id="savedata" value="create"><i
                                        class="fa-regular fa-floppy-disk"></i> Lưu</button>
                                <button type="button" class="btn btn-danger" data-dismiss="modal"><i
                                        class="fa-solid fa-xmark"></i> Hủy</button>
                            </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="themSinhVienExcelModal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modelHeading">Thêm Sinh Viên Bằng File Excel</h4>
                </div>
                <div class="modal-body">
                    <form id="sinhVienExcelForm" name="sinhVienExcelForm" class="form-horizontal"
                        enctype="multipart/form-data">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="id_lop_hoc_excel">Lớp Học</label>
                                <select name="id_lop_hoc_excel" id="id_lop_hoc_excel" class="form-control select2"
                                    style="width: 100%;">
                                    <option value="">-- Chọn lớp --</option>
                                    @foreach ($lophocs as $lophoc)
                                        @if ($lophoc->trang_thai == 1)
                                            <option value="{{ $lophoc->id}}">{{ $lophoc->ten_lop_hoc }}
                                            </option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="customFile" name="fileExcel">
                                <label class="custom-file-label" for="customFile"></label>
                            </div>
                            <!-- <input type="file" name="fileExcel" class="form-control"> -->
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary" id="themSinhVienExcelSubmit">Xác Nhận</button>
                            <a id="taiMauExcelBtn" class="btn btn-info" href="{{ asset('file/mau_excel.xlsx') }}">Tải Mẫu
                                Excel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </body>
    <script src="{{ asset('plugins/jquery/jquery.js') }}"></script>
    <script type="text/javascript">
        $(function () {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var table = $('.data-table').DataTable({
                processing: true,
                serverSide: true,
                scrollX: true,
                orderCellsTop: true,
                initComplete: function () {
                    var table = this;
                    table.api().columns().every(function () {
                        var column = this;
                        if (column.index() !== 20) {
                            var select = $(
                                '<select class="form-control select2"><option value="">--</option></select>'
                            ).appendTo($(table.api().table().container()).find(
                                '.filter-row th:eq(' + column.index() + ')'))
                                .on('change', function () {
                                    var val = $.fn.dataTable.util.escapeRegex($(this).val());
                                    column.search(val ? '^' + val + '$' : '', true, false)
                                        .draw();
                                });
                            column.data().unique().sort().each(function (d, j) {
                                select.append('<option value="' + d + '">' + d +
                                    '</option>');
                            });
                            // $(".filter-row").toggle();
                            select.select2();
                            // select.select2({
                            //     width: 'auto',
                            //     dropdownAutoWidth: true
                            // });
                        }
                    });
                    table.api().columns([2, 3, 4, 5, 7, 8, 9, 10, 11, 13, 14, 16, 17]).visible(
                        false);
                },
                ajax: "{{ route('sinhvien.index') }}",
                columnDefs: [{
                    "targets": 12,
                    "className": 'dt-body-center'
                }],
                columns: [{
                    data: 'ma_sv',
                    name: 'ma_sv',
                    render: function (data, type, full, meta) {
                        var btn = '<a href="javascript:void(0)" data-toggle="tooltip" data-id="' +
                            data + '" data-original-title="Edit" class="editBtn">' + data +
                            '</a>';
                        return btn;
                    }
                },
                {
                    data: 'ten_sinh_vien',
                    name: 'ten_sinh_vien'
                },
                {
                    data: 'email',
                    name: 'email'
                },
                {
                    data: 'so_dien_thoai',
                    name: 'so_dien_thoai'
                },
                {
                    data: 'so_cmt',
                    name: 'so_cmt'
                },
                {
                    data: 'gioi_tinh',
                    name: 'gioi_tinh',
                    render: function (data, type, full, meta) {
                        if (data == 1) {
                            return 'Nam';
                        } else {
                            return 'Nữ';
                        }
                    }
                },
                {
                    data: 'ngay_sinh',
                    name: 'ngay_sinh',
                    render: function (data, type, full, meta) {
                        if (type === 'display' && data !== null) {
                            var date = new Date(data);
                            var formattedDate = date.getDate() + '/' + (date.getMonth() + 1) + '/' +
                                date.getFullYear();
                            return formattedDate;
                        }
                        return data;
                    }
                },
                {
                    data: 'noi_sinh',
                    name: 'noi_sinh'
                },
                {
                    data: 'dan_toc',
                    name: 'dan_toc',

                },
                {
                    data: 'ton_giao',
                    name: 'ton_giao'

                },
                {
                    data: 'dia_chi_thuong_tru',
                    name: 'dia_chi_thuong_tru'
                },
                {
                    data: 'dia_chi_tam_tru',
                    name: 'dia_chi_tam_tru'
                },
                {
                    data: 'hinh_anh_dai_dien',
                    name: 'hinh_anh_dai_dien',
                    render: function (data, type, full, meta) {
                        if (data) {
                            return '<img src="{{ asset("sinhvien_img") }}/' + data +
                                '" width="100" height="100">';
                        } else {
                            return '';
                        }
                    }
                },
                {
                    data: 'tai_khoan',
                    name: 'tai_khoan',
                },
                {
                    data: 'mat_khau',
                    name: 'mat_khau',
                    render: function (data, type, full, meta) {
                        return '******';
                    }
                },
                {
                    data: 'khoa_hoc',
                    name: 'khoa_hoc'
                },
                {
                    data: 'bac_dao_tao',
                    name: 'bac_dao_tao'
                },
                {
                    data: 'he_dao_tao',
                    name: 'he_dao_tao'
                },
                {
                    data: 'ten_lop_hoc',
                    name: 'ten_lop_hoc'
                },
                {
                    data: 'tinh_trang_hoc',
                    name: 'tinh_trang_hoc'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                },
                ],
                language: {
                    "sEmptyTable": "Không có dữ liệu",
                    "sInfo": "Hiển thị _START_ đến _END_ của _TOTAL_ bản ghi",
                    "sInfoEmpty": "Hiển thị 0 đến 0 của 0 bản ghi",
                    "sInfoFiltered": "(được lọc từ _MAX_ tổng số bản ghi)",
                    "sInfoPostFix": "",
                    "sInfoThousands": ",",
                    "sLengthMenu": "Hiển thị _MENU_ bản ghi",
                    "sLoadingRecords": "Đang tải...",
                    "sProcessing": "Đang xử lý...",
                    "sSearch": "Tìm kiếm:",
                    "sZeroRecords": "Không tìm thấy kết quả nào phù hợp",
                    "oPaginate": {
                        "sFirst": "Đầu",
                        "sLast": "Cuối",
                        "sNext": "Tiếp",
                        "sPrevious": "Trước"
                    },
                    "oAria": {
                        "sSortAscending": ": Sắp xếp tăng dần",
                        "sSortDescending": ": Sắp xếp giảm dần"
                    }
                },
                dom: 'Bfrtip',
                buttons: [{
                    extend: 'copy',
                    text: 'Sao chép'
                },
                {
                    extend: 'excel',
                    text: 'Xuất Excel',
                    sheetName: 'Sinh Viên',
                    title: 'Sinh Viên',
                    exportOptions: {
                        modifier: {
                            page: 'current'
                        }
                    }
                },
                {
                    extend: 'pdf',
                    text: 'Xuất PDF'
                },
                {
                    extend: 'print',
                    text: 'In'
                },
                {
                    extend: 'colvis',
                    text: 'Hiển thị cột'
                },
                {
                    extend: 'pageLength',
                    text: 'Số bản ghi trên trang'
                }
                ],
                lengthMenu: [
                    [10, 25, 50, -1],
                    [10, 25, 50, 'Tất cả']
                ]
            });
            $("#filterToggle").on("click", function () {
                $(".filter-row").toggle();
                $(".table-cell").css("width", "");
                table.columns.adjust().draw();
            });
            $(".filter-row").toggle();
            $('.reset-filter').on('click', function (e) {
                e.preventDefault();
                var selects = $('.filter-row select');
                selects.val('').trigger('change');
            });
            $('#ma_sv').on('input', function () {
                var ma_sv = $(this).val();
                var email = ma_sv + '@caothang.edu.vn';
                $('#tai_khoan').val(ma_sv);
                $('#email').val(email);
            });
            $('#so_cmt').on('input', function () {
                var so_cmt = $(this).val();
                $('#mat_khau').val(so_cmt);
            });
            $('#taoBangTenBtn').click(function () {
                var tenSinhVien = $('#ten_sinh_vien').val();
                var maSinhVien = $('#ma_sv').val();
                var lop = $('#id_lop_hoc option:selected').text();
                $.ajax({
                    url: "{{ route('sinhvien.index') }}" + '/taobangten/' + tenSinhVien +
                        '/' +
                        lop,
                    type: 'GET',
                    dataType: 'json',
                    success: function (response) {
                        var downloadLink = response;
                        var link = document.createElement('a');
                        link.href = downloadLink;
                        link.download = maSinhVien + '.jpg';
                        document.body.appendChild(link);
                        link.click();
                        document.body.removeChild(link);
                    },
                    error: function (xhr, status, error) {
                        Swal.fire({
                            title: 'Không đủ thông tin để tạo thẻ',
                            confirmButtonText: 'Ok',
                        }).then((result) => {
                            if (result.isConfirmed) { }
                        })
                    }
                });
            });
            $('#taoTheSinhVienBtn').click(function () {
                var maSinhVien = $('#ma_sv').val();
                $.ajax({
                    url: "{{ route('sinhvien.index') }}" + '/taothesinhvien/' + maSinhVien,
                    type: 'GET',
                    dataType: 'json',
                    success: function (response) {
                        var downloadLink = response;
                        var link = document.createElement('a');
                        link.href = downloadLink;
                        link.download = maSinhVien + '.jpg';
                        document.body.appendChild(link);
                        link.click();
                        document.body.removeChild(link);
                    },
                    error: function (xhr, status, error) {
                        Swal.fire({
                            title: 'Không đủ thông tin để tạo thẻ',
                            confirmButtonText: 'Ok',
                        }).then((result) => {
                            if (result.isConfirmed) {

                            }
                        })
                    }
                });
            });
            $('#showInactiveBtn').click(function () {
                var button = $(this);
                var buttonVal = button.val();
                if (buttonVal == '') {
                    $("#showInactiveBtn").val('1');
                    button.text('Hiển thị danh sách chính');
                    table.ajax.url("{{ route('sinhvien.getInactiveData') }}").load();
                } else {
                    $("#showInactiveBtn").val('');
                    button.text('Hiển thị danh sách đã xóa');
                    table.ajax.url("{{ route('sinhvien.index') }}").load();
                }
            });
            $('#createNewBtn').click(function () {
                $('#modalForm').removeClass('was-validated');
                $('#savedata').val("create-Btn");
                $('#ma_sv').removeAttr('readonly');
                $('#modalForm').trigger("reset");
                $('#modelHeading').html("Thêm ");
                $('#ajaxModelexa').modal('show');
                // Đặt giá trị của input ẩn về null
                $('#hinh_anh_dai_dien_hidden').val('');
                // Đặt giá trị của thẻ <img> về đường dẫn mặc định
                $('#hinh_anh_dai_dien_preview').attr('src', '{{ asset("img/warning.jpg") }}');
                $('#hinh_anh_dai_dien_preview').attr('alt', 'Warning');
                $('#gioi_tinh').val('').trigger('change');
                $('#bac_dao_tao').val('').trigger('change');
                $('#he_dao_tao').val('').trigger('change');
                $('#id_lop_hoc').val('').trigger('change');
                $('#tinh_trang_hoc').val('').trigger('change');
                $("#taoBangTenBtn").hide();
                $("#taoTheSinhVienBtn").hide();
            });
            $('body').on('click', '.editBtn', function () {
                $('#modalForm').removeClass('was-validated');
                $('#ma_sv').attr('readonly', 'readonly');
                $("#taoBangTenBtn").show();
                $("#taoTheSinhVienBtn").show();
                var id = $(this).data('id');
                $.get("{{ route('sinhvien.index') }}" + '/' + id + '/edit', function (data) {
                    $('#modelHeading').html("Sửa");
                    $('#savedata').val("edit-Btn");
                    $('#ajaxModelexa').modal('show');
                    $('#ma_sv').val(data.ma_sv);
                    $('#ten_sinh_vien').val(data.ten_sinh_vien);
                    $('#email').val(data.email);
                    $('#so_dien_thoai').val(data.so_dien_thoai);
                    $('#so_cmt').val(data.so_cmt);
                    $('#gioi_tinh').val(data.gioi_tinh).trigger('change');
                    $('#ngay_sinh').val(data.ngay_sinh);
                    $('#noi_sinh').val(data.noi_sinh);
                    $('#dan_toc').val(data.dan_toc);
                    $('#ton_giao').val(data.ton_giao);
                    $('#dia_chi_thuong_tru').val(data.dia_chi_thuong_tru);
                    $('#dia_chi_tam_tru').val(data.dia_chi_tam_tru);
                    if (data.hinh_anh_dai_dien) {
                        var imageSrc = '{{ asset("sinhvien_img") }}/' + data.hinh_anh_dai_dien;
                        $('#hinh_anh_dai_dien_preview').attr('src', imageSrc);
                        $('#hinh_anh_dai_dien_preview').attr('alt', 'Hình ảnh');
                        $('#hinh_anh_dai_dien_hidden').val(data.hinh_anh_dai_dien);
                    } else {
                        $('#hinh_anh_dai_dien_preview').attr('src', '{{ asset("img/warning.jpg") }}');
                        $('#hinh_anh_dai_dien_preview').attr('alt', 'Warning');
                        $('#hinh_anh_dai_dien_hidden').val('');
                    }
                    $('#tai_khoan').val(data.tai_khoan);
                    // $('#mat_khau').val(data.mat_khau);
                    $('#mat_khau').attr('placeholder', '*********');
                    $('#khoa_hoc').val(data.khoa_hoc);
                    $('#bac_dao_tao').val(data.bac_dao_tao).trigger('change');
                    $('#he_dao_tao').val(data.he_dao_tao).trigger('change');
                    $('#id_lop_hoc').val(data.id_lop_hoc).trigger('change');
                    $('#tinh_trang_hoc').val(data.tinh_trang_hoc).trigger('change');

                })
            });
            $('#hinh_anh_dai_dien').change(function (event) {
                var input = event.target;
                if (input.files && input.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        $('#hinh_anh_dai_dien_preview').attr('src', e.target.result);
                        $('#hinh_anh_dai_dien_hidden').val($('#ma_sv').val());
                    };
                    reader.readAsDataURL(input.files[0]);
                }
            });
            $('#savedata').click(function (e) {
                e.preventDefault();
                if ($('#modalForm')[0].checkValidity()) {
                    $(this).html('Đang gửi ...');
                    var formData = new FormData($('#modalForm')[0]);
                    $.ajax({
                        data: formData,
                        url: "{{ route('sinhvien.store') }}",
                        type: "POST",
                        dataType: 'json',
                        processData: false,
                        contentType: false,
                        success: function (data) {
                            $('#modalForm').trigger("reset");
                            $('#ajaxModelexa').modal('hide');
                            $('#savedata').html('Lưu');
                            Swal.fire({
                                toast: true,
                                position: 'top-end',
                                timerProgressBar: true,
                                icon: 'success',
                                title: 'Thành Công',
                                showConfirmButton: false,
                                timer: 1500
                            })
                            table.draw();
                        },
                        error: function (data) {
                            table.draw();
                            console.log('Error:', data);
                            $('#savedata').html('Lưu');
                        }
                    });
                } else {
                    $('#modalForm').addClass('was-validated');
                }
            });

            $('body').on('click', '.deleteBtn', function () {
                var id = $(this).data("id");
                Swal.fire({
                    title: 'Bạn Có Muốn Xóa',
                    text: "",
                    icon: 'warning',
                    showCancelButton: true,
                    cancelButtonText: 'Hủy',
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Xác Nhận'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: "DELETE",
                            url: "{{ route('sinhvien.destroy', '') }}/" + id,
                            success: function (data) {
                                Swal.fire({
                                    toast: true,
                                    position: 'top-end',
                                    icon: 'success',
                                    title: 'Xóa Thành Công',
                                    showConfirmButton: false,
                                    timer: 1000
                                })
                                table.draw();
                            },
                            error: function (data) {
                                console.log('Error:', data);
                            }
                        });
                    }
                })
            });
            $('body').on('click', '.restoreBtn', function () {
                var id = $(this).data("id");
                Swal.fire({
                    title: 'Bạn Có Muốn Khôi Phục',
                    text: "",
                    icon: 'warning',
                    showCancelButton: true,
                    cancelButtonText: 'Hủy',
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Xác Nhận'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: "GET",
                            url: "{{ route('sinhvien.restore', '') }}/" + id,
                            success: function (data) {
                                Swal.fire({
                                    toast: true,
                                    position: 'top-end',
                                    icon: 'success',
                                    title: 'Khôi Phục Thành Công',
                                    showConfirmButton: false,
                                    timer: 1000
                                })
                                table.draw();
                            },
                            error: function (data) {
                                console.log('Error:', data);
                            }
                        });
                    }
                })
            });
        });
    </script>
@endsection