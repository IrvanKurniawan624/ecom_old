@php
    use App\Helpers\App;
@endphp

<nav class="navbar navbar-expand-lg main-navbar">
    <form class="form-inline mr-auto">
      <ul class="navbar-nav mr-3">
        <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars"></i></a></li>
      </ul>
    </form>
    <ul class="navbar-nav navbar-right">
      <li class="dropdown"><a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
        <img alt="image" src="{{asset('assets/img/avatar/avatar-1.png')}}" class="rounded-circle mr-1">
        <div class="d-sm-none d-lg-inline-block">Hi, {{auth()->user()->nama}}</div></a>
        <div class="dropdown-menu dropdown-menu-right">
          <a href="/change-password" class="dropdown-item has-icon">
            <i class="far fa-user"></i> Change Password
          </a>
          <div class="dropdown-divider"></div>
          <a href="/logout" class="dropdown-item has-icon text-danger">
            <i class="fas fa-sign-out-alt"></i> Logout
          </a>
        </div>
      </li>
    </ul>
  </nav>
  <div class="main-sidebar">
    <aside id="sidebar-wrapper">
      <div class="sidebar-brand">
        <a href="/">SELLER PANEL</a>
      </div>
      <div class="sidebar-brand sidebar-brand-sm">
        <a href="/">SP</a>
      </div>
        <?php
          $url_menu = Request::segment(2);
          $url_submenu = Request::segment(3);
        ?>
        <ul class="sidebar-menu">
          <li class="menu-header">Dashboard</li>
          <li class="nav-item dropdown @if(Request::segment(1) == 'dashboard') active @endif "><a href="/dashboard" class="nav-link"><i class="fas fa-home"></i><span>Dashboard</span></a></li>
          <li class="menu-header">Data Master</li>
          <li class="nav-item dropdown @if($url_menu == 'data-master' && $url_submenu == 'master-sosial-media') active @endif"><a href="/admin/data-master/master-sosial-media" class="nav-link"><i class="fab fa-instagram"></i><span>Master Sosial Media</span></a></li>
          <li class="menu-header">Produk</li>
          <li class="nav-item dropdown @if($url_menu == 'produk' && $url_submenu == 'produk') active @endif"><a href="/admin/produk/produk" class="nav-link"><i class="fas fa-shopping-cart"></i><span>Produk</span></a></li>
          <li class="menu-header">Report</li>
          <li class="nav-item dropdown @if($url_menu == 'report' && $url_submenu == 'history-pembelian')  active @endif"><a href="/admin/report/history-pembelian" class="nav-link"><i class="fas fa-history"></i><span>History Penjualan</span></a></li>
          <li class="nav-item dropdown @if($url_menu == 'report' && $url_submenu == 'rekap-pembelian')  active @endif"><a href="/admin/report/rekap-pembelian" class="nav-link"><i class="fas fa-shopping-bag"></i><span>Rekap Penjualan</span></a></li>
          <li class="nav-item dropdown @if($url_menu == 'report' && $url_submenu == 'produk-terbaik')  active @endif"><a href="/admin/report/produk-terbaik" class="nav-link"><i class="fas fa-window-restore"></i><span>Penjualan Terbaik</span></a></li>
          <li class="nav-item dropdown @if($url_menu == 'report' && $url_submenu == 'pembeli-terbaik')  active @endif"><a href="/admin/report/pembeli-terbaik" class="nav-link"><i class="fas fa-user-shield"></i><span>Pembeli Terbaik</span></a></li>
          <li class="nav-item dropdown @if($url_menu == 'report' && $url_submenu == 'stok-produk')  active @endif"><a href="/admin/report/stok-produk" class="nav-link"><i class="fas fa-cubes"></i><span>Stok Produk</span></a></li>
          <li class="menu-header">Apps</li>
          <li class="nav-item dropdown @if($url_menu == 'apps' && $url_submenu == 'transaksi') active @endif"><a href="/admin/apps/transaksi" class="nav-link"><i class="fas fa-shopping-cart"></i><span>Transaksi</span></a></li>
          <li class="nav-item dropdown @if($url_menu == 'apps' && $url_submenu == 'ulasan-pelanggan') active @endif"><a href="/admin/apps/ulasan-pelanggan" class="nav-link"><i class="fas fa-user-cog"></i><span>Ulasan Pelanggan</span></a></li>
          <li class="nav-item dropdown @if($url_menu == 'apps' && $url_submenu == 'pembayaran') active @endif"><a href="/admin/apps/pembayaran" class="nav-link"><i class="fas fa-money-check-alt"></i><span>Pembayaran</span></a></li>
          <li class="nav-item dropdown @if($url_menu == 'apps' && $url_submenu == 'kode-voucher') active @endif"><a href="/admin/apps/kode-voucher" class="nav-link"><i class="fas fa-tag"></i><span>Kode Voucher</span></a></li>
          <li class="nav-item dropdown @if($url_menu == 'apps' && $url_submenu == 'jasa-pengiriman') active @endif"><a href="/admin/apps/jasa-pengiriman" class="nav-link"><i class="fas fa-truck"></i><span>Jasa Pengiriman</span></a></li>
          <li class="nav-item dropdown @if($url_menu == 'apps' && $url_submenu == 'broadcast') active @endif"><a href="/admin/apps/broadcast" class="nav-link"><i class="fas fa-bullhorn"></i><span>Broadcast</span></a></li>
          <li class="nav-item dropdown @if($url_menu == 'apps' && $url_submenu == 'log') active @endif"><a href="/admin/apps/log" class="nav-link"><i class="fas fa-history"></i><span>Log</span></a></li>
        </ul>

    </aside>
  </div>
