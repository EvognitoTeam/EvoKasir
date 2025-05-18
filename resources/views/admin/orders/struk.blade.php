<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Struk Pembelian</title>
    @vite(['resources/css/app.css'])

    <!-- Menambahkan pustaka QRCode.js -->
    <script src="https://cdn.jsdelivr.net/npm/qrcode/build/qrcode.min.js"></script>

    <style>
        @media print {
            @page {
                size: 57mm auto;
                margin: -3mm 3mm 1mm 3mm;
            }

            body {
                font-family: 'Arial', sans-serif;
                font-size: 10px;
                width: 57mm;
                margin: 0 auto !important;
                padding: 0 !important;
            }

            img.logo {
                display: block;
                margin: 0 auto 5px auto;
                max-height: 50px;
            }

            .footer p {
                margin-bottom: 1px;
            }
        }

        body {
            font-family: 'Arial', sans-serif;
            font-size: 10px;
            width: 57mm;
            margin: 0 auto;
        }

        img.logo {
            display: block;
            margin: 5% auto 5px auto;
            max-height: 50px;
        }

        /* Menambahkan style untuk QR Code */
        .qr-code {
            width: 100px;
            /* Ukuran QR code */
            height: 100px;
            margin-left: 10px;
        }

        /* Untuk memisahkan nama toko dan QR code */
        .order-info {
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 5px;
            /* Memberikan ruang antara elemen */
        }

        .order-info h2 {
            margin-right: 4px;
            /* Memberikan ruang antara order code dan QR */
        }
    </style>
</head>

<body class="text-[10px] mx-auto">

    @if ($showLogo && $logo)
        <img class="logo" src="{{ asset('storage/' . $logo) }}" alt="Logo">
    @endif

    <!-- Menggunakan flexbox untuk memisahkan nama toko dan QR code -->
    <div class="text-center order-info my-1">
        <strong class="uppercase">{{ $order->mitra->mitra_name }}</strong>
    </div>
    {{-- <div class="text-center order-info">
        <h2 class="text-[12px] font-bold">Order Code : {{ $order->order_code }}</h2>
        <div id="qrcode" class="qr-code"></div>
    </div> --}}

    <div class="mt-1 space-y-0.5">
        <p class="text-left">Kasir: {{ Auth::user()->name }}</p>
        <p class="text-left">Pelanggan: {{ $order->name }}</p>
        <p class="text-left">Meja: {{ $order->table->table_name }}</p>
        <p class="text-left">Metode Pembayaran: {{ Str::upper($order->payment_method) }}</p>
    </div>

    <div class="border-t-2 border-dashed border-black my-1.5"></div>

    @foreach ($order->items as $item)
        <div class="mb-0.5">
            <p>{{ $item->product->name ?? '-' }}</p>
            <div class="flex justify-between w-full">
                <span>{{ $item->quantity }} x {{ number_format($item->price) }}</span>
                <span>Rp{{ number_format($item->quantity * $item->price) }}</span>
            </div>
        </div>
    @endforeach

    <div class="border-t-2 border-dashed border-black my-1.5"></div>

    @if ($order->discount > 0)
        <div class="flex justify-between">
            <strong>Total</strong>
            <strong>Rp{{ number_format($order->total_price) }}</strong>
        </div>
        <div class="flex justify-between">
            <strong>Diskon</strong>
            <strong>Rp{{ number_format($order->discount) }}</strong>
        </div>
    @endif

    <div class="flex justify-between mt-1">
        <strong>Total dibayar</strong>
        <strong>Rp{{ number_format($order->totalAfterDiscount ?? $order->total_price) }}</strong>
    </div>

    <div class="border-t-2 border-dashed border-black my-2"></div>

    <div class="text-center footer space-y-1">
        <div>{!! $footer !!}</div>
        <p>printed at {{ date('d-m-Y H:i') }}</p>
        <p>powered by Evognito Team</p>
    </div>

    <div class="center mt-4 print:hidden">
        <button onclick="window.location.href='{{ route('admin.orders.index', ['slug' => $slug]) }}'"
            class="bg-blue-600 text-white px-4 py-2 rounded text-sm">Kembali ke Menu</button>
        {{-- <button onclick="window.print();" class="bg-green-600 text-white px-4 py-2 rounded text-sm">Print</button> --}}
    </div>

    <script>
        // Pastikan order_code ada dan valid
        const orderCode =
            "https://evokasir.evognito.my.id/{{ $slug }}/order/detail/{{ $order->order_code }}"; // Mengambil Order Code
        const qrcodeContainer = document.getElementById('qrcode');

        if (orderCode) {
            // Jika order_code ada, buat QR code menggunakan toDataURL
            QRCode.toDataURL(orderCode, function(error, url) {
                if (error) {
                    console.error("Error generating QR code: ", error);
                } else {
                    // Menampilkan QR code dalam elemen dengan id 'qrcode'
                    const img = document.createElement('img');
                    img.src = url;
                    qrcodeContainer.appendChild(img);
                }
            });
        } else {
            console.error("Order code is empty");
        }

        function redirectAfterPrint() {
            window.location.href = "{{ route('admin.menu.index', ['slug' => $slug]) }}";
        }

        window.print();

        // if (typeof window.onafterprint !== "undefined") {
        //     window.onafterprint = redirectAfterPrint;
        // } else {
        //     // fallback jika onafterprint tidak dipicu
        //     setTimeout(redirectAfterPrint, 1500);
        // }
    </script>

</body>

</html>
