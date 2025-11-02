<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class PickupController extends Controller
{
    public function verify($code, Request $request)
    {
        // Ambil token dari URL (?token=xxxx)
        $token = $request->query('token');

        // Cek apakah token valid
        if ($token !== env('SECURE_PICKUP_TOKEN')) {
            abort(403, 'Unauthorized access');
        }

        // Cek kode pickup
        $order = Order::where('pickup_code', $code)->first();

        if (!$order) {
            return view('pickup.invalid');
        }

        if ($order->pickup_status === 'sudah_diambil') {
            return view('pickup.used');
        }

        // Update status jika token benar dan belum diambil
        $order->update(['pickup_status' => 'sudah_diambil']);

        return view('pickup.success', compact('order'));
    }
}
