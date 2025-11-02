<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Pickup Berhasil</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-white text-gray-800 flex flex-col items-center justify-center min-h-screen px-6">

    <!-- Icon Check -->
    <div class="flex justify-center mb-6">
        <div class="bg-green-100 p-6 rounded-full shadow-md">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-green-500" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
            </svg>
        </div>
    </div>

    <!-- Success Title -->
    <h1 class="text-4xl font-bold text-green-600 mb-2">Pickup Berhasil!</h1>
    <p class="text-gray-600 text-center mb-8">
        Pesanan kamu telah berhasil diverifikasi.<br>
        Terima kasih telah berbelanja dengan kami 💚
    </p>

    <!-- Order Details -->
    <div class="bg-gray-50 border border-gray-200 rounded-xl p-5 w-full max-w-md shadow-sm">
        <p class="text-gray-700 mb-2"><strong>Nama Pemesan:</strong> {{ $order->buyer_name }}</p>
        <p class="text-gray-700 mb-2">
            <strong>Total:</strong>
            Rp{{ number_format($order->items->sum(fn($i) => $i->qty * $i->price), 0, ',', '.') }}
        </p>
        <p class="text-gray-700"><strong>Status:</strong> <span class="text-green-600 font-semibold">Pickup
                Selesai</span></p>
    </div>

</body>

</html>
