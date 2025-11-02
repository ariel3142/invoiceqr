<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Invoice #{{ $order->id }}</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Arial, sans-serif;
            color: #333;
            margin: 40px auto;
            max-width: 800px;
            background-color: #fff;
            line-height: 1.6;
        }

        h1 {
            text-align: right;
            font-size: 36px;
            letter-spacing: 4px;
            color: #333;
            margin-bottom: 20px;
        }

        .header-line {
            border-top: 1px solid #ccc;
            margin-bottom: 40px;
        }

        .info-table {
            width: 100%;
            margin-bottom: 30px;
            font-size: 14px;
        }

        .info-table td {
            vertical-align: top;
            padding: 4px 0;
        }

        .info-left {
            width: 60%;
        }

        .info-right {
            width: 40%;
            text-align: right;
        }

        .info-title {
            font-weight: bold;
            text-transform: uppercase;
            font-size: 12px;
            letter-spacing: 1px;
        }

        table.items {
            width: 100%;
            border-collapse: collapse;
            margin-top: 30px;
        }

        table.items th {
            text-align: left;
            border-bottom: 1px solid #000;
            padding: 8px 0;
            text-transform: uppercase;
            font-size: 13px;
            letter-spacing: 0.5px;
        }

        table.items td {
            padding: 8px 0;
            border-bottom: 1px solid #eee;
            font-size: 14px;
        }

        .totals {
            width: 100%;
            margin-top: 30px;
            text-align: right;
            font-size: 15px;
        }

        .totals td {
            padding: 4px 0;
        }

        .totals .label {
            text-transform: uppercase;
            font-weight: bold;
        }

        .qr {
            text-align: center;
            margin-top: 50px;
        }

        .qr img {
            margin-top: 10px;
            width: 130px;
            height: 130px;
        }

        .signature {
            margin-top: 50px;
            text-align: right;
            font-family: 'Brush Script MT', cursive;
            font-size: 18px;
            color: #555;
        }
    </style>
</head>
<body>

    <div class="header-line"></div>
    <h1>INVOICE</h1>

    <table class="info-table">
        <tr>
            <td class="info-left">
                <div class="info-title">ISSUED TO:</div>
                <div>{{ $order->buyer_name }}</div>
                <div>{{ $order->buyer_contact }}</div>
            </td>
            <td class="info-right">
                <div class="info-title">INVOICE NO:</div>
                <div>#{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</div>
                <div class="info-title" style="margin-top:10px;">DATE:</div>
                <div>{{ now()->format('d.m.Y') }}</div>
            </td>
        </tr>
    </table>

    <table class="items">
        <thead>
            <tr>
                <th>DESCRIPTION</th>
                <th style="text-align:center;">UNIT PRICE</th>
                <th style="text-align:center;">QTY</th>
                <th style="text-align:right;">TOTAL</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($items as $item)
                <tr>
                    <td>{{ $item->product_name }}</td>
                    <td style="text-align:center;">Rp{{ number_format($item->price, 0, ',', '.') }}</td>
                    <td style="text-align:center;">{{ $item->qty }}</td>
                    <td style="text-align:right;">Rp{{ number_format($item->qty * $item->price, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <table class="totals">
        <tr>
            <td class="label">Subtotal:</td>
            <td>Rp{{ number_format($items->sum(fn($i) => $i->qty * $i->price), 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td class="label">Tax (10%):</td>
            <td>Rp{{ number_format($items->sum(fn($i) => $i->qty * $i->price) * 0.1, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td class="label">Total:</td>
            <td><strong>Rp{{ number_format($items->sum(fn($i) => $i->qty * $i->price) * 1.1, 0, ',', '.') }}</strong></td>
        </tr>
    </table>

    <div class="qr">
    <div><strong>Kode Pickup:</strong> {{ $order->pickup_code }}</div>
    <img src="data:image/png;base64,{{ $qrImage }}" alt="QR Code">
    <div style="margin-top:5px;">Scan QR ini untuk proses pengambilan barang</div>
</div>
<div style="text-align:center; margin-top: 40px;">
    <button id="downloadPdf" style="
        background-color:#4CAF50;
        color:white;
        padding:10px 20px;
        border:none;
        border-radius:5px;
        cursor:pointer;
        font-size:16px;">
        💾 Download PDF
    </button>
</div>

<!-- Tambahkan script JS di akhir body -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
<script>
document.getElementById('downloadPdf').addEventListener('click', () => {
    const invoice = document.body;
    const opt = {
        margin:       0.3,
        filename:     'invoice-{{ $order->id }}.pdf',
        image:        { type: 'jpeg', quality: 0.98 },
        html2canvas:  { scale: 2 },
        jsPDF:        { unit: 'in', format: 'a4', orientation: 'portrait' }
    };
    html2pdf().set(opt).from(invoice).save();
});
</script>
</body>
</html>
