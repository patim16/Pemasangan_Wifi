<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Dashboard - SB Admin</title>
        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
        <link href="{{ asset('css/styles.css') }}" rel="stylesheet">
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
        <style>
            /* Modern Elegant Styling */
            :root {
                --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                --secondary-gradient: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
                --success-gradient: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
                --sidebar-bg: #1a1d2e;
                --sidebar-hover: rgba(102, 126, 234, 0.15);
                --sidebar-active: rgba(102, 126, 234, 0.25);
                --card-bg: #ffffff;
                --text-primary: #2d3748;
                --text-secondary: #718096;
                --border-color: #e2e8f0;
                --accent-purple: #667eea;
                --accent-pink: #f093fb;
            }
            
            * {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
            }
            
            body {
                background: #f7fafc;
                font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
                color: var(--text-primary);
                font-size: 15px;
            }
            
            /* Navbar Styling */
            .sb-topnav {
                background: linear-gradient(135deg, #4361ee 0%, #3f37c9 100%) !important;
                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
                border: none;
                height: 60px;
                padding: 0 1.5rem;
            }
            
            .navbar-brand {
                font-weight: 700;
                font-size: 1.25rem;
                letter-spacing: -0.5px;
                color: #fff !important;
            }
            
            .btn-link {
                color: rgba(255, 255, 255, 0.9) !important;
                font-size: 1.1rem;
            }
            
            .btn-link:hover {
                color: #fff !important;
            }
            
            /* Sidebar Styling */
            .sb-sidenav {
                background: var(--sidebar-bg) !important;
                box-shadow: 4px 0 20px rgba(0, 0, 0, 0.1);
            }
            
            .sb-sidenav-menu {
                padding: 1rem 0;
            }
            
            .sb-sidenav-dark .sb-sidenav-menu .nav-link {
                color: rgba(255, 255, 255, 0.75);
                padding: 0.875rem 1.25rem;
                margin: 0.25rem 0.875rem;
                border-radius: 12px;
                font-size: 0.95rem;
                font-weight: 500;
                transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
                position: relative;
                border: 1px solid transparent;
            }
            
            .sb-sidenav-dark .nav-link.active {
                font-weight: 600;
            }
            
            /* Hover Effect - Elegant Background */
            .sb-sidenav-dark .sb-sidenav-menu .nav-link:hover {
                background: var(--sidebar-hover);
                color: #ffffff;
                border-color: rgba(102, 126, 234, 0.3);
                transform: translateX(0);
            }
            
            /* Active State - Highlighted with Color */
            .sb-sidenav-dark .sb-sidenav-menu .nav-link.active {
                background: var(--sidebar-active);
                color: #ffffff;
                font-weight: 600;
                border-left: 4px solid var(--accent-purple);
                border-color: rgba(102, 126, 234, 0.4);
                box-shadow: 0 4px 12px rgba(102, 126, 234, 0.2);
            }
            
            .sb-sidenav-menu-heading {
                color: rgba(255, 255, 255, 0.4);
                font-weight: 700;
                text-transform: uppercase;
                font-size: 0.7rem;
                letter-spacing: 0.1em;
                padding: 1.5rem 1.25rem 0.75rem 1.25rem;
                margin-top: 0.5rem;
            }
            
            .sb-nav-link-icon {
                color: rgba(255, 255, 255, 0.6);
                margin-right: 0.75rem;
                font-size: 1rem;
                width: 20px;
                text-align: center;
                transition: all 0.3s ease;
            }
            
            .nav-link:hover .sb-nav-link-icon {
                color: var(--accent-purple);
            }
            
            .nav-link.active .sb-nav-link-icon {
                color: var(--accent-purple);
            }
            
            /* Collapse Menu Styling */
            .sb-sidenav-collapse-arrow {
                display: inline-block;
                margin-left: auto;
                transition: transform 0.3s ease;
            }
            
            .nav-link[aria-expanded="true"] .sb-sidenav-collapse-arrow {
                transform: rotate(180deg);
            }
            
            .sb-sidenav-menu-nested {
                padding-left: 0;
            }
            
            .sb-sidenav-menu-nested .nav-link {
                padding-left: 3.5rem;
                font-size: 0.9rem;
            }
            
            /* Footer Sidebar */
            .sb-sidenav-footer {
                background: rgba(0, 0, 0, 0.3);
                padding: 1.25rem;
                border-top: 1px solid rgba(255, 255, 255, 0.1);
            }
            
            .sb-sidenav-footer .small {
                color: rgba(255, 255, 255, 0.5);
                font-size: 0.75rem;
                text-transform: uppercase;
                letter-spacing: 0.05em;
            }
            
            .sb-sidenav-footer .fw-bold {
                font-size: 1rem;
                margin-top: 0.25rem;
                display: block;
            }
            
            .sb-sidenav-footer .text-info {
                color: var(--accent-purple) !important;
                font-size: 0.85rem;
                margin-top: 0.25rem;
            }
            
            /* Content Area */
            #layoutSidenav_content {
                background: #f7fafc;
            }
            
            main {
                min-height: calc(100vh - 120px);
            }
            
            /* Card Styling */
            .card {
                border: none;
                border-radius: 16px;
                box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
                transition: all 0.3s ease;
                background: var(--card-bg);
            }
            
            .card:hover {
                box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            }
            
            /* Footer Styling */
            .footer {
                background: #ffffff !important;
                border-top: 1px solid var(--border-color);
                box-shadow: 0 -2px 10px rgba(0, 0, 0, 0.03);
            }
            
            /* Dropdown Menu */
            .dropdown-menu {
                border: none;
                border-radius: 12px;
                box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
                padding: 0.5rem;
                margin-top: 0.5rem;
            }
            
            .dropdown-item {
                border-radius: 8px;
                padding: 0.625rem 1rem;
                margin: 0.125rem 0;
                transition: all 0.2s ease;
                font-size: 0.9rem;
            }
            
            .dropdown-item:hover {
                background: var(--sidebar-hover);
                color: var(--accent-purple);
            }
            
            .dropdown-divider {
                margin: 0.5rem 0;
                border-color: var(--border-color);
            }
            
            /* Navbar User Icon */
            .nav-link.dropdown-toggle {
                padding: 0.5rem 0.75rem;
                border-radius: 8px;
                transition: all 0.3s ease;
            }
            
            .nav-link.dropdown-toggle:hover {
                background: rgba(255, 255, 255, 0.15);
            }
            
            /* Custom Scrollbar */
            ::-webkit-scrollbar {
                width: 8px;
                height: 8px;
            }
            
            ::-webkit-scrollbar-track {
                background: #f1f1f1;
            }
            
            ::-webkit-scrollbar-thumb {
                background: var(--accent-purple);
                border-radius: 4px;
            }
            
            ::-webkit-scrollbar-thumb:hover {
                background: #5568d3;
            }
            
            /* Sidebar Toggle Button */
            #sidebarToggle {
                transition: all 0.3s ease;
            }
            
            #sidebarToggle:hover {
                background: rgba(255, 255, 255, 0.15) !important;
                border-radius: 8px;
            }
            
            /* Responsive */
            @media (max-width: 768px) {
                .sb-sidenav-dark .sb-sidenav-menu .nav-link {
                    padding: 0.75rem 1rem;
                    margin: 0.25rem 0.5rem;
                }
                
                .sb-sidenav-menu-heading {
                    padding: 1.25rem 1rem 0.5rem 1rem;
                }
            }
        </style>
    </head> 

