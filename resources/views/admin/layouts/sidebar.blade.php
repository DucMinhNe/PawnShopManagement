  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
      <!-- Brand Logo -->
      <a href="/" class="brand-link">
          <img src="{{ asset('dist/img/logo_caothang.jpg') }}" alt="AdminLTE Logo" class="brand-image img elevation-3"
              style="opacity: .8 ;width: 25px; height: 45px">
          <span class="brand-text font-weight-light">Cao Thắng</span>
      </a>

      <!-- Sidebar -->
      <div class="sidebar">
          <!-- Sidebar user panel (optional) -->
          <div class="user-panel mt-2 pb-2 mb-2 d-flex">
              <div class="image">
                  @php
                  $hinhAnhDaiDien = auth()->user()->hinh_anh_dai_dien ? asset('giangvien_img/' .
                  auth()->user()->hinh_anh_dai_dien) : asset('dist/img/user2-160x160.jpg');
                  @endphp
                  <img src="{{ $hinhAnhDaiDien }}" class="img-circle elevation-2" alt="User Image"
                      style="opacity: .8 ;width: 31px; height: 38px">
                  <!-- <img src="{{ asset('giangvien_img/' . auth()->user()->hinh_anh_dai_dien) }}"
                      class="img-circle elevation-2" alt="User Image"> -->
                  <!-- <img src="{{ asset('dist/img/user2-160x160.jpg') }}" class="img-circle elevation-2" alt="User Image"> -->
              </div>
              <div class="info">
                  <a href="/admin/thongtincanhan" class="d-block"> {{auth()->user()->ten_giang_vien}}</a>
              </div>
          </div>
          <!-- SidebarSearch Form -->
          <div class="form-inline">
              <div class="input-group" data-widget="sidebar-search">
                  <input class="form-control form-control-sidebar" type="search" placeholder="Tìm Kiếm"
                      aria-label="Search">
                  <div class="input-group-append">
                      <button class="btn btn-sidebar">
                          <i class="fas fa-search fa-fw"></i>
                      </button>
                  </div>
              </div>
          </div>

          <!-- Sidebar Menu -->
          <nav class="mt-2">
              <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                  data-accordion="false">
                  <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                  <li class="nav-item">
                      <a href="/admin" class="nav-link {{ Request::is('admin') ? 'active' :''}}">
                          <i class="nav-icon fas fa-duotone fa-house"></i>
                          <p>Trang Chủ</p>
                      </a>
                  </li>
                  @php
                  $isOpen = Request::is('admin/sinhvien') || Request::is('admin/chucvusinhvien') ||
                  Request::is('admin/danhsachchucvusinhvien') || Request::is('admin/lophoc');
                  @endphp
                  <li class="nav-item {{ $isOpen ? 'menu-open' : '' }} ">
                      <a href="#" class="nav-link">
                          <i class="nav-icon fas fa-graduation-cap"></i>
                          <p>
                              Quản Lý Sinh Viên
                              <i class="right fas fa-angle-left"></i>
                          </p>
                      </a>
                      <ul class="nav nav-treeview">
                          <li class="nav-item">
                              <a href="{{ url('/admin/sinhvien') }}"
                                  class="nav-link {{ Request::url() == url('/admin/sinhvien') ? 'active' : '' }}">
                                  <!-- <i class="nav-icon fas fa-graduation-cap"></i> -->
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>Sinh Viên</p>
                              </a>
                          </li>
                          <li class="nav-item">
                              <a href="{{ url('/admin/chucvusinhvien') }}"
                                  class="nav-link {{ Request::url() == url('/admin/chucvusinhvien') ? 'active' : '' }}">
                                  <!-- <i class="nav-icon fas fa-users"></i> -->
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>Chức Vụ Sinh Viên</p>
                              </a>
                          </li>
                          <li class="nav-item">
                              <a href="{{ url('/admin/danhsachchucvusinhvien') }}"
                                  class="nav-link {{ Request::url() == url('/admin/danhsachchucvusinhvien') ? 'active' : '' }}">
                                  <!-- <i class="nav-icon fas fa-users"></i> -->
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>DS Chức Vụ Sinh Viên</p>
                              </a>
                          </li>
                          <li class="nav-item">
                              <a href="{{ url('/admin/lophoc') }}"
                                  class="nav-link {{ Request::url() == url('/admin/lophoc') ? 'active' : '' }}">
                                  <!-- <i class="nav-icon fas fa-users"></i> -->
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>Lớp Học</p>
                              </a>
                          </li>
                      </ul>
                  </li>
                  @php
                  $isOpen = Request::is('admin/giangvien') || Request::is('admin/chucvugiangvien') ||
                  Request::is('admin/danhsachchucvugiangvien');
                  @endphp
                  <li class="nav-item {{ $isOpen ? 'menu-open' : '' }}">
                      <a href="#" class="nav-link">
                          <i class="nav-icon fas fa-person-chalkboard"></i>
                          <p>
                              Quản Lý Giảng Viên
                              <i class="right fas fa-angle-left"></i>
                          </p>
                      </a>
                      <ul class="nav nav-treeview">
                          <li class="nav-item">
                              <a href="{{ url('/admin/giangvien') }}"
                                  class="nav-link {{ Request::url() == url('/admin/giangvien') ? 'active' : '' }}">
                                  <!-- <i class="nav-icon fas fa-users"></i> -->
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>Giảng Viên</p>
                              </a>
                          </li>
                          <li class="nav-item">
                              <a href="{{ url('/admin/chucvugiangvien') }}"
                                  class="nav-link {{ Request::url() == url('/admin/chucvugiangvien') ? 'active' : '' }}">
                                  <!-- <i class="nav-icon fas fa-users"></i> -->
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>Chức Vụ Giảng Viên</p>
                              </a>
                          </li>
                          <li class="nav-item">
                              <a href="{{ url('/admin/danhsachchucvugiangvien') }}"
                                  class="nav-link {{ Request::url() == url('/admin/danhsachchucvugiangvien') ? 'active' : '' }}">
                                  <!-- <i class="nav-icon fas fa-users"></i> -->
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>DS Chức Vụ Giảng Viên</p>
                              </a>
                          </li>

                      </ul>
                  </li>
                    <li class="nav-item">
                      <a href="/admin/dangxuat" class="nav-link">
                          <i class="nav-icon fas fa-right-from-bracket"></i>
                          <p>Quản Lý Cầm Đồ</p>
                      </a>
                  </li>
                  <li class="nav-item">
                      <a href="/admin/dangxuat" class="nav-link">
                          <i class="nav-icon fas fa-right-from-bracket"></i>
                          <p>Đăng Xuất</p>
                      </a>
                  </li>

              </ul>
          </nav>
          <!-- /.sidebar-menu -->
      </div>
      <!-- /.sidebar -->
  </aside>