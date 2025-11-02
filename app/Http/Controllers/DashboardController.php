<?php

namespace App\Http\Controllers;

// app/Http/Controllers/DashboardController.php

use App\Models\Order; // Pastikan model Order sudah di-import

class DashboardController extends Controller
{
    public function index()
    {
        // Hitung jumlah pelanggan (berdasarkan nama pembeli unik)
        $customerCount = Order::distinct('buyer_name')->count('buyer_name');

        // Hitung jumlah pesanan yang sudah diambil
        $takenOrders = Order::where('pickup_status', 'Sudah Diambil')->count();

        // 🚨 LOGIKA BARU: Hitung Total Pendapatan
        // Ambil semua pesanan yang sudah diambil
        $completedOrders = Order::where('pickup_status', 'Sudah Diambil')->with('items')->get();

        // ✅ Hitung total pendapatan dari pesanan yang sudah dibayar (is_paid = 1)
        $paidOrders = Order::where('is_paid', 1)->with('items')->get();
        $totalRevenue = $paidOrders->sum(function ($order) {
            return $order->items->sum(fn($item) => $item->qty * $item->price);
        });

        // Kirim data ke view
        return view('dashboard', compact('customerCount', 'takenOrders', 'totalRevenue'));
    }
}
