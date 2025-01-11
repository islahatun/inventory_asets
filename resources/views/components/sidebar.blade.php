<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <img src="{{ asset('img/logo-cilegon.png') }}"
            alt="logo"
            width="50"
            class="shadow-light">
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            {{-- <a href="index.html">St</a> --}}
        </div>
        <ul class="sidebar-menu">
            <li class="menu-header">Dashboard</li>
            <li class="nav-item dropdown {{ $type_menu === 'dashboard' ? 'active' : '' }}">
                <a href="#"
                    class="nav-link has-dropdown"><i class="fas fa-fire"></i><span>Dashboard</span></a>
                <ul class="dropdown-menu">
                    <li class='{{ Request::is('dashboard') ? 'active' : '' }}'>
                        <a class="nav-link"
                            href="{{ url('dashboard') }}">Dashboard</a>
                    </li>

                </ul>
            </li>
            <li class="menu-header">Starter</li>
            <li class="nav-item dropdown {{ $type_menu === 'master' ? 'active' : '' }}">
                <a href="#"
                    class="nav-link has-dropdown"
                    data-toggle="dropdown"><i class="fas fa-columns"></i> <span>Master </span></a>
                <ul class="dropdown-menu">
                    <li class="{{ Request::is('departement') ? 'active' : '' }}">
                        <a class="nav-link"
                            href="{{ url('departement') }}">Master Divisi</a>
                    </li>
                    <li class="{{ Request::is('user') ? 'active' : '' }}">
                        <a class="nav-link"
                            href="{{ url('user') }}">Master User</a>
                    </li>
                    <li class="{{ Request::is('barang') ? 'active' : '' }}">
                        <a class="nav-link"
                            href="{{ url('barang') }}">Master Barang</a>
                    </li>
                </ul>
            </li>
            {{-- <li class="{{ Request::is('blank-page') ? 'active' : '' }}">
                <a class="nav-link"
                    href="{{ url('blank-page') }}"><i class="far fa-square"></i> <span>Blank Page</span></a>
            </li> --}}
            <li class="nav-item dropdown {{ $type_menu === 'transaksi' ? 'active' : '' }}">
                <a href="#"
                    class="nav-link has-dropdown"><i class="fas fa-th"></i> <span>Transaksi</span></a>
                <ul class="dropdown-menu">
                    <li class="{{ Request::is('barangMasuk') ? 'active' : '' }}">
                        <a class="nav-link"
                            href="{{ url('barangMasuk') }}">Barang Masuk</a>
                    </li>
                    <li class="{{ Request::is('barangKeluar') ? 'active' : '' }}">
                        <a class="nav-link"
                            href="{{ url('barangKeluar') }}">Barang Keluar</a>
                    </li>
                    <li class="{{ Request::is('pengajuan') ? 'active' : '' }}">
                        <a class="nav-link"
                            href="{{ url('pengajuan') }}">Pengajuan Barang Divisi</a>
                    </li>
                    <li class="{{ Request::is('acc') ? 'active' : '' }}">
                        <a class="nav-link"
                            href="{{ url('acc') }}">Acc Pengajuan Barang</a>
                    </li>
                    <li class="{{ Request::is('aset') ? 'active' : '' }}">
                        <a class="nav-link"
                            href="{{ url('aset') }}">Aset Divisi</a>
                    </li>

                </ul>
            </li>
            <li class="nav-item dropdown {{ $type_menu === 'report' ? 'active' : '' }}">
                <a href="#"
                    class="nav-link has-dropdown"><i class="fas fa-th"></i> <span>Report</span></a>
                <ul class="dropdown-menu">
                    <li class="{{ Request::is('reportBarangMasuk') ? 'active' : '' }}">
                        <a class="nav-link"
                            href="{{ url('reportBarangMasuk') }}">Barang Masuk</a>
                    </li>
                    <li class="{{ Request::is('reportBarangKeluar') ? 'active' : '' }}">
                        <a class="nav-link"
                            href="{{ url('reportBarangKeluar') }}">Barang Keluar</a>
                    </li>
                    <li class="{{ Request::is('reportBarang') ? 'active' : '' }}">
                        <a class="nav-link"
                            href="{{ url('reportBarang') }}">Stock Opname</a>
                    </li>


                </ul>
            </li>
        </ul>
    </aside>
</div>