<body class="sb-nav-fixed">

    {{-- TOP NAV --}}
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
       <a class="navbar-brand ps-3" href="#">
    @if(session()->has('user'))
        {{ ucfirst(session('user')->role) }} 
    @else
        Dashboard
    @endif
</a>

        <button class="btn btn-link btn-sm" id="sidebarToggle"><i class="fas fa-bars"></i></button>

        <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" data-bs-toggle="dropdown">
                    <i class="fas fa-user fa-fw"></i>
                </a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                    
                    <li><hr class="dropdown-divider" /></li>

        <a class="navbar-brand ps-3" href="#">
            @if(session()->has('user'))
                {{ ucfirst(session('user')->role) }} 
            @else
                Dashboard
            @endif
        </a>

        <button class="btn btn-link btn-sm" id="sidebarToggle"><i class="fas fa-bars"></i></button>
        
        <ul class="navbar-nav ms-auto me-3">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button"
                   data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fas fa-user fa-fw"></i>
                </a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                    <li><a class="dropdown-item" href="{{ url('/logout') }}">Logout</a></li>
                </ul>
            </li>
        </ul>
    </nav>

    {{-- SIDEBAR --}}
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                <div class="sb-sidenav-menu">

                    <div class="nav">
                        <div class="sb-sidenav-menu-heading">Core</div>

