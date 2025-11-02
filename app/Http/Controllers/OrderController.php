<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use chillerlan\QRCode\{QRCode, QROptions};
use TCPDF;
use Illuminate\Support\Facades\View;



class OrderController extends Controller
{
    public function index()
{
    // ambil ulang dari DB setiap kali diminta
    $orders = \App\Models\Order::with('items')->latest()->get();

    return view('orders.index', compact('orders'));
}

    public function create()
{
    return view('orders.create');
}

public function store(Request $request)
{
    $request->validate([
        'buyer_name' => 'required|string|max:255',
        'buyer_contact' => 'required|string|max:255',
        'items.*.name' => 'required|string|max:255',
        'items.*.qty' => 'required|integer|min:1',
        'items.*.price' => 'required|numeric|min:0',
    ]);

    // Simpan order
    $order = \App\Models\Order::create([
        'buyer_name' => $request->buyer_name,
        'buyer_contact' => $request->buyer_contact,
        'is_paid' => false,
        'pickup_status' => 'belum_diambil',
    ]);

    // Simpan item barang
    foreach ($request->items as $item) {
        \App\Models\OrderItem::create([
            'order_id' => $order->id,
            'product_name' => $item['name'], // disesuaikan
            'qty' => $item['qty'],
            'price' => $item['price'],
        ]);
    }
    return redirect()->route('orders.index')->with('success', 'Pesanan berhasil dibuat.');
}

public function destroy(Order $order)
{
    $order->delete();
    return redirect()->route('orders.index')->with('success', 'Pesanan berhasil dihapus.');
}


    public function markPaid(Order $order)
{
    $order->update([
        'is_paid' => true,
        'pickup_code' => Str::uuid(),
    ]);

    return redirect()->route('orders.invoice', $order->id);
}

    public function invoice(Order $order){
    $items = $order->items;
    $total = $items->sum(fn($i)=>$i->qty*$i->price);
    $token = env('SECURE_PICKUP_TOKEN', 'default_token');
    $pickupUrl = route('orders.pickup', $order->pickup_code).'?token='.$token;

    // 🔹 Generate QR PNG tanpa GD
    $options = new QROptions([
        'outputType' => QRCode::OUTPUT_IMAGE_PNG,
        'eccLevel' => QRCode::ECC_L,
        'scale' => 5,
    ]);
    $qrPng = (new QRCode($options))->render($pickupUrl);
    $qrImage = base64_encode($qrPng);

    // 🔹 Render Blade
    $html = View::make('orders.invoice', compact('order','items','total','qrImage'))->render();

    // 🔹 PDF
    $pdf = new TCPDF();
    $pdf->AddPage();
    $pdf->writeHTML($html, true, false, true, false, '');
    $filePath = '/tmp/invoice-'.$order->id.'.pdf';
    $pdf->Output($filePath,'F');

    return response()->download($filePath)->deleteFileAfterSend(true);
}
public function pickup($code)
{
    $order = Order::where('pickup_code', $code)->first();

    if (!$order) {
        return response("<h2 style='text-align:center;margin-top:50px;'>❌ Kode tidak ditemukan.</h2>", 404);
    }

    // Jika pesanan sudah diambil sebelumnya
    if ($order->pickup_status === 'Sudah Diambil') {
        return response("<h2 style='text-align:center;margin-top:50px;'>⚠️ Pesanan ini sudah diambil sebelumnya.</h2>");
    }

    // Update status menjadi sudah diambil
    $order->update(['pickup_status' => 'Sudah Diambil']);

    // ✅ Ganti response HTML mentah dengan view Blade
    return view('orders.pickup-success', [
        'order' => $order,
        'message' => 'Pesanan telah berhasil diambil!'
    ]);
}


}