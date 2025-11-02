<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold leading-tight text-gray-800">
            {{ __('Daftar Pesanan') }}
        </h2>
    </x-slot>

    {{-- Tambahkan margin top agar tidak nabrak navbar --}}
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">

                {{-- Header --}}
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 p-6 border-b">
                    <div class="flex items-center gap-3">
                        {{-- Tambah Pesanan --}}
                        <a href="{{ url('orders/create') }}"
                            class="bg-green-600 text-white font-semibold py-2 px-4 rounded-lg text-sm shadow hover:bg-green-700 transition">
                            + Tambah Pesanan
                        </a>
                    </div>
                </div>

                {{-- Table --}}
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm text-gray-700">
                        <thead class="bg-gray-100 border-b">
                            <tr>
                                <th class="px-4 py-3 text-left font-semibold">#</th>
                                <th class="px-4 py-3 text-left font-semibold">Nama Pembeli</th>
                                <th class="px-4 py-3 text-left font-semibold">Kontak</th>
                                <th class="px-4 py-3 text-left font-semibold">Detail Barang</th>
                                <th class="px-4 py-3 text-left font-semibold">Total</th>
                                <th class="px-4 py-3 text-left font-semibold">Status Bayar</th>
                                <th class="px-4 py-3 text-left font-semibold">Status Ambil</th>
                                <th class="px-4 py-3 text-center font-semibold">Aksi</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-gray-200">
                            @forelse ($orders as $order)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-4 py-3 font-medium text-gray-900">{{ $order->id }}</td>
                                    <td class="px-4 py-3">{{ $order->buyer_name }}</td>
                                    <td class="px-4 py-3">{{ $order->buyer_contact }}</td>

                                    {{-- Detail Barang --}}
                                    <td class="px-4 py-3 text-left">
                                        <ul class="space-y-1">
                                            @foreach ($order->items as $item)
                                                <li
                                                    class="flex justify-between border-b border-dotted border-gray-200 pb-1">
                                                    <span>{{ $item->product_name }} ({{ $item->qty }}x)</span>
                                                    <span
                                                        class="text-gray-500">Rp{{ number_format($item->price, 0, ',', '.') }}</span>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </td>

                                    {{-- Total --}}
                                    <td class="px-4 py-3 font-semibold text-gray-800">
                                        Rp{{ number_format($order->items->sum(fn($i) => $i->qty * $i->price), 0, ',', '.') }}
                                    </td>

                                    {{-- Status Bayar --}}
                                    <td class="px-4 py-3">
                                        @if ($order->is_paid)
                                            <span
                                                class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800">
                                                Paid
                                            </span>
                                        @else
                                            <span
                                                class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-800">
                                                Unpaid
                                            </span>
                                        @endif
                                    </td>

                                    {{-- Status Ambil --}}
                                    <td class="px-4 py-3">
                                        @php
                                            $pickup = trim(strtolower($order->pickup_status ?? ''));
                                        @endphp

                                        @if (in_array($pickup, ['sudah_diambil', 'sudah diambil', '1', 'true'], true))
                                            <span
                                                class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-800">
                                                Sudah Diambil
                                            </span>
                                        @else
                                            <span
                                                class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-800">
                                                Belum Diambil
                                            </span>
                                        @endif
                                    </td>

                                    {{-- Aksi --}}
                                    <td class="px-4 py-3 text-center space-x-2">
                                        @if (!$order->is_paid)
                                            <a href="{{ url('orders/' . $order->id . '/pay') }}"
                                                class="inline-block bg-blue-500 hover:bg-blue-600 text-white py-1 px-3 rounded-md text-xs transition">
                                                Tandai Bayar
                                            </a>
                                        @else
                                            <a href="{{ route('orders.invoice', $order->id) }}"
                                                class="inline-block bg-green-500 hover:bg-green-600 text-white py-1 px-3 rounded-md text-xs transition">
                                                Lihat Invoice
                                            </a>
                                        @endif

                                        {{-- Tombol Hapus --}}
                                        <form action="{{ route('orders.destroy', $order->id) }}" method="POST"
                                            class="inline-block"
                                            onsubmit="return confirm('Yakin ingin menghapus pesanan ini? Data akan hilang permanen!')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="bg-red-500 hover:bg-red-600 text-white py-1 px-3 rounded-md text-xs transition">
                                                Hapus
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="px-4 py-6 text-center text-gray-500">
                                        Tidak ada pesanan untuk saat ini.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
