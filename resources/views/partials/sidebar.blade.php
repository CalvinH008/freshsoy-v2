@hasrole('admin')
    <a href=" {{ route('admin.dashboard') }} " class="block px-4 py-3 hover:bg-gray-700 transition">admin panel</a>
    <a href=" {{ route('admin.users.index') }} " class="block px-4 py-3 hover:bg-gray-700 transition">User Management</a>
    <a href=" {{ route('admin.outlets.index') }} " class="block px-4 py-3 hover:bg-gray-700 transition">Outlet Management</a>
    <a href=" {{ route('admin.categories.index') }} " class="block px-4 py-3 hover:bg-gray-700 transition">Category
        Management</a>
    <a href=" {{ route('admin.products.index') }} " class="block px-4 py-3 hover:bg-gray-700 transition">Product
        Management</a>
    <a href=" {{ route('admin.stocks.index') }} " class="block px-4 py-3 hover:bg-gray-700 transition">Stock
        Management</a>
    <a href=" {{ route('admin.stock-movements.index') }} " class="block px-4 py-3 hover:bg-gray-700 transition">Stock
        History</a>
@endhasrole

@hasrole('manager')
    <a href="{{ route('manager.dashboard') }}" class="block px-4 py-3 hover:bg-gray-770 transition">manager panel</a>
    <a href="{{ route('manager.products.index') }}" class="block px-4 py-3 hover:bg-gray-700 transition">View Product</a>
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