{{-- DASHBOARD BERDASARKAN ROLE --}}
@if(session()->has('user'))
    @php 
        $role = session('user')->role;
    @endphp

    <a class="nav-link" 
       href="
            @if($role == 'superadmin') {{ route('superadmin.dashboard') }}
            @elseif($role == 'admin') {{ route('admin.dashboard') }}
            @elseif($role == 'payment') {{ route('payment.dashboard') }}
            @elseif($role == 'teknisi') {{ route('teknisi.dashboard') }}
            @elseif($role == 'pelanggan') {{ route('pelanggan.dashboard') }}
            @endif
       ">
        <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
        Dashboard
    </a>
@endif


                        
=======
                    <div class="nav">
                        <div class="sb-sidenav-menu-heading">Core</div>

                        {{-- Dashboard --}}
                        @if(session()->has('user'))
                            <a class="nav-link {{ request()->is(session('user')->role.'/dashboard') ? 'active' : '' }}"
                            href="{{ url(session('user')->role.'/dashboard') }}">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Dashboard
                            </a>
                        @endif

                        {{-- PELANGGAN --}}
                        @if(session()->has('user') && session('user')->role == 'pelanggan')
                            <div class="sb-sidenav-menu-heading">Pelanggan</div>
                            <a class="nav-link {{ request()->routeIs('pelanggan.pesanwifi') ? 'active' : '' }}" 
                            href="{{ route('pelanggan.pesanwifi') }}">
                                <div class="sb-nav-link-icon"><i class="fas fa-wifi"></i></div>
                                Pesan WiFi
                            </a>
                            <a class="nav-link {{ request()->routeIs('pelanggan.riwayat') ? 'active' : '' }}" href="{{ route('pelanggan.riwayat') }}">
                                <div class="sb-nav-link-icon"><i class="fas fa-clock"></i></div>
                                Riwayat Pemesanan
                            </a>
                            <a class="nav-link" href="#">
                                <div class="sb-nav-link-icon"><i class="fas fa-receipt"></i></div>
                                Riwayat Transaksi
                            </a>
                        @endif

                        {{-- SUPER ADMIN MENU --}}
                        @if(session()->has('user') && session('user')->role == 'superadmin')
                            <div class="sb-sidenav-menu-heading">Super Admin</div>


                            <a class="nav-link" href="{{ route('superadmin.paketlayanan') }}">
