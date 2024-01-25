<aside class="main-sidebar sidebar-light-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route('dashboard') }}" class="brand-link bg-light">
        <img src="{{ asset('img/logo.png') }}" alt="{{ env('APP_NAME') }}" class="brand-image" style="opacity: .8">
        <span class="brand-text font-weight-light">{{ env('APP_NAME') }}</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{ asset('img/default_user.jpg') }}" class="img-circle elevation-2"
                    alt="{{ auth()->user()->username }}">
            </div>
            <div class="info">
                <a href="#" class="d-block">{{ auth()->user()->name }}</a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column nav-flat nav-child-indent" data-widget="treeview"
                role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="{{ route('dashboard') }}" class="nav-link">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('sales-order') }}" class="nav-link">
                        <i class="nav-icon fa-solid fa-clipboard"></i>
                        <p>
                            Sales Order
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('product-design') }}" class="nav-link">
                        <i class="nav-icon fas fa-clipboard"></i>
                        <p>
                            Product Design
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fa-solid fa-industry"></i>
                        <p>
                            Manufacturing
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('manufacturing-1') }}" class="nav-link">
                                <i class="nav-icon fa-solid fa-1"></i>
                                <p>Phase 1</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('manufacturing-2') }}" class="nav-link">
                                <i class="nav-icon fa-solid fa-2"></i>
                                <p>Phase 2</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('manufacturing-3') }}" class="nav-link">
                                <i class="nav-icon fa-solid fa-3"></i>
                                <p>Phase 3</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('manufacturing-cutting') }}" class="nav-link">
                                <i class="nav-icon fa-solid fa-scissors"></i>
                                <p>Cutting</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('manufacturing-infuse') }}" class="nav-link">
                                <i class="nav-icon fa-solid fa-glass-water-droplet"></i>
                                <p>Infuse</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fa-solid fa-paint-roller"></i>
                        <p>
                            Finishing
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('finishing-1') }}" class="nav-link">
                                <i class="nav-icon fa-solid fa-1"></i>
                                <p>Finishing 1</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('finishing-2') }}" class="nav-link">
                                <i class="nav-icon fa-solid fa-2"></i>
                                <p>Finishing 2</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('finishing-3') }}" class="nav-link">
                                <i class="nav-icon fa-solid fa-3"></i>
                                <p>Finishing 3</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fa-solid fa-boxes-packing"></i>
                        <p>
                            RFS
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('rfs') }}" class="nav-link">
                                <i class="nav-icon fa-solid fa-hourglass-start"></i>
                                <p>Pending</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('rfs-lunas') }}" class="nav-link">
                                <i class="nav-icon fa-solid fa-clipboard-check"></i>
                                <p>Lunas</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fa-solid fa-warehouse"></i>
                        <p>
                            Warehouse
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('warehouse.master-barang') }}" class="nav-link">
                                <i class="nav-icon fa-solid fa-boxes-stacked"></i>
                                <p>Master Barang</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('warehouse.stock-monitor') }}" class="nav-link">
                                <i class="nav-icon fa-solid fa-magnifying-glass-chart"></i <p>Stock Monitor</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('warehouse.stock-in') }}" class="nav-link">
                                <i class="nav-icon fa-solid fa-right-to-bracket"></i>
                                <p>Stock Masuk</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('warehouse.stock-out') }}" class="nav-link">
                                <i class="nav-icon fa-solid fa-right-from-bracket"></i>
                                <p>Stock Keluar</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fa-solid fa-gears"></i>
                        <p>
                            Data Reference
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('data-reference.barang-jadi') }}" class="nav-link">
                                <i class="nav-icon fa-solid fa-table-list"></i>
                                <p>Barang Jadi</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('data-reference.motif') }}" class="nav-link">
                                <i class="nav-icon fa-solid fa-table-list"></i>
                                <p>Motif</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('data-reference.tipe-barang') }}" class="nav-link">
                                <i class="nav-icon fa-solid fa-table-list"></i>
                                <p>Tipe Barang</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('data-reference.order-from') }}" class="nav-link">
                                <i class="nav-icon fa-solid fa-table-list"></i>
                                <p>Order From</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('data-reference.metode-molding') }}" class="nav-link">
                                <i class="nav-icon fa-solid fa-table-list"></i>
                                <p>Metode Molding</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('data-reference.sub-molding') }}" class="nav-link">
                                <i class="nav-icon fa-solid fa-table-list"></i>
                                <p>Sub Molding</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="{{ route('user-management') }}" class="nav-link">
                        <i class="nav-icon fas fa-users"></i>
                        <p>
                            User Managements
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="nav-icon fa-solid fa-right-from-bracket"></i>
                        <p>
                            Logout
                        </p>
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
