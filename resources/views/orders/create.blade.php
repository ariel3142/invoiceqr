<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Tambah Pesanan Baru
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-100 min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h3 class="text-lg font-semibold mb-4 text-gray-700">Form Pesanan</h3>

                <form action="{{ route('orders.store') }}" method="POST">
                    @csrf

                    <!-- Nama Pembeli -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Pembeli</label>
                        <input type="text" name="buyer_name" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500" required>
                    </div>

                    <!-- Kontak Pembeli -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Email / No HP</label>
                        <input type="text" name="buyer_contact" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500" required>
                    </div>

                    <!-- Daftar Barang -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">List Barang</label>

                        <table class="min-w-full border border-gray-300" id="items-table">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="border px-3 py-2 text-left text-sm text-gray-700">Nama Barang</th>
                                    <th class="border px-3 py-2 text-left text-sm text-gray-700">Jumlah</th>
                                    <th class="border px-3 py-2 text-left text-sm text-gray-700">Harga (Rp)</th>
                                    <th class="border px-3 py-2 text-center text-sm text-gray-700 w-20">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="items-body">
                                <tr>
                                    <td class="border px-3 py-2"><input type="text" name="items[0][name]" class="w-full border-gray-300 rounded-md" required></td>
                                    <td class="border px-3 py-2"><input type="number" name="items[0][qty]" class="w-full border-gray-300 rounded-md" min="1" required></td>
                                    <td class="border px-3 py-2"><input type="number" name="items[0][price]" class="w-full border-gray-300 rounded-md" min="0" required></td>
                                    <td class="border px-3 py-2 text-center">
                                        <button type="button" class="bg-red-500 text-white px-2 py-1 rounded remove-item">✕</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                        <button type="button" id="add-item" class="mt-3 bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                            + Tambah Barang
                        </button>
                    </div>

                    <!-- Tombol Submit -->
                    <div class="flex justify-end">
                        <button type="submit" class="bg-blue-600 text-white px-5 py-2 rounded hover:bg-blue-700">
                            Simpan Pesanan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Script Tambah/Hapus Barang -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            let index = 1;
            const addButton = document.getElementById('add-item');
            const tbody = document.getElementById('items-body');

            addButton.addEventListener('click', function () {
                const newRow = document.createElement('tr');
                newRow.innerHTML = `
                    <td class="border px-3 py-2"><input type="text" name="items[${index}][name]" class="w-full border-gray-300 rounded-md" required></td>
                    <td class="border px-3 py-2"><input type="number" name="items[${index}][qty]" class="w-full border-gray-300 rounded-md" min="1" required></td>
                    <td class="border px-3 py-2"><input type="number" name="items[${index}][price]" class="w-full border-gray-300 rounded-md" min="0" required></td>
                    <td class="border px-3 py-2 text-center">
                        <button type="button" class="bg-red-500 text-black px-2 py-1 rounded remove-item">✕</button>
                    </td>
                `;
                tbody.appendChild(newRow);
                index++;
            });

            tbody.addEventListener('click', function (e) {
                if (e.target.classList.contains('remove-item')) {
                    e.target.closest('tr').remove();
                }
            });
        });
    </script>
</x-app-layout>
