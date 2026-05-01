@hasrole('admin')
    <a href=" {{ route('admin.dashboard') }} " class="block px-4 py-3 hover:bg-gray-700 transition">admin panel</a>
@endhasrole

@hasrole('manager')
    <a href="{{ route('manager.dashboard') }}" class="block px-4 py-3 hover:bg-gray-7700 transition">manager panel</a>
@endhasrole

@hasrole('cashier')
    <a href=" {{ route('cashier.pos') }} " class="block px-4 py-3 hover:bg-gray-7700 transition">POS</a>
@endhasrole
