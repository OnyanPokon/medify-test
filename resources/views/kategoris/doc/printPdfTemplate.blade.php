<!DOCTYPE html>
<html>

<head>
    <title>Laporan Kategori</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            padding: 30px;
            color: #333;
        }

        .title {
            text-align: center;
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 20px;
            letter-spacing: 1px;
        }

        .section {
            margin-bottom: 20px;
        }

        .box {
            border: 1px solid #ddd;
            padding: 12px;
            border-radius: 5px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        table th {
            background: #f2f2f2;
            padding: 8px;
            border: 1px solid #ddd;
            text-align: left;
        }

        table td {
            padding: 8px;
            border: 1px solid #ddd;
        }

        .footer {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            text-align: center;
            font-size: 10px;
            color: #777;
            padding: 10px;
        }

        .page-break {
            page-break-after: always;
        }
    </style>
</head>

<body>

    <!-- TITLE -->
    <div class="title">
        LAPORAN KATEGORI PRODUK
    </div>

    <!-- DETAIL KATEGORI -->
    <div class="section">
        <div class="box">
            <p><b>Kode Kategori:</b> {{ $kategori->kode }}</p>
            <p><b>Nama Kategori:</b> {{ $kategori->nama }}</p>
        </div>
    </div>

    <!-- PRODUK -->
    <div class="section">
        <h3>DATA PRODUK</h3>

        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Produk</th>
                    <th>Jenis</th>
                    <th>Supplier</th>
                    <th>Harga Beli</th>
                    <th>Harga Jual</th>
                    <th>Laba</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($kategori->products as $index => $product)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $product->nama }}</td>
                        <td>{{ $product->jenis }}</td>
                        <td>{{ $product->supplier }}</td>
                        <td>Rp {{ number_format($product->harga_beli) }}</td>
                        <td>Rp {{ number_format($product->harga_jual) }}</td>
                        <td>{{ number_format($product->laba) }} (Dalam persen)</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" style="text-align:center;">
                            Tidak ada produk dalam kategori ini
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- FOOTER -->
    <div class="footer">
        Dicetak pada: {{ now()->format('d-m-Y H:i:s') }}
    </div>

</body>

</html>
