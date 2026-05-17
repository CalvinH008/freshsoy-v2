@hasrole('admin')
    <a href=" {{ route('admin.dashboard') }} " class="block px-4 py-3 hover:bg-gray-700 transition">admin panel</a>
    <a href=" {{ route('admin.users.index') }} " class="block px-4 py-3 hover:bg-gray-700 transition">User Management</a>
    <a href=" {{ route('admin.outlets.index') }} " class="block px-4 py-3 hover:bg-gray-700 transition">Outlet Management</a>
    <a href=" {{ route('admin.categories.index') }} " class="block px-4 py-3 hover:bg-gray-700 transition">Category
        Management</a>
    <a href=" {{ route('admin.products.index') }} " class="block px-4 py-3 hover:bg-gray-700 transition">Product
        Management</a>
    <a href=" {{ route('admin.stock-movements.index') }} " class="block px-4 py-3 hover:bg-gray-700 transition">Stock
        History</a>
@endhasrole

@hasrole('manager')
    <a href=" {{ route('manager.dashboard') }} " class="block px-4 py-3 hover:bg-gray-770 transition">manager panel</a>
    <a href=" {{ route('manager.products.index') }} " class="block px-4 py-3 hover:bg-gray-700 transition">View Product</a>
    <a href=" {{ route('manager.categories.index') }} " class="block px-4 py-3 hover:bg-gray-700 transition">View Category</a>
    <a href=" {{ route('manager.reports.sales') }} " class="block px-4 py-3 hover:bg-gray-700 transition">Sales Report</a>
    <a href=" {{ route('manager.stock-movements.index') }} " class="block px-4 py-3 hover:bg-gray-700 transition">View Stock Movement</a>
@endhasrole

@hasrole('inventory')
    <a href=" {{ route('inventory.dashboard') }} " class="block px-4 py-3 hover:bg-gray-700 transition">Inventory</a>
    <a href=" {{ route('inventory.stocks.index') }} " class="block px-4 py-3 hover:bg-gray-700 transition">Stock
        Management</a>
    <a href=" {{ route('inventory.stock-movements.index') }} " class="block px-4 py-3 hover:bg-gray-700 transition">Stock
        History</a>
@endhasrole

@hasrole('cashier')
    <a href=" {{ route('cashier.pos') }} " class="block px-4 py-3 hover:bg-gray-770 transition">POS</a>
@endhasrole


@auth
    <p> {{ auth()->user()->name }} </p>
    <p> {{ auth()->user()->getRoleNames()->first() }} </p>
    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit" name="logout">logout</button>
    </form>
@endauth
@guest
    <a href=" {{ route('login') }} ">Login</a>
@endguest