=======
                            <a class="nav-link {{ request()->routeIs('superadmin.admin.index') ? 'active' : '' }}" href="{{ route('superadmin.admin.index') }}">
                                <div class="sb-nav-link-icon"><i class="fas fa-user-shield"></i></div>
                                Kelola Admin
                            </a>
                            <a class="nav-link {{ request()->routeIs('superadmin.teknisi.index') ? 'active' : '' }}" href="{{ route('superadmin.teknisi.index') }}">
                                <div class="sb-nav-link-icon"><i class="fas fa-tools"></i></div>
                                Kelola Teknisi
                            </a>
                            <a class="nav-link {{ request()->routeIs('superadmin.payment.index') ? 'active' : '' }}" href="{{ route('superadmin.payment.index') }}">
                                <div class="sb-nav-link-icon"><i class="fas fa-credit-card"></i></div>
                                Kelola Payment
                            </a>
                            <a class="nav-link {{ request()->routeIs('superadmin.pelanggan.index') ? 'active' : '' }}" href="{{ route('superadmin.pelanggan.index') }}">
                                <div class="sb-nav-link-icon"><i class="fas fa-users"></i></div>
                                Kelola Pelanggan
                            </a>
                            <a class="nav-link {{ request()->routeIs('superadmin.kelolapesanan') ? 'active' : '' }}" href="{{ route('superadmin.kelolapesanan') }}">
                                <div class="sb-nav-link-icon"><i class="fas fa-file-alt"></i></div>
                                Kelola Pesanan
                            </a>
                            <a class="nav-link {{ request()->routeIs('superadmin.paketlayanan') ? 'active' : '' }}" href="{{ route('superadmin.paketlayanan') }}">
                                <div class="sb-nav-link-icon"><i class="fas fa-users-cog"></i></div>
                                Kelola Daftar Paket
                            </a>
                            <a class="nav-link {{ request()->is('superadmin/metodepembayaran*') ? 'active' : '' }}" href="{{ url('superadmin/metodepembayaran') }}">
                                <div class="sb-nav-link-icon"><i class="fas fa-file-alt"></i></div>
                                Kelola Metode Pembayaran
                            </a>


                           <a class="nav-link" href="{{ route('superadmin.admin.index') }}">
                             <div class="sb-nav-link-icon"><i class="fas fa-user-shield"></i></div>
                               Kelola Admin
                          </a>

                           <a class="nav-link" href="{{ route('superadmin.teknisi.index') }}">
                            <div class="sb-nav-link-icon"><i class="fas fa-tools"></i></div>
                               Kelola Teknisi
                          </a>
                          <a class="nav-link" href="{{ route('superadmin.payment.index') }}">
                           <div class="sb-nav-link-icon"><i class="fas fa-credit-card"></i></div>
                              Kelola Payment
                         </a>

                         <a class="nav-link" href="{{ route('superadmin.pelanggan.index') }}">
    <div class="sb-nav-link-icon"><i class="fas fa-users"></i></div>
    Kelola Pelanggan
</a>



                            <!-- Admin Menu Dropdown -->
                            <div class="sb-sidenav-menu-heading">Admin Menu</div>
                            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#adminCollapse" aria-expanded="false" aria-controls="adminCollapse">
                                <div class="sb-nav-link-icon"><i class="fas fa-user-cog"></i></div>
                                Admin Menu
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="adminCollapse" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link {{ request()->routeIs('admin.kelolapayment') ? 'active' : '' }}" href="{{ route('admin.kelolapayment') }}">
                                        <div class="sb-nav-link-icon"><i class="fas fa-credit-card"></i></div>
                                        Kelola Payment
                                    </a>
                                    <a class="nav-link {{ request()->routeIs('admin.kelolateknisi') ? 'active' : '' }}" href="{{ route('admin.kelolateknisi') }}">
                                        <div class="sb-nav-link-icon"><i class="fas fa-user-cog"></i></div>
                                        Kelola Teknisi
                                    </a>
                                    <a class="nav-link {{ request()->routeIs('admin.kelolapelanggan') ? 'active' : '' }}" href="{{ route('admin.kelolapelanggan') }}">
                                        <div class="sb-nav-link-icon"><i class="fas fa-users"></i></div>
                                        Kelola Pelanggan
                                    </a>
                                    <a class="nav-link {{ request()->routeIs('admin.kelolapesanan') ? 'active' : '' }}" href="{{ route('admin.kelolapesanan') }}">
                                        <div class="sb-nav-link-icon"><i class="fas fa-file-alt"></i></div>
                                        Kelola Pesanan
                                    </a>
                                    <a class="nav-link {{ request()->routeIs('admin.paketlayanan') ? 'active' : '' }}" href="{{ route('admin.paketlayanan') }}">
                                        <div class="sb-nav-link-icon"><i class="fas fa-users-cog"></i></div>
                                        Kelola Daftar Paket
                                    </a>
                                    <a class="nav-link {{ request()->routeIs('admin.metodepembayaran') ? 'active' : '' }}" href="{{ route('admin.metodepembayaran') }}">
                                        <div class="sb-nav-link-icon"><i class="fas fa-file-alt"></i></div>
                                        Kelola Metode Pembayaran
                                    </a>
                                </nav>
                            </div>
>>>>>>> b6127ccdf0b1a87b4b91bf0516d6bcbd9e95bc85
                        @endif

                        {{-- ADMIN MENU --}}
                    
                        @if(session()->has('user') && in_array(session('user')->role, ['admin', 'superadmin']))
                            <div class="sb-sidenav-menu-heading">Admin</div>

                            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayouts">
                                <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                                Layouts
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>

                            <div class="collapse" id="collapseLayouts" data-bs-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link" href="#">Static Navigation</a>
                                    <a class="nav-link" href="#">Light Sidenav</a>
                                </nav>
                            </div>
                        @endif

                        
                        {{-- PAYMENT MENU --}}
                    
                        @if(session()->has('user') && session('user')->role == 'payment')
                            <div class="sb-sidenav-menu-heading">Payment</div>

                               <a class="nav-link" href="{{ route('payment.list') }}">
                                  <div class="sb-nav-link-icon"><i class="fas fa-money-bill-wave"></i></div>
                                   Verifikasi Pembayaran
                               </a>
                               <a class="nav-link" href="{{ route('payment.status') }}">
                                  <div class="sb-nav-link-icon"><i class="fas fa-edit"></i></div>
                                  Update status pembayaran
                               </a>
                                <a class="nav-link" href="{{ route('payment.rekap.index') }}">
                                  <div class="sb-nav-link-icon"><i class="fas fa-chart-bar"></i></div>
                                   Rekap Transaksi
                                </a>


                           
                        @endif

                        
                        {{-- TEKNISI MENU --}}
                        
                        @if(session()->has('user') && session('user')->role == 'teknisi')
                            <div class="sb-sidenav-menu-heading">Teknisi</div>

                            <a class="nav-link" href="#">
                                <div class="sb-nav-link-icon"><i class="fas fa-tools"></i></div>
                                Service Tickets
                            </a>
                        @endif

                        
                        {{-- PELANGGAN MENU --}}
                    
                        @if(session()->has('user') && session('user')->role == 'pelanggan')
                            <div class="sb-sidenav-menu-heading">Pelanggan</div>

                            <a class="nav-link" href="#">
                                <div class="sb-nav-link-icon"><i class="fas fa-user-circle"></i></div>
                                My Profile
                        @if(session()->has('user') && session('user')->role == 'admin')
                            <div class="sb-sidenav-menu-heading">Admin</div>
                            <a class="nav-link {{ request()->routeIs('admin.kelolapayment') ? 'active' : '' }}" href="{{ route('admin.kelolapayment') }}">
                                <div class="sb-nav-link-icon"><i class="fas fa-credit-card"></i></div>
                                Kelola Payment
                            </a>
                            <a class="nav-link {{ request()->routeIs('admin.kelolateknisi') ? 'active' : '' }}" href="{{ route('admin.kelolateknisi') }}">
                                <div class="sb-nav-link-icon"><i class="fas fa-user-cog"></i></div>
                                Kelola Teknisi
                            </a>
                            <a class="nav-link {{ request()->routeIs('admin.kelolapelanggan') ? 'active' : '' }}" href="{{ route('admin.kelolapelanggan') }}">
                                <div class="sb-nav-link-icon"><i class="fas fa-users"></i></div>
                                Kelola Pelanggan
                            </a>
                            <a class="nav-link {{ request()->routeIs('admin.kelolapesanan') ? 'active' : '' }}" href="{{ route('admin.kelolapesanan') }}">
                                <div class="sb-nav-link-icon"><i class="fas fa-file-alt"></i></div>
                                Kelola Pesanan
                            </a>
                            <a class="nav-link {{ request()->routeIs('admin.paketlayanan') ? 'active' : '' }}" href="{{ route('admin.paketlayanan') }}">
                                <div class="sb-nav-link-icon"><i class="fas fa-file-alt"></i></div>
                                Kelola Daftar Paket
                            </a>
                            <a class="nav-link {{ request()->routeIs('admin.metodepembayaran') ? 'active' : '' }}" href="{{ route('admin.metodepembayaran') }}">
                                <div class="sb-nav-link-icon"><i class="fas fa-file-alt"></i></div>
                                Kelola Metode Pembayaran
                            </a>
                        @endif

                        {{-- PAYMENT MENU --}}
                        @if(session()->has('user') && session('user')->role == 'payment')
                            <div class="sb-sidenav-menu-heading">Payment</div>
                            <a class="nav-link" href="#">
                                <div class="sb-nav-link-icon"><i class="fas fa-money-bill-wave"></i></div>
                                Transactions
                            </a>
                        @endif

                    {{-- TEKNISI MENU --}}
                        @if(session()->has('user') && session('user')->role == 'teknisi')
                            <div class="sb-sidenav-menu-heading">Teknisi</div>

                            <a class="nav-link {{ request()->is('teknisi/jadwal-survei') ? 'active' : '' }}" href="{{ route('teknisi.jadwal-survei') }}">
                                <div class="sb-nav-link-icon"><i class="fas fa-calendar-check"></i></div>
                                Jadwal Survei
                            </a>

                            <a class="nav-link {{ request()->is('teknisi/jadwal-pemasangan') ? 'active' : '' }}" href="{{ route('teknisi.jadwal-pemasangan') }}">
                                <div class="sb-nav-link-icon"><i class="fas fa-calendar-plus"></i></div>
                                Atur Jadwal Pemasangan
                            </a>

                            <a class="nav-link {{ request()->is('teknisi/laporan') ? 'active' : '' }}" href="{{ url('/teknisi/laporan') }}">
                                <div class="sb-nav-link-icon"><i class="fas fa-file-signature"></i></div>
                                Kirim Laporan Instalasi
                            </a>

                            <a class="nav-link {{ request()->is('teknisi/status') ? 'active' : '' }}" href="/teknisi/status">
                                <div class="sb-nav-link-icon"><i class="fas fa-sync-alt"></i></div>
                                Update Status Pemasangan
                            </a>
                        @endif
                    </div>
                </div>

                {{-- FOOTER --}}
                <div class="sb-sidenav-footer">
                    <div class="small">Masuk sebagai:</div>

                    @if(session()->has('user'))
                        <span class="fw-bold text-white">
                            {{ session('user')->nama }}
                        </span>
                        <div class="text-info">{{ session('user')->role }}</div>
                    @else
                        <span class="fw-bold text-danger">Guest</span>
                    @endif
                </div>
            </nav>
        </div>

        {{-- CONTENT --}}
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid py-4">
                    @yield('content')
                </div>
            </main>
        </div>
    </div>

    {{-- SCRIPT --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js"></script>
    <script src="{{ asset('js/scripts.js') }}"></script>

    
    {{-- SCRIPT TAMBAHAN UNTUK PERBAIKAN --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.querySelector('.sb-sidenav');
            const sidebarMenu = document.querySelector('.sb-sidenav-menu');

            // Perbaikan: Kembalikan posisi scroll dari sessionStorage saat halaman dimuat
            const savedScrollPosition = sessionStorage.getItem('sidebarScrollPosition');
            if (savedScrollPosition && sidebar) {
                sidebar.scrollTop = parseInt(savedScrollPosition, 10);
                // Hapus penyimpanan setelah dipulihkan agar tidak mempengaruhi navigasi lain
                sessionStorage.removeItem('sidebarScrollPosition');
            }

            // Perbaikan: Simpan posisi scroll saat ada link di sidebar yang diklik
            if (sidebarMenu) {
                sidebarMenu.addEventListener('click', function(event) {
                    const targetLink = event.target.closest('a');
                    // Pastikan yang diklik adalah link dan bukan link dropdown atau link tanpa href
                    if (targetLink && targetLink.href && !targetLink.getAttribute('data-bs-toggle')) {
                        sessionStorage.setItem('sidebarScrollPosition', sidebar.scrollTop);
                    }
                });
            }

            // Fitur tambahan: Buka dropdown jika ada menu aktif di dalamnya
            const activeNestedLink = document.querySelector('.sb-sidenav-menu-nested .nav-link.active');
            if (activeNestedLink) {
                const collapseElement = activeNestedLink.closest('.collapse');
                if (collapseElement) {
                    const triggerLink = document.querySelector(`[data-bs-target="#${collapseElement.id}"]`);
                    if (triggerLink) {
                        const bsCollapse = new bootstrap.Collapse(collapseElement, {
                            show: true
                        });
                        triggerLink.classList.remove('collapsed');
                        triggerLink.setAttribute('aria-expanded', 'true');
                    }
                }
            }
        });
    </script>
</body>
</html>