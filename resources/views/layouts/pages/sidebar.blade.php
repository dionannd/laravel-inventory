<aside id="left-panel">
    <div class="login-info">
        <span> <!-- User image size is adjusted inside CSS, it should stay as it --> 
            
            <a href="javascript:void(0);" id="show-shortcut" data-action="toggleShortcut">
                <img src="{{ asset('assets/img/avatars/sunny.png') }}" alt="me" class="online" /> 
                <span>
                    {{ Auth::user()->name }} 
                </span>
                <i class="fa fa-angle-down"></i>
            </a> 
            
        </span>
    </div>
    <nav>
        <ul> <!-- #SIDEBAR -->
            <li>
                <a href="{{ route('home') }}" title="Dashboard"><i class="fa fa-lg fa-fw fa-home"></i> <span class="menu-item-parent">Dashboard</span></a>
            </li>
            <li>
                <a href="#"><i class="fa fa-lg fa-fw fa-dropbox"></i> <span class="menu-item-parent">Master Barang</span></a>
                <ul>
                    <li>
                        <a href="{{ route('category.index') }}">Kategori</a>
                    </li>
                    <li>
                        <a href="{{ route('place.index') }}">Tempat Barang</a>
                    </li>
                    <li>
                        <a href="{{ route('product.index') }}">Barang</a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="#"><i class="fa fa-lg fa-fw fa-truck"></i> <span class="menu-item-parent">Master Transaksi</span></a>
                <ul>
                    <li>
                        <a href="{{ route('purchase.index') }}">Pembelian Barang</a>
                    </li>
                    <li>
                        <a href="{{ route('sales.index') }}">Penjualan Barang</a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="#"><i class="fa fa-lg fa-fw fa-usd"></i> <span class="menu-item-parent">Master Keuangan</span></a>
                <ul>
                    <li>
                        <a href="{{ route('income.index') }}">Pemasukan</a>
                    </li>
                    <li>
                        <a href="{{ route('cashout.index') }}">Pengeluaran</a>
                    </li>
                    <li>
                        <a href="{{ route('loss.index') }}">Kerugian</a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="#"><i class="fa fa-lg fa-fw fa-users"></i> <span class="menu-item-parent">Master Pengguna</span></a>
                <ul>
                    <li>
                        <a href="{{ route('supplier.index') }}">Pemasok</a>
                    </li>
                    <li>
                        <a href="{{ route('customer.index') }}">Pelanggan</a>
                    </li>
                </ul>
            </li>
        </ul> <!-- #END SIDEBAR -->
    </nav>
    <span class="minifyme" data-action="minifyMenu"> 
        <i class="fa fa-arrow-circle-left hit"></i> 
    </span>

</aside>