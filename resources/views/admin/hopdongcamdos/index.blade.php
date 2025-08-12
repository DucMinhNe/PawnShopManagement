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
                        <th>Lãi Suất (%)</th>
                        <th>Số Tiền Cầm</th>
                        <th>Tiền Lãi</th>
                        <th>Trạng Thái</th>
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
                </thead></th>
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
                                        <input type="date" class="form-control" id="ngay_het_han_cam" name="ngay_het_han_cam"
                                            required>
                                        <div class="invalid-feedback">Vui lòng chọn ngày hết hạn.</div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="so_ngaycam">Số Ngày Cầm</label>
                                        <input type="number" class="form-control" id="so_ngaycam" name="so_ngaycam" value=""
                                             disabled>
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
                                        <label for="tien_lai">Tiền Lãi</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="tien_lai" name="tien_lai" placeholder=""
                                                inputmode="numeric" autocomplete="off" required>
                                            <div class="input-group-append">
                                                <span class="input-group-text">₫</span>
                                            </div>
                                        </div>
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
                        data: 'tien_lai', name: 'tien_lai',
                        render: function (data, type) {
                            if (data == null) return '';
                            const n = Number(data);
                            if (isNaN(n)) return data;
                            const str = n.toLocaleString('vi-VN');
                            return type === 'display' ? (str + ' ₫') : n;
                        }
                    },
                    { data: 'trang_thai', name: 'trang_thai' },
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
                $('#so_tien_cam').val('');
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
                    $('#ngay_het_han_cam').val(data.ngay_het_han_cam);
                    $('#tien_lai').val(data.tien_lai);
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
                    const synced = formatVNDInput($('#so_tien_cam_display').val());
                    $('#so_tien_cam').val(synced.raw);
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
            const $soNgayCam = $('#so_ngaycam'); // Nên để readonly thay vì disabled

            function toUTC(dateStr) {
                if (!dateStr) return null;
                const [y, m, d] = dateStr.split('-').map(Number);
                return Date.UTC(y, m - 1, d);
            }

            function updateSoNgayCam() {
                const sUTC = toUTC($ngayCam.val());
                const eUTC = toUTC($ngayHetHan.val());
                if (sUTC == null || eUTC == null) {
                    $soNgayCam.val('');
                    return;
                }
                let days = Math.max(0, Math.round((eUTC - sUTC) / 86400000));
                // Nếu muốn tính cả ngày bắt đầu: days = days + 1;
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

            // Khởi tạo khi load trang
            if ($ngayCam.val()) $ngayHetHan.attr('min', $ngayCam.val());
            updateSoNgayCam();
        });
    </script>

    <script>
        $(function () {
            const $principalDisp = $('#so_tien_cam_display'); // hiển thị (có dấu .)
            const $principalRaw = $('#so_tien_cam');         // số thuần gửi server
            const $rate = $('#lai_suat');            // %
            const $interestDisp = $('#tien_lai');            // tiền lãi (hiển thị)

            let lastEdited = null; // 'rate' | 'interest' | null

            // Helpers
            function onlyDigits(s) { return (s || '').replace(/[^\d]/g, ''); }
            function formatVND(n) { return n ? Number(n).toLocaleString('vi-VN') : ''; }

            function syncPrincipal() {
                const raw = onlyDigits($principalDisp.val());
                $principalRaw.val(raw);
                // format lại hiển thị
                $principalDisp.val(formatVND(raw));
            }

            function computeFromRate() {
                const P = parseInt($principalRaw.val() || '0', 10);
                const r = parseFloat($rate.val());
                if (!P || isNaN(r)) {
                    $interestDisp.val('');
                    return;
                }
                const I = Math.floor(P * (r / 100)); // đơn giản: lãi = P * r%
                $interestDisp.val(formatVND(I)).attr('data-raw', I);
            }

            function computeFromInterest() {
                const P = parseInt($principalRaw.val() || '0', 10);
                const Iraw = onlyDigits($interestDisp.val());
                if (!P || !Iraw) {
                    $rate.val('');
                    return;
                }
                const I = parseInt(Iraw, 10);
                let r = (I / P) * 100;                 // r %
                r = Math.round(r * 100) / 100;         // làm tròn 2 chữ số thập phân
                $rate.val(r);                          // gán ngược vào ô lãi suất
                // format lại tiền lãi cho đẹp
                $interestDisp.val(formatVND(I)).attr('data-raw', I);
            }

            // Sự kiện
            $principalDisp.on('input', function () {
                syncPrincipal();
                // Sau khi đổi gốc, tính lại theo cái vừa sửa gần nhất
                if (lastEdited === 'rate') computeFromRate();
                if (lastEdited === 'interest') computeFromInterest();
            });

            $rate.on('input change', function () {
                lastEdited = 'rate';
                computeFromRate();
            });

            $interestDisp.on('input', function () {
                // cho phép người dùng gõ số có dấu chấm, mình tự làm sạch và format
                lastEdited = 'interest';
                computeFromInterest();
            });

            // Khởi tạo nếu có sẵn giá trị
            (function init() {
                syncPrincipal();
                if ($rate.val()) { lastEdited = 'rate'; computeFromRate(); }
                else if ($interestDisp.val()) { lastEdited = 'interest'; computeFromInterest(); }
            })();
        });
    </script>

@endsection