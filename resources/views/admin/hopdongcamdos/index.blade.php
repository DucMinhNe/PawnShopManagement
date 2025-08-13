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
                        <th width="80px">ID</th>
                        <th>Tên Món Hàng</th>
                        <th>Hình Ảnh Món Hàng</th>
                        <th>Mô Tả</th>
                        <th>Người Cầm</th>
                        <th>Số Điện Thoại</th>
                        <th>Số CMND</th>
                        <th>Ngày Cầm</th>
                        <th>Ngày Hết Hạn Cầm</th>
                        <th>Số Ngày Cầm</th>
                        <th>Lãi Suất (%)</th>
                        <th>Số Tiền Cầm</th>
                        <th>Tiền Lãi</th>
                        <th>Trạng Thái Hợp Đồng</th>
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
                        <th width="72px" class="text-center">
                            <div class="mb-2"><a href="#" class="pb-2 reset-filter">↺</a></div>
                        </th>
                    </tr>
                </thead>
                </th>
                <tbody></tbody>
            </table>
        </div>
    </section>

    <div class="modal fade" id="ajaxModelexa" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modelHeading"></h4>
                </div>
                <div class="modal-body">
                    <form id="modalForm" name="modalForm" class="form-horizontal" enctype="multipart/form-data">
                        <div class="card-body">

                            <input type="hidden" id="id" name="id">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="ten_mon_hang">Tên Món Hàng</label>
                                        <input type="text" class="form-control" id="ten_mon_hang" name="ten_mon_hang"
                                            placeholder="Ví dụ: iPhone 13, Vàng 24K..." required>
                                        <div class="invalid-feedback">Vui lòng nhập tên món hàng.</div>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="hinh_anh_mon_hang">Hình Ảnh Món Hàng</label>
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="hinh_anh_mon_hang"
                                                name="hinh_anh_mon_hang" accept=".jpg,.jpeg,.png">
                                            <label class="custom-file-label" for="hinh_anh_mon_hang"></label>
                                        </div>
                                        <input type="hidden" id="hinh_anh_mon_hang_hidden" name="hinh_anh_mon_hang_hidden"
                                            value="">
                                    </div>
                                </div>

                                <div class="col-md-4 text-center">
                                    <div class="form-group">
                                        <img id="hinh_anh_mon_hang_preview" width="100" height="100" alt="" />
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="mo_ta">Mô Tả</label>
                                        <textarea class="form-control" id="mo_ta" name="mo_ta" rows="2"
                                            placeholder="Mô tả tình trạng, phụ kiện đi kèm..."></textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="nguoi_cam">Người Cầm</label>
                                        <input type="text" class="form-control" id="nguoi_cam" name="nguoi_cam"
                                            placeholder="Họ và tên" required>
                                        <div class="invalid-feedback">Vui lòng nhập tên người cầm.</div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="so_dien_thoai">Số Điện Thoại</label>
                                        <input type="text" class="form-control" id="so_dien_thoai" name="so_dien_thoai"
                                            placeholder="VD: 09xxxxxxxx" required pattern="^(0|\+84)?([3-9]\d{8})$">
                                        <div class="invalid-feedback">Vui lòng nhập số điện thoại hợp lệ.</div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="so_cmnd">Số CMND/CCCD</label>
                                        <input type="text" class="form-control" id="so_cmnd" name="so_cmnd"
                                            placeholder="9 số (CMND) hoặc 12 số (CCCD)" required pattern="\d{9}|\d{12}">
                                        <div class="invalid-feedback">Vui lòng nhập CMND 9 số hoặc CCCD 12 số.</div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="ngay_cam">Ngày Cầm</label>
                                        <input type="date" class="form-control" id="ngay_cam" name="ngay_cam" required>
                                        <div class="invalid-feedback">Vui lòng chọn ngày cầm.</div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="ngay_het_han_cam">Ngày Hết Hạn Cầm</label>
                                        <input type="date" class="form-control" id="ngay_het_han_cam"
                                            name="ngay_het_han_cam" required>
                                        <div class="invalid-feedback">Vui lòng chọn ngày hết hạn.</div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="so_ngay_cam">Số Ngày Cầm</label>
                                        <input type="number" class="form-control" id="so_ngay_cam" name="so_ngay_cam"
                                            value="">
                                        <div class="invalid-feedback">Vui lòng chọn ngày cấp.</div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="so_tien_cam_display">Số Tiền Cầm</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="so_tien_cam_display"
                                                placeholder="VD: 5.000.000" inputmode="numeric" autocomplete="off" required>
                                            <div class="input-group-append">
                                                <span class="input-group-text">₫</span>
                                            </div>
                                        </div>
                                        <!-- Giá trị số thuần gửi về server -->
                                        <input type="hidden" id="so_tien_cam" name="so_tien_cam">
                                        <div class="invalid-feedback">Vui lòng nhập số tiền cầm.</div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="lai_suat">Lãi Suất (%)</label>
                                        <input type="number" class="form-control" id="lai_suat" name="lai_suat" min="0"
                                            step="0.01" placeholder="VD: 3" required>
                                        <div class="invalid-feedback">Vui lòng nhập lãi suất hợp lệ.</div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="so_tien_lai_display">Số Tiền Lãi</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="so_tien_lai_display"
                                                placeholder="VD: 5.000.000" inputmode="numeric" autocomplete="off" required>
                                            <div class="input-group-append">
                                                <span class="input-group-text">₫</span>
                                            </div>
                                        </div>
                                        <input type="hidden" id="so_tien_lai" name="so_tien_lai">
                                        <div class="invalid-feedback">Vui lòng nhập số tiền lãi.</div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="trang_thai_hop_dong">Trạng Thái Hợp Đồng</label>
                                        <select class="form-control select2" id="trang_thai_hop_dong"
                                            name="trang_thai_hop_dong" required>
                                            <option value="">-- Chọn trạng thái --</option>
                                            <option value="DANG_CAM" selected>Đang cầm</option>
                                            <option value="DA_CHUOC">Đã chuộc</option>
                                            <option value="QUA_HAN">Quá hạn</option>
                                        </select>
                                        <div class="invalid-feedback">Vui lòng chọn trạng thái.</div>
                                    </div>
                                </div>
                                <div class="col-md-4" style="display:none">
                                    <div class="form-group">
                                        <label for="trang_thai">Trạng Thái</label>
                                        <select class="form-control select2" id="trang_thai" name="trang_thai" required>
                                            <option value="1" selected>Hoạt Động</option>
                                            <option value="0">Không Hoạt Động</option>
                                        </select>
                                        <div class="invalid-feedback">Vui lòng chọn trạng thái.</div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary" id="savedata" value="create">
                                <i class="fa-regular fa-floppy-disk"></i> Lưu
                            </button>
                            <button type="button" class="btn btn-primary" id="taoHoaDonBtn">
                                <i class="fa-regular fa-file-lines"></i> Tạo Hóa Đơn
                            </button>
                            <button type="button" class="btn btn-danger" data-dismiss="modal">
                                <i class="fa-solid fa-xmark"></i> Hủy
                            </button>
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
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
            });

            var table = $('.data-table').DataTable({
                processing: true,
                serverSide: true,
                scrollX: true,
                orderCellsTop: true,
                ajax: "{{ route('hopdongcamdo.index') }}",
                columnDefs: [{ "targets": 12, "className": 'dt-body-center' }],
                initComplete: function () {
                    var tableApi = this.api();
                    tableApi.columns().every(function () {
                        var column = this;
                        // Bỏ filter cho cột Action (index 12)
                        if (column.index() !== 12) {
                            var select = $('<select class="form-control select2"><option value="">--</option></select>')
                                .appendTo($(tableApi.table().container())
                                    .find('.filter-row th:eq(' + column.index() + ')'))
                                .on('change', function () {
                                    var val = $.fn.dataTable.util.escapeRegex($(this).val());
                                    column.search(val ? '^' + val + '$' : '', true, false).draw();
                                });
                            column.data().unique().sort().each(function (d) {
                                if (d !== null && d !== undefined && d !== '') {
                                    select.append('<option value="' + d + '">' + d + '</option>');
                                }
                            });
                            select.select2();
                        }
                    });
                },
                columns: [
                    {
                        data: 'id', name: 'id',
                        render: function (data) {
                            return '<a href="javascript:void(0)" data-toggle="tooltip" data-id="' + data + '" class="editBtn">' + data + '</a>';
                        }
                    },
                    { data: 'ten_mon_hang', name: 'ten_mon_hang' },
                    {
                        data: 'hinh_anh_mon_hang', name: 'hinh_anh_mon_hang',
                        render: function (data) {
                            return data ? '<img src="{{ asset("monhang_img") }}/' + data + '" width="100" height="100">' : '';
                        }
                    },
                    { data: 'mo_ta', name: 'mo_ta' },
                    { data: 'nguoi_cam', name: 'nguoi_cam' },
                    { data: 'so_dien_thoai', name: 'so_dien_thoai' },
                    { data: 'so_cmnd', name: 'so_cmnd' },
                    {
                        data: 'ngay_cam', name: 'ngay_cam',
                        render: function (data, type) {
                            if (type === 'display' && data) {
                                var d = new Date(data); return d.getDate() + '/' + (d.getMonth() + 1) + '/' + d.getFullYear();
                            } return data;
                        }
                    },
                    {
                        data: 'ngay_het_han_cam', name: 'ngay_het_han_cam',
                        render: function (data, type) {
                            if (type === 'display' && data) {
                                var d = new Date(data); return d.getDate() + '/' + (d.getMonth() + 1) + '/' + d.getFullYear();
                            } return data;
                        }
                    },
                    { data: 'so_ngay_cam', name: 'so_ngay_cam' },
                    { data: 'lai_suat', name: 'lai_suat' },
                    {
                        data: 'so_tien_cam', name: 'so_tien_cam',
                        render: function (data, type) {
                            if (data == null) return '';
                            const n = Number(data);
                            if (isNaN(n)) return data;
                            const str = n.toLocaleString('vi-VN');
                            return type === 'display' ? (str + ' ₫') : n;
                        }
                    },
                    {
                        data: 'so_tien_lai', name: 'so_tien_lai',
                        render: function (data, type) {
                            if (data == null) return '';
                            const n = Number(data);
                            if (isNaN(n)) return data;
                            const str = n.toLocaleString('vi-VN');
                            return type === 'display' ? (str + ' ₫') : n;
                        }
                    },
                    {
                        data: 'trang_thai_hop_dong', name: 'trang_thai_hop_dong',
                        render: function (data) {
                            switch (data) {
                                case 'DANG_CAM': return 'Đang cầm';
                                case 'DA_CHUOC': return 'Đã chuộc';
                                case 'QUA_HAN': return 'Quá hạn';
                                default: return data;
                            }
                        }
                    },
                    { data: 'action', name: 'action', orderable: false, searchable: false },
                ],
                language: {
                    "sEmptyTable": "Không có dữ liệu",
                    "sInfo": "Hiển thị _START_ đến _END_ của _TOTAL_ bản ghi",
                    "sInfoEmpty": "Hiển thị 0 đến 0 của 0 bản ghi",
                    "sInfoFiltered": "(được lọc từ _MAX_ tổng số bản ghi)",
                    "sLengthMenu": "Hiển thị _MENU_ bản ghi",
                    "sLoadingRecords": "Đang tải...",
                    "sProcessing": "Đang xử lý...",
                    "sSearch": "Tìm kiếm:",
                    "sZeroRecords": "Không tìm thấy kết quả phù hợp",
                    "oPaginate": { "sFirst": "Đầu", "sLast": "Cuối", "sNext": "Tiếp", "sPrevious": "Trước" },
                    "oAria": { "sSortAscending": ": Sắp xếp tăng dần", "sSortDescending": ": Sắp xếp giảm dần" }
                },
                dom: 'Bfrtip',
                buttons: [
                    { extend: 'copy', text: 'Sao chép' },
                    {
                        extend: 'excel', text: 'Xuất Excel', sheetName: 'Cam Do', title: 'Cam Do',
                        exportOptions: { modifier: { page: 'current' } }
                    },
                    { extend: 'pdf', text: 'Xuất PDF' },
                    { extend: 'print', text: 'In' },
                    { extend: 'colvis', text: 'Hiển thị cột' },
                    { extend: 'pageLength', text: 'Số bản ghi trên trang' }
                ],
                lengthMenu: [[10, 25, 50, -1], [10, 25, 50, 'Tất cả']]
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
            function formatVNDInput(val) {
                // lấy chỉ chữ số
                const digits = (val || '').replace(/\D/g, '');
                if (!digits) return { display: '', raw: '' };
                const n = parseInt(digits, 10);
                return { display: n.toLocaleString('vi-VN'), raw: String(n) };
            }

            $('#so_tien_cam_display').on('input', function () {
                const { display, raw } = formatVNDInput($(this).val());
                $(this).val(display);
                $('#so_tien_cam').val(raw);
            });
            $('#so_tien_lai_display').on('input', function () {
                const { display, raw } = formatVNDInput($(this).val());
                $(this).val(display);
                $('#so_tien_lai').val(raw);
            });
            // Tính toán tự động lãi suất và tiền lãi
            function tinhToanLaiSuat() {
                const soTienCam = parseFloat($('#so_tien_cam').val()) || 0;
                const laiSuat = parseFloat($('#lai_suat').val()) || 0;
                const soTienLai = parseFloat($('#so_tien_lai').val()) || 0;

                // Tính tiền lãi dựa trên số tiền cầm và lãi suất
                if (soTienCam > 0 && laiSuat > 0) {
                    const tienLaiTinhToan = soTienCam * (laiSuat / 100);
                    $('#so_tien_lai').val(tienLaiTinhToan);
                    $('#so_tien_lai_display').val(tienLaiTinhToan.toLocaleString('vi-VN'));
                }
            }

            function tinhToanLaiSuatNguoc() {
                const soTienCam = parseFloat($('#so_tien_cam').val()) || 0;
                const soTienLai = parseFloat($('#so_tien_lai').val()) || 0;

                // Tính lãi suất dựa trên số tiền cầm và tiền lãi
                if (soTienCam > 0 && soTienLai > 0) {
                    const laiSuatTinhToan = (soTienLai / soTienCam) * 100;
                    $('#lai_suat').val(laiSuatTinhToan.toFixed(2));
                }
            }

            // Khi thay đổi số tiền cầm hoặc lãi suất -> tính tiền lãi
            $('#so_tien_cam_display, #lai_suat').on('input change', function () {
                tinhToanLaiSuat();
            });

            // Khi thay đổi tiền lãi -> tính lãi suất
            $('#so_tien_lai_display').on('input change', function () {
                tinhToanLaiSuatNguoc();
            });
            // Preview & đặt tên ẩn cho ảnh
            $('#hinh_anh_mon_hang').change(function (event) {
                var input = event.target;
                if (input.files && input.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        $('#hinh_anh_mon_hang_preview').attr('src', e.target.result);
                        // có thể đặt theo tên hàng để server xử lý rename
                        $('#hinh_anh_mon_hang_hidden').val($('#ten_mon_hang').val());
                    };
                    reader.readAsDataURL(input.files[0]);
                }
            });

            // Nút tạo hóa đơn
            $('#taoHoaDonBtn').click(function () {
                var id = $('#id').val();
                if (!id) {
                    Swal.fire({ title: 'Vui lòng lưu món hàng trước khi tạo hóa đơn', icon: 'warning', confirmButtonText: 'Ok' });
                    return;
                }
                $.ajax({
                    // Tạo route: Route::get('/hopdongcamdo/hoadon/{id}', ...)->name('hoadon.tao');
                    url: "{{ route('hopdongcamdo.index') }}" + '/taohoadon/' + id,
                    type: 'GET',
                    dataType: 'json',
                    success: function (response) {
                        var downloadLink = response.url || response;
                        var link = document.createElement('a');
                        link.href = downloadLink;
                        link.download = 'hoadon_' + id + '.pdf';
                        document.body.appendChild(link);
                        link.click();
                        document.body.removeChild(link);
                    },
                    error: function () {
                        Swal.fire({ title: 'Không đủ thông tin để tạo hóa đơn', confirmButtonText: 'Ok' });
                    }
                });
            });

            // Hiển thị danh sách đã xóa / chính
            $('#showInactiveBtn').click(function () {
                var button = $(this);
                var val = button.val();
                if (val === '') {
                    button.val('1').text('Hiển thị danh sách chính');
                    table.ajax.url("{{ route('hopdongcamdo.getInactiveData') }}").load();
                } else {
                    button.val('').text('Hiển thị danh sách đã xóa');
                    table.ajax.url("{{ route('hopdongcamdo.index') }}").load();
                }
            });

            // Thêm mới
            $('#createNewBtn').click(function () {
                $('#modalForm').removeClass('was-validated');
                $('#modalForm').trigger("reset");
                $('#id').val('');
                $('#modelHeading').html("Thêm Món Hàng");
                $('#ajaxModelexa').modal('show');
                $('#hinh_anh_mon_hang_hidden').val('');
                $('#hinh_anh_mon_hang_preview').attr('src', '{{ asset("img/warning.jpg") }}').attr('alt', 'Warning');
                $('#so_tien_cam_display').val('');
                $('#so_tien_lai_display').val('');
                $('#so_tien_cam').val('');
                $('#so_tien_lai').val('');
                // $('#trang_thai').val('').trigger('change');
            });

            // Sửa
            $('body').on('click', '.editBtn', function () {
                $('#modalForm').removeClass('was-validated');
                var id = $(this).data('id');
                $.get("{{ route('hopdongcamdo.index') }}" + '/' + id + '/edit', function (data) {
                    $('#modelHeading').html("Sửa Món Hàng");
                    $('#ajaxModelexa').modal('show');

                    $('#id').val(data.id);
                    $('#ten_mon_hang').val(data.ten_mon_hang);
                    $('#mo_ta').val(data.mo_ta);
                    $('#nguoi_cam').val(data.nguoi_cam);
                    $('#so_dien_thoai').val(data.so_dien_thoai);
                    $('#so_cmnd').val(data.so_cmnd);
                    $('#ngay_cap_cmnd').val(data.ngay_cap_cmnd);
                    $('#ngay_cam').val(data.ngay_cam);
                    $('#lai_suat').val(data.lai_suat);
                    $('#so_tien_cam').val(data.so_tien_cam);
                    $('#so_tien_cam_display').val(
                        Number(data.so_tien_cam || 0).toLocaleString('vi-VN')
                    );
                    $('#so_tien_lai_display').val(
                        Number(data.so_tien_lai || 0).toLocaleString('vi-VN')
                    );
                    $('#ngay_het_han_cam').val(data.ngay_het_han_cam);
                    $('#so_ngay_cam').val(data.so_ngay_cam);
                    $('#so_tien_lai').val(data.so_tien_lai);
                    $('#trang_thai_hop_dong').val(data.trang_thai_hop_dong).trigger('change');
                    $('#trang_thai').val(data.trang_thai).trigger('change');

                    if (data.hinh_anh_mon_hang) {
                        var img = '{{ asset("monhang_img") }}/' + data.hinh_anh_mon_hang;
                        $('#hinh_anh_mon_hang_preview').attr('src', img).attr('alt', 'Hình ảnh');
                        $('#hinh_anh_mon_hang_hidden').val(data.hinh_anh_mon_hang);
                    } else {
                        $('#hinh_anh_mon_hang_preview').attr('src', '{{ asset("img/warning.jpg") }}').attr('alt', 'Warning');
                        $('#hinh_anh_mon_hang_hidden').val('');
                    }
                });
            });

            // Lưu
            $('#savedata').click(function (e) {
                e.preventDefault();
                if ($('#modalForm')[0].checkValidity()) {
                    const syncedCam = formatVNDInput($('#so_tien_cam_display').val());
                    $('#so_tien_cam').val(syncedCam.raw);
                    const syncedLai = formatVNDInput($('#so_tien_lai_display').val());
                    $('#so_tien_lai').val(syncedLai.raw);
                    $(this).html('Đang gửi ...');
                    var formData = new FormData($('#modalForm')[0]);
                    $.ajax({
                        data: formData,
                        url: "{{ route('hopdongcamdo.store') }}",
                        type: "POST",
                        dataType: 'json',
                        processData: false,
                        contentType: false,
                        success: function () {
                            $('#modalForm').trigger("reset");
                            $('#ajaxModelexa').modal('hide');
                            $('#savedata').html('Lưu');
                            Swal.fire({
                                toast: true, position: 'top-end', timerProgressBar: true,
                                icon: 'success', title: 'Thành Công', showConfirmButton: false, timer: 1500
                            });
                            table.draw();
                        },
                        error: function (data) {
                            console.log('Error:', data);
                            $('#savedata').html('Lưu');
                            table.draw();
                        }
                    });
                } else {
                    $('#modalForm').addClass('was-validated');
                }
            });

            // Xóa
            $('body').on('click', '.deleteBtn', function () {
                var id = $(this).data("id");
                Swal.fire({
                    title: 'Bạn Có Muốn Xóa', icon: 'warning', showCancelButton: true,
                    cancelButtonText: 'Hủy', confirmButtonColor: '#3085d6', cancelButtonColor: '#d33', confirmButtonText: 'Xác Nhận'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: "DELETE",
                            url: "{{ route('hopdongcamdo.destroy', '') }}/" + id,
                            success: function () {
                                Swal.fire({ toast: true, position: 'top-end', icon: 'success', title: 'Xóa Thành Công', showConfirmButton: false, timer: 1000 });
                                table.draw();
                            },
                            error: function (data) { console.log('Error:', data); }
                        });
                    }
                });
            });

            // Khôi phục
            $('body').on('click', '.restoreBtn', function () {
                var id = $(this).data("id");
                Swal.fire({
                    title: 'Bạn Có Muốn Khôi Phục', icon: 'warning', showCancelButton: true,
                    cancelButtonText: 'Hủy', confirmButtonColor: '#3085d6', cancelButtonColor: '#d33', confirmButtonText: 'Xác Nhận'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: "GET",
                            url: "{{ route('hopdongcamdo.restore', '') }}/" + id,
                            success: function () {
                                Swal.fire({ toast: true, position: 'top-end', icon: 'success', title: 'Khôi Phục Thành Công', showConfirmButton: false, timer: 1000 });
                                table.draw();
                            },
                            error: function (data) { console.log('Error:', data); }
                        });
                    }
                });
            });
        });
    </script>

    <script>
        $(function () {
            const $ngayCam = $('#ngay_cam');
            const $ngayHetHan = $('#ngay_het_han_cam');
            const $soNgayCam = $('#so_ngay_cam'); // CHO PHÉP NHẬP (không disabled)

            const ONE_DAY = 86400000;

            function toUTC(dateStr) {
                if (!dateStr) return null;
                const [y, m, d] = dateStr.split('-').map(Number);
                return Date.UTC(y, m - 1, d);
            }
            function fromUTCtoYmd(utcMs) {
                const dt = new Date(utcMs);
                const y = dt.getUTCFullYear();
                const m = String(dt.getUTCMonth() + 1).padStart(2, '0');
                const d = String(dt.getUTCDate()).padStart(2, '0');
                return `${y}-${m}-${d}`;
            }
            function addDays(ymd, days) {
                const utc = toUTC(ymd);
                if (utc == null) return '';
                return fromUTCtoYmd(utc + days * ONE_DAY);
            }
            function todayYmd() {
                const t = new Date();
                const y = t.getFullYear();
                const m = String(t.getMonth() + 1).padStart(2, '0');
                const d = String(t.getDate()).padStart(2, '0');
                return `${y}-${m}-${d}`;
            }

            // Cập nhật số ngày khi sửa 2 ô ngày (giữ nguyên logic cũ)
            function updateSoNgayCam() {
                const sUTC = toUTC($ngayCam.val());
                const eUTC = toUTC($ngayHetHan.val());
                if (sUTC == null || eUTC == null) { $soNgayCam.val(''); return; }
                let days = Math.max(0, Math.round((eUTC - sUTC) / ONE_DAY));
                // Nếu muốn TÍNH CỘNG CẢ NGÀY BẮT ĐẦU: days = days + 1;
                $soNgayCam.val(days);
            }

            $ngayCam.on('change', function () {
                const v = $(this).val();
                $ngayHetHan.attr('min', v);
                if ($ngayHetHan.val() && $ngayHetHan.val() < v) {
                    $ngayHetHan.val(v);
                }
                updateSoNgayCam();
            });
            $ngayHetHan.on('change', updateSoNgayCam);

            // MỚI: Nhập số ngày -> suy ra 2 ô ngày
            $soNgayCam.on('input change', function () {
                const raw = $(this).val();
                if (raw === '') return;
                let days = parseInt(raw, 10);
                if (isNaN(days) || days < 0) days = 0;
                $(this).val(days); // chuẩn hóa hiển thị

                if ($ngayCam.val()) {
                    // Có ngày cầm -> tính ngày hết hạn
                    const end = addDays($ngayCam.val(), days);
                    $ngayHetHan.val(end).attr('min', $ngayCam.val());
                } else if ($ngayHetHan.val()) {
                    // Có ngày hết hạn -> tính ngược ra ngày cầm
                    const start = fromUTCtoYmd(toUTC($ngayHetHan.val()) - days * ONE_DAY);
                    $ngayCam.val(start);
                    $ngayHetHan.attr('min', start);
                } else {
                    // Cả hai trống -> mặc định ngày cầm = hôm nay
                    const start = todayYmd();
                    const end = addDays(start, days);
                    $ngayCam.val(start);
                    $ngayHetHan.val(end).attr('min', start);
                }
            });

            // Khởi tạo
            if ($ngayCam.val()) $ngayHetHan.attr('min', $ngayCam.val());
            updateSoNgayCam();
        });
    </script>

@endsection