<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laporan Jumlah Barang</title>
</head>

<body>
    <table style="border-collapse: collapse; width: 70%;" >
        <tr>
            <td style="padding: 10px; vertical-align: middle;" width="40%">
               <div align="right">
                <img src="{{ public_path('img/logo-cilegon.png') }}" width="100" height="100" alt="Logo">
               </div>
            </td>
            <td style="padding: 10px;">
                <h3 style="text-align: center">PEMERINTAH KOTA CILEGON</h3>
                <h4 style="text-align: center">KECAMATAN CIBEBER</h4>
                <p style="text-align: center">Jl. Kedung Baya No. 1 Telp :(0254)385869 Kel. Kalitimbang Kec. Cibeber</p>
            </td>
        </tr>
    </table>

    <h3 align="center">LAPORAN STOK OPNAME</h3>
    <div>
        <table border="1" cellspacing="0" cellpadding="3" width="100%">
            <thead>
                <tr style="text-align: center">
                    <td rowspan="3">No</td>
                    <td rowspan="3">Kode Barang</td>
                    <td rowspan="3">Nama Barang</td>
                    <td colspan="16">Jumlah Kuantitas Persediaan</td>
                </tr>
                <tr>
                    <td colspan="4" style="text-align: center">
                        <div>Stok Opname OPD</div>
                        <div> Saldo ({{ $tgl_awal }} - {{ $tgl_akhir }})</div>
                    </td>
                    <td colspan="4" style="text-align: center">
                        <div>Penambahan (pembelian/Penerimaan/Penambahan)</div>
                        <div> ({{ $tgl_awal }} - {{ $tgl_akhir }})</div>
                    </td>
                    <td colspan="4" style="text-align: center">
                        <div>Penguarangan (pemakaian/Pengurangan/Pengeluaran)</div>
                        <div> ({{ $tgl_awal }} - {{ $tgl_akhir }})</div>
                    </td>
                    <td colspan="4" style="text-align: center">
                        <div>Saldo Akhir</div>
                        <div> ({{ $tgl_awal }} {{ $tgl_akhir }})</div>
                    </td>
                </tr>
                <tr>
                    <td>Jumlah Barang</td>
                    <td>Satuan</td>
                    <td>Harga Satuan</td>
                    <td>Jumlah Harga</td>
                    <td>Jumlah Barang</td>
                    <td>Satuan</td>
                    <td>Harga Satuan</td>
                    <td>Jumlah Harga</td>
                    <td>Jumlah Barang</td>
                    <td>Satuan</td>
                    <td>Harga Satuan</td>
                    <td>Jumlah Harga</td>
                    <td>Jumlah Barang</td>
                    <td>Satuan</td>
                    <td>Harga Satuan</td>
                    <td>Jumlah Harga</td>
                </tr>
            </thead>
            <tbody>

                @foreach ($barang as $key => $items )
                <!-- Header untuk setiap grup -->
                <tr>
                    <td colspan="19" style="background-color: #f0f0f0; font-weight: bold;">
                        {{ $items->first()->header_barang->kode_header ?? '-' }} - {{ $items->first()->header_barang->name ?? '-' }}
                    </td>
                </tr>
                @foreach ($items as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->kode_barang }}</td>
                    <td>{{ $item->nama_barang }}</td>
                    <td>{{ $item->stok }}</td>
                    <td>{{ $item->satuan }}</td>
                    <td>{{ $item->harga }}</td>
                    <td>{{ $item->stok * $item->harga }}</td>
                    <td>{{ $item->barang_masuk->sum('jumlah') }}</td>
                    <td>{{ $item->satuan }}</td>
                    <td>{{ $item->harga }}</td>
                    <td>{{ $item->barang_masuk->sum('jumlah') * $item->harga }}</td>
                    <td>{{ $item->barang_keluar->sum('jumlah') }}</td>
                    <td>{{ $item->satuan }}</td>
                    <td>{{ $item->harga }}</td>
                    <td>{{ $item->barang_keluar->sum('jumlah') * $item->harga }}</td>
                    <td>{{ $item->barang_masuk->sum('jumlah') - $item->barang_keluar->sum('jumlah') }}</td>
                    <td>{{ $item->satuan }}</td>
                    <td>{{ $item->harga }}</td>
                    <td>{{ ( $item->barang_masuk->sum('jumlah') - $item->barang_keluar->sum('jumlah')) * $item->harga }}</td>
                </tr>
@endforeach
                @endforeach

            </tbody>
        </table>
    </div>


</body>

</html>
