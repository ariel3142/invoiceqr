<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- GRID CARD --}}
            <div class="flex flex-wrap justify-between gap-6">

                {{-- CARD 1: Total Customer --}}
                <div
                    class="flex-1 min-w-[250px] bg-white p-6 rounded-2xl shadow-sm hover:shadow-lg transition duration-300 transform hover:-translate-y-1 animate-fadeUp delay-[100ms]">
                    <div class="flex flex-col space-y-4">
                        <div class="flex items-center space-x-3">
                            <div class="p-3 bg-gray-100 rounded-xl">
                                <x-heroicon-o-users class="w-6 h-6 text-indigo-500" />
                            </div>
                        </div>
                        <div>
                            <p class="text-gray-500 text-sm font-medium">Total Pelanggan</p>
                            <h3 class="text-3xl font-bold text-gray-900 mt-1">
                                {{ number_format($customerCount, 0, ',', '.') }}
                            </h3>
                        </div>
                    </div>
                </div>

                {{-- CARD 2: Total Order --}}
                <div
                    class="flex-1 min-w-[250px] bg-white p-6 rounded-2xl shadow-sm hover:shadow-lg transition duration-300 transform hover:-translate-y-1 animate-fadeUp delay-[200ms]">
                    <div class="flex flex-col space-y-4">
                        <div class="flex items-center space-x-3">
                            <div class="p-3 bg-gray-100 rounded-xl">
                                <x-heroicon-o-shopping-bag class="w-6 h-6 text-green-500" />
                            </div>
                        </div>
                        <div>
                            <p class="text-gray-500 text-sm font-medium">Total Pesanan Yang Telah Diambil</p>
                            <h3 class="text-3xl font-bold text-gray-900 mt-1">
                                {{ number_format($takenOrders, 0, ',', '.') }}
                            </h3>
                        </div>
                    </div>
                </div>

                {{-- CARD 3: Total Pendapatan --}}
                <div
                    class="flex-1 min-w-[250px] bg-white p-6 rounded-2xl shadow-sm hover:shadow-lg transition duration-300 transform hover:-translate-y-1 animate-fadeUp delay-[300ms]">
                    <div class="flex flex-col space-y-4">
                        <div class="flex items-center space-x-3">
                            <div class="p-3 bg-gray-100 rounded-xl">
                                <x-heroicon-o-currency-dollar class="w-6 h-6 text-yellow-500" />
                            </div>
                        </div>
                        <div>
                            <p class="text-gray-500 text-sm font-medium">Total Pendapatan</p>
                            <h3 class="text-3xl font-bold text-gray-900 mt-1">
                                Rp{{ number_format($totalRevenue, 0, ',', '.') }}
                            </h3>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    {{-- ANIMASI --}}
    <style>
        @keyframes fadeUp {
            0% {
                opacity: 0;
                transform: translateY(15px);
            }

            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fadeUp {
            animation: fadeUp 0.7s ease-out forwards;
        }

        .delay-\[100ms\] {
            animation-delay: 0.1s;
        }

        .delay-\[200ms\] {
            animation-delay: 0.2s;
        }

        .delay-\[300ms\] {
            animation-delay: 0.3s;
        }
    </style>
</x-app-layout>
