<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->

    <!-- Sidebar -->
    <div class="sidebar">
        @switch(Auth::user()?->role)
            @case(0)
                <a href="{{ route('users.home') }}" class="brand-link text-center">
                    <span class="brand-text font-weight-light">Nhân viên</span>
                </a>
            @break

            @case(1)
                <a href="{{ route('admin.index') }}" class="brand-link text-center">
                    <span class="brand-text font-weight-light">Quản lý</span>
                </a>
            @break

            @case(2)
                <a href="{{ route('users.home') }}" class="brand-link text-center">
                    <span class="brand-text font-weight-light">Khách hàng</span>
                </a>
            @break
        @endswitch
        <!-- Sidebar user (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="info    ">
                <a href="{{ route('users.home') }}" class="d-block">{{ Auth::user()?->email }}</a>
            </div>
        </div>
        <!-- SidebarSearch Form -->
        <div class="form-inline">
            <div class="input-group" data-widget="sidebar-search">
                <input class="form-control form-control-sidebar" type="search" placeholder="Search"
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
                @switch(Auth::user()?->role)
                    @case(0)
                        <li
                            class="nav-item {{ in_array(
                                request()->route()->getName(),
                                ['admin.accounts.index', 'admin.accounts.create'],
                            )
                                ? 'menu-is-opening menu-open'
                                : '' }}">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-bars"></i>
                                <p>
                                    Nhiệm vụ của tôi
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('users.task.index') }}"
                                        class="nav-link {{ request()->route()->getName() == 'admin.accounts.create'? 'option-open': '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Danh sách</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    @break

                    @case(1)
                        <li
                            class="nav-item {{ in_array(
                                request()->route()->getName(),
                                ['admin.accounts.index', 'admin.accounts.create'],
                            )
                                ? 'menu-is-opening menu-open'
                                : '' }}">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fa-solid fa-user"></i>
                                <p>
                                    Tài khoản
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li
                                    class="nav-item {{ request()->route()->getName() == 'admin.accounts.create'? 'option-open': '' }}">
                                    <a href="{{ route('admin.accounts.create') }}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Thêm tài khoản</p>
                                    </a>
                                </li>
                                <li
                                    class="nav-item {{ request()->route()->getName() == 'admin.accounts.index'? 'option-open': '' }}">
                                    <a href="{{ route('admin.accounts.index') }}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Danh sách tài khoản</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li
                            class="nav-item {{ in_array(
                                request()->route()->getName(),
                                ['admin.customers.index', 'admin.customers.create'],
                            )
                                ? 'menu-is-opening menu-open'
                                : '' }}">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fa-solid fa-person"></i>
                                <p>
                                    Khách hàng
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                {{-- <li class="nav-item  {{ request()->route()->getName() == 'admin.customers.create'? 'option-open': '' }}">
                                <a href="{{ route('admin.customers.create') }}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Thêm khách hàng</p>
                                </a>
                            </li> --}}
                                <li
                                    class="nav-item  {{ request()->route()->getName() == 'admin.customers.index'? 'option-open': '' }}">
                                    <a href="{{ route('admin.customers.index') }}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Danh sách khách hàng</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li
                            class="nav-item {{ in_array(
                                request()->route()->getName(),
                                ['admin.staffs.index', 'admin.staffs.create'],
                            )
                                ? 'menu-is-opening menu-open'
                                : '' }}">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fa-solid fa-users"></i>
                                <p>
                                    Nhân viên
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                {{-- <li class="nav-item {{ request()->route()->getName() == 'admin.staffs.create'? 'option-open': '' }}">
                                <a href="{{ route('admin.staffs.create') }}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Thêm nhân viên</p>
                                </a>
                            </li> --}}
                                <li
                                    class="nav-item {{ request()->route()->getName() == 'admin.staffs.index'? 'option-open': '' }}">
                                    <a href="{{ route('admin.staffs.index') }}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Danh sách nhân viên</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        {{-- <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fa-solid fa-list"></i>
                            <p>
                                Loại nhiệm vụ
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('admin.tasktypes.create') }}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Thêm loại nhiệm vụ</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.tasktypes.index') }}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Danh sách loại nhiệm vụ</p>
                                </a>
                            </li>
                        </ul>
                    </li> --}}
                        <li
                            class="nav-item {{ in_array(
                                request()->route()->getName(),
                                ['admin.contracts.index', 'admin.contracts.create'],
                            )
                                ? 'menu-is-opening menu-open'
                                : '' }}">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fa-solid fa-file-contract"></i>
                                <p>
                                    Hợp đồng
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li
                                    class="nav-item {{ request()->route()->getName() == 'admin.contracts.create'? 'option-open': '' }}">
                                    <a href="{{ route('admin.contracts.create') }}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Thêm hợp đồng</p>
                                    </a>
                                </li>
                                <li
                                    class="nav-item {{ request()->route()->getName() == 'admin.contracts.index'? 'option-open': '' }}">
                                    <a href="{{ route('admin.contracts.index') }}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Danh sách hợp đồng</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li
                            class="nav-item {{ in_array(
                                request()->route()->getName(),
                                [
                                    'admin.electasks.index',
                                    'admin.electasks.create',
                                    'admin.watertasks.index',
                                    'admin.watertasks.create',
                                    'admin.airtasks.index',
                                    'admin.airtasks.create',
                                ],
                            )
                                ? 'menu-is-opening menu-open'
                                : '' }}">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fa-solid fa-list-check"></i>
                                <p>
                                    Nhiệm vụ
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview"
                                style="display: in_array(
                                        request()->route()->getName(),
                                        [
                                            'admin.electasks.index',
                                            'admin.electasks.create',
                                            'admin.watertasks.index',
                                            'admin.watertasks.create',
                                            'admin.airtasks.index',
                                            'admin.airtasks.create',
                                        ],
                                    )
                                        ? 'block'
                                        : 'none';">
                                <li
                                    class="nav-item {{ in_array(
                                        request()->route()->getName(),
                                        ['admin.electasks.index', 'admin.electasks.create'],
                                    )
                                        ? 'menu-is-opening menu-open'
                                        : '' }}">
                                    <a href="#"
                                        class="nav-link {{ in_array(
                                            request()->route()->getName(),
                                            ['admin.electasks.index', 'admin.electasks.create'],
                                        )
                                            ? 'option-open'
                                            : '' }}">
                                        <i class="nav-icon fa-solid fa-bolt"></i>
                                        <p>
                                            Đo điện
                                            <i class="right fas fa-angle-left"></i>
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview ">
                                        <li
                                            class="nav-item {{ request()->route()->getName() == 'admin.electasks.create'? 'option-open': '' }}">
                                            <a href="{{ route('admin.electasks.create') }}" class="nav-link">
                                                <i class="far fa-circle nav-icon"></i>
                                                <p>Thêm mới</p>
                                            </a>
                                        </li>
                                        <li
                                            class="nav-item {{ request()->route()->getName() == 'admin.electasks.index'? 'option-open': '' }}">
                                            <a href="{{ route('admin.electasks.index') }}" class="nav-link">
                                                <i class="far fa-circle nav-icon"></i>
                                                <p>Danh sách</p>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                <li
                                    class="nav-item {{ in_array(
                                        request()->route()->getName(),
                                        ['admin.watertasks.index', 'admin.watertasks.create'],
                                    )
                                        ? 'menu-is-opening menu-open'
                                        : '' }}">
                                    <a href="#"
                                        class="nav-link {{ in_array(
                                            request()->route()->getName(),
                                            ['admin.watertasks.index', 'admin.watertasks.create'],
                                        )
                                            ? 'option-open'
                                            : '' }}">
                                        <i class="nav-icon fa-solid fa-water"></i>
                                        <p>
                                            Đo nước
                                            <i class="right fas fa-angle-left"></i>
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview ">
                                        <li
                                            class="nav-item {{ request()->route()->getName() == 'admin.watertasks.create'? 'option-open': '' }}">
                                            <a href="{{ route('admin.watertasks.create') }}" class="nav-link">
                                                <i class="far fa-circle nav-icon"></i>
                                                <p>Thêm mới</p>
                                            </a>
                                        </li>
                                        <li
                                            class="nav-item {{ request()->route()->getName() == 'admin.watertasks.index'? 'option-open': '' }}">
                                            <a href="{{ route('admin.watertasks.index') }}" class="nav-link">
                                                <i class="far fa-circle nav-icon"></i>
                                                <p>Danh sách</p>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                <li
                                    class="nav-item {{ in_array(
                                        request()->route()->getName(),
                                        ['admin.airtasks.index', 'admin.airtasks.create'],
                                    )
                                        ? 'menu-is-opening menu-open'
                                        : '' }}">
                                    <a href="#"
                                        class="nav-link {{ in_array(
                                            request()->route()->getName(),
                                            ['admin.airtasks.index', 'admin.airtasks.create'],
                                        )
                                            ? 'option-open'
                                            : '' }}">
                                        <i class="nav-icon fa-solid fa-temperature-three-quarters"></i>
                                        <p>
                                            Đo không khí
                                            <i class="right fas fa-angle-left"></i>
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview ">
                                        <li
                                            class="nav-item {{ request()->route()->getName() == 'admin.airtasks.create'? 'option-open': '' }}">
                                            <a href="{{ route('admin.airtasks.create') }}" class="nav-link">
                                                <i class="far fa-circle nav-icon"></i>
                                                <p>Thêm mới</p>
                                            </a>
                                        </li>
                                        <li
                                            class="nav-item {{ request()->route()->getName() == 'admin.airtasks.index'? 'option-open': '' }}">
                                            <a href="{{ route('admin.airtasks.index') }}" class="nav-link">
                                                <i class="far fa-circle nav-icon"></i>
                                                <p>Danh sách</p>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                    @break

                    @case(2)
                    @break
                @endswitch
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
