@extends('layouts.app')
@section('content')
    <form action=" {{ route('admin.stocks.update') }} " method="POST">
        @csrf
        @method('PUT')
        <table>
            <thead>
                <tr>
                    <th>Product Name</th>
                    <th>Variant</th>
                    @foreach ($outlets as $outlet)
                        <th> {{ $outlet->name }} </th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $product)
                    <tr>
                        <td> {{ $product->name }} </td>
                        @foreach ($product->variants as $variant)
                            <td> {{ $variant->size }} </td>
                            @foreach ($outlets as $outlet)
                                <td>
                                    <input type="text" name="stocks[{{ $variant->id }}][{{ $outlet->id }}]" 
                                    value=" {{$variant->stocks->where('outlet_id', $outlet->id)->first()->stock ?? 0}} "
                                    >
                                </td>
                            @endforeach
                        @endforeach
                    </tr>
                @endforeach
            </tbody>
        </table>
        <button type="submit" name="submit">Submit</button>
    </form>
@endsection
