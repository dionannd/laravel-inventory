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
            <li class="{{ set_active('home') }}">
                <a href="{{ route('home') }}" title="Dashboard"><i class="fa fa-lg fa-fw fa-home"></i> <span class="menu-item-parent">Dashboard</span></a>
            </li>
            <li class="{{ set_active('category.index', 'place.index', 'product.index') }}">
                <a href="#"><i class="fa fa-lg fa-fw fa-cubes"></i> <span class="menu-item-parent">Master Barang</span></a>
                <ul>
                    <li class="{{ set_active('category.index') }}">
                        <a href="{{ route('category.index') }}">Kategori <span class="badge pull-right inbox-badge bg-color-yellow">{{ App\Models\Category::count() }}</span></a>
                    </li>
                    <li class="{{ set_active('place.index') }}">
                        <a href="{{ route('place.index') }}">Tempat Barang <span class="badge pull-right inbox-badge bg-color-yellow">{{ App\Models\Place::count() }}</span></a>
                    </li>
                    <li class="{{ set_active('product.index') }}">
                        <a href="{{ route('product.index') }}">Barang <span class="badge pull-right inbox-badge bg-color-yellow">{{ App\Models\Product::count() }}</span></a>
                    </li>
                </ul>
            </li>
            <li class="{{ set_active('purchase.index'. 'sales.index') }}">
                <a href="#"><i class="fa fa-lg fa-fw fa-truck"></i> <span class="menu-item-parent">Master Transaksi</span></a>
                <ul>
                    <li class="{{ set_active('purchase.index') }}">
                        <a href="{{ route('purchase.index') }}">Pembelian Barang</a>
                    </li>
                    <li class="{{ set_active('sales.index') }}">
                        <a href="{{ route('sales.index') }}">Penjualan Barang</a>
                    </li>
                </ul>
            </li>
            <li class="{{ set_active('income.index'. 'cashout.index', 'loss.index') }}">
                <a href="#"><i class="fa fa-lg fa-fw fa-usd"></i> <span class="menu-item-parent">Master Keuangan</span></a>
                <ul>
                    <li class="{{ set_active('income.index') }}">
                        <a href="{{ route('income.index') }}">Pemasukan</a>
                    </li>
                    <li class="{{ set_active('cashout.index') }}">
                        <a href="{{ route('cashout.index') }}">Pengeluaran</a>
                    </li>
                    <li class="{{ set_active('loss.index') }}">
                        <a href="{{ route('loss.index') }}">Kerugian <span class="badge pull-right inbox-badge bg-color-red">{{ App\Models\Loss::count() }}</span></a>
                    </li>
                </ul>
            </li>
            <li class="{{ set_active('supplier.index', 'customer.index') }}>
                <a href="#"><i class="fa fa-lg fa-fw fa-user"></i> <span class="menu-item-parent">Master Pengguna</span></a>
                <ul>
                    <li class="{{ set_active('supplier.index') }}>
                        <a href="{{ route('supplier.index') }}">Pemasok <span class="badge pull-right inbox-badge bg-color-blue">{{ App\Models\Supplier::count() }}</span></a>
                    </li>
                    <li class="{{ set_active('customer.index') }}>
                        <a href="{{ route('customer.index') }}">Pelanggan <span class="badge pull-right inbox-badge bg-color-blue">{{ App\Models\Customer::count() }}</span></a>
                    </li>
                </ul>
            </li>
        </ul> <!-- #END SIDEBAR -->
    </nav>
    <span class="minifyme" data-action="minifyMenu"> 
        <i class="fa fa-arrow-circle-left hit"></i> 
    </span>

</aside>