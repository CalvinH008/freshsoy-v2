@hasrole('admin')
    <a href=" {{ route('admin.dashboard') }} " class="block px-4 py-3 hover:bg-gray-700 transition">admin panel</a>
    <a href=" {{ route('admin.users.index') }} " class="block px-4 py-3 hover:bg-gray-700 transition">User Management</a>
    <a href=" {{ route('admin.outlets.index') }} " class="block px-4 py-3 hover:bg-gray-700 transition">Outlet Management</a>
    <a href=" {{ route('admin.categories.index') }} " class="block px-4 py-3 hover:bg-gray-700 transition">Category
        Management</a>
    <a href=" {{ route('admin.products.index') }} " class="block px-4 py-3 hover:bg-gray-700 transition">Product
        Management</a>
@endhasrole

@hasrole('manager')
    <a href="{{ route('manager.dashboard') }}" class="block px-4 py-3 hover:bg-gray-7700 transition">manager panel</a>
@endhasrole

@hasrole('cashier')
    <a href=" {{ route('cashier.pos') }} " class="block px-4 py-3 hover:bg-gray-7700 transition">POS</a>
@endhasrole
