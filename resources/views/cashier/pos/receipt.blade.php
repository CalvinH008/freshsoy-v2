<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Receipt</title>

    <style>
        body {
            font-family: monospace;
            font-size: 12px;
            color: #000;
        }

        .text-center {
            text-align: center;
        }

        .flex {
            width: 100%;
        }

        .row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 4px;
        }

        .border {
            border-top: 1px dashed #999;
            margin: 10px 0;
        }
    </style>
</head>

<body>

    {{-- HEADER --}}
    <div class="text-center">
        <h2>{{ $order->outlet->name }}</h2>

        <p>POS Receipt</p>

        <p>{{ $order->created_at->format('d M Y H:i') }}</p>
    </div>

    <div class="border"></div>

    {{-- ITEMS --}}
    @foreach ($order->items as $item)
        <div>

            <div class="row">
                <span>
                    {{ $item->variant->product->name }}
                </span>

                <span>
                    Rp {{ number_format($item->subtotal) }}
                </span>
            </div>

            <div class="row">
                <small>
                    {{ $item->qty }} x
                    Rp {{ number_format($item->price) }}
                </small>
            </div>

        </div>
    @endforeach

    <div class="border"></div>

    {{-- TOTAL --}}
    <div class="row">
        <strong>Total</strong>

        <strong>
            Rp {{ number_format($order->total_price) }}
        </strong>
    </div>

    <div class="row">
        <span>Bayar</span>

        <span>
            Rp {{ number_format($order->amount_paid) }}
        </span>
    </div>

    <div class="row">
        <strong>Kembali</strong>

        <strong>
            Rp {{ number_format($order->change) }}
        </strong>
    </div>

    <div class="border"></div>

    {{-- FOOTER --}}
    <div class="text-center">
        <p>Kasir: {{ $order->user->name }}</p>

        <p>Terima kasih sudah berbelanja</p>
    </div>

</body>

</html>
