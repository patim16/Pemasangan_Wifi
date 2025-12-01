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
            * { margin: 0; padding: 0; box-sizing: border-box; }
            body {
                background: #f7fafc;
                font-family: 'Inter', sans-serif;
                color: var(--text-primary);
            }
            .sb-topnav {
                background: linear-gradient(135deg, #4361ee 0%, #3f37c9 100%) !important;
                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            }
            .navbar-brand { font-weight: 700; color: #fff !important; }
            .sb-sidenav { background: var(--sidebar-bg) !important; }
            .sb-sidenav-dark .nav-link {
                color: rgba(255,255,255,0.75);
                border-radius: 12px;
            }
            .sb-sidenav-dark .nav-link.active {
                background: var(--sidebar-active);
                border-left: 4px solid var(--accent-purple);
            }
            .sb-sidenav-footer { background: rgba(0,0,0,0.3); }
        </style>
    </head>

<body class="sb-nav-fixed">

    {{-- TOP NAV --}}
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <a class="navbar-brand ps-3">
            @if(session()->has('user'))
                {{ ucfirst(session('user')->role) }}
            @else
                Dashboard
            @endif
        </a>

        <button class="btn btn-link btn-sm" id="sidebarToggle"><i class="fas fa-bars"></i></button>

        <ul class="navbar-nav ms-auto me-3">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                    <i class="fas fa-user fa-fw"></i>
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><hr class="dropdown-divider" /></li>
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


                          {{-- PELANGGAN --}}
@if(session()->has('user') && session('user')->role == 'pelanggan')
    <div class="sb-sidenav-menu-heading">Pelanggan</div>

    <a class="nav-link {{ request()->routeIs('pelanggan.pesanwifi') ? 'active' : '' }}" 
       href="{{ route('pelanggan.pesanwifi') }}">
        <div class="sb-nav-link-icon"><i class="fas fa-wifi"></i></div>
        Pesan WiFi
    </a>

     <a class="nav-link" href="{{ route('pelanggan.riwayat') }}">
        <div class="sb-nav-link-icon"><i class="fas fa-clock"></i></div>
        Riwayat Pemesanan
    </a>

    <a class="nav-link" href="#">
        <div class="sb-nav-link-icon"><i class="fas fa-receipt"></i></div>
        Riwayat Transaksi
    </a>
@endif


                        {{-- SUPERADMIN --}}
                        @if(session()->has('user') && session('user')->role == 'superadmin')
                            <div class="sb-sidenav-menu-heading">Super Admin</div>

                            <a class="nav-link" href="{{ route('superadmin.paketlayanan') }}">
                                <div class="sb-nav-link-icon"><i class="fas fa-users-cog"></i></div>
                                Kelola Daftar Paket
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
                        @endif

                        {{-- ADMIN --}}
                        @if(session()->has('user') && in_array(session('user')->role, ['admin','superadmin']))
                            <div class="sb-sidenav-menu-heading">Admin</div>
                            <a class="nav-link collapsed" data-bs-toggle="collapse" data-bs-target="#collapseLayouts">
                                <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                                Layouts
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="collapseLayouts">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link">Static Navigation</a>
                                    <a class="nav-link">Light Sidenav</a>
                                </nav>
                            </div>
                        @endif

                        {{-- PAYMENT --}}
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

                        {{-- TEKNISI --}}
                        @if(session()->has('user') && session('user')->role == 'teknisi')
                            <div class="sb-sidenav-menu-heading">Teknisi</div>
                            <a class="nav-link">
                                <div class="sb-nav-link-icon"><i class="fas fa-tools"></i></div>
                                Service Tickets
                            </a>
                        @endif
                    </div>
                </div>

                <div class="sb-sidenav-footer">
                    <div class="small">Masuk sebagai:</div>

                    @if(session()->has('user'))
                        <span class="fw-bold text-white">{{ session('user')->nama }}</span>
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

</body>
</html>
