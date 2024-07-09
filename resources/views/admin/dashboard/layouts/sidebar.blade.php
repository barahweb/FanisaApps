<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        <li class="nav-item">
            <a class="nav-link " href="{{ route('dashboard') }}">
                <i class="mdi mdi-home menu-icon"></i>
                <span class="menu-title">Dashboard</span>
            </a>
        </li>
        @if (auth()->user()->level == '1')
        <li class="nav-item {{ Request::is('master/products*') ? 'active' : '' }}">
            <a class="nav-link" data-toggle="collapse" href="#ui-basic" aria-expanded="false" aria-controls="ui-basic">
                <i class="mdi mdi-database menu-icon"></i>
                <span class="menu-title">Data Master</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse {{ Request::is('master/products/create') ? 'show' : '' }}" id="ui-basic">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a
                            class="nav-link {{ Request::is('master/products/create') ? 'active' : '' }}"
                            href="/master/products">Data
                            Barang</a></li>
                </ul>
            </div>
            <div class="collapse {{ Request::is('master/category/create') ? 'show' : '' }}" id="ui-basic">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"><a class="nav-link {{ Request::is('master/category/create') ? 'active' : '' }}"
                            href="/master/category">Data Kategori</a></li>
                </ul>
            </div>
            <div class="collapse {{ Request::is('master/category/create') ? 'show' : '' }}" id="ui-basic">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"><a class="nav-link {{ Request::is('master/category/create') ? 'active' : '' }}"
                            href="/master/customers">Data Customer</a></li>
                </ul>
            </div>
            <div class="collapse {{ Request::is('master/category/create') ? 'show' : '' }}" id="ui-basic">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"><a class="nav-link {{ Request::is('master/category/create') ? 'active' : '' }}"
                            href="/master/suppliers">Data Supplier</a></li>
                </ul>
            </div>
        </li>
        <li class="nav-item ">
            <a class="nav-link" data-toggle="collapse" href="#ui-basic2" aria-expanded="false" aria-controls="ui-basic">
                <i class="mdi mdi-cart-arrow-down menu-icon"></i>
                <span class="menu-title">Transaksi</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="ui-basic2">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"><a class="nav-link" href="/transaksi-pembelian">Transaksi
                            Pembelian</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('transaksi-penjualan') }}">Transaksi
                            Penjualan</a></li>
                </ul>
            </div>
        </li>
        @else
        <li class="nav-item {{ Request::is('master/products*') ? 'active' : '' }}">
            <a class="nav-link" data-toggle="collapse" href="#ui-basic" aria-expanded="false" aria-controls="ui-basic">
                <i class="mdi mdi-database menu-icon"></i>
                <span class="menu-title">Data Master</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse {{ Request::is('master/category/create') ? 'show' : '' }}" id="ui-basic">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"><a class="nav-link {{ Request::is('master/category/create') ? 'active' : '' }}"
                            href="/master/users">Data User</a></li>
                </ul>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#ui-basic1" aria-expanded="false" aria-controls="ui-basic">
                <i class="mdi mdi-file-multiple menu-icon"></i>
                <span class="menu-title">Laporan</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="ui-basic1">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="{{ route('laporan-pembelian') }}">Laporan
                            Pembelian</a></li>
                    <li class="nav-item"> <a class="nav-link" href="{{ route('laporan-penjualan') }}">Laporan
                            Penjualan</a></li>
                </ul>
            </div>
        </li>
        @endif
    </ul>
</nav>