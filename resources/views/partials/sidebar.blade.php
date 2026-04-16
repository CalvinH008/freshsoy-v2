@hasrole('admin')
    <a href=" {{ route('admin.dashboard') }} ">admin panel</a>
@endhasrole

@hasrole('manager')
    <a href="{{ route('manager.dashboard') }}">manager panel</a>
@endhasrole

@hasrole('cashier')
    <a href=" {{ route('cashier.pos') }} ">POS</a>
@endhasrole
