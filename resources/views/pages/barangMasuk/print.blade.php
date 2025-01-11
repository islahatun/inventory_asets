<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laporan Jumlah Barang Masuk</title>
</head>

<body>
    <table style="border-collapse: collapse; width: 100%;">
        <tr>
            <td style="padding: 10px; vertical-align: middle;">
                <img src="{{ public_path('img/logo-cilegon.png') }}" width="100" height="100" alt="Logo">
            </td>
            <td style="padding: 10px;">
                <h3 style="text-align: center">PEMERINTAH KOTA CILEGON</h3>
                <h4 style="text-align: center">KECAMATAN CIBEBER</h4>
                <p style="text-align: center">Jl. Kedung Baya No. 1 Telp :(0254)385869 Kel. Kalitimbang Kec. Cibeber</p>
            </td>
        </tr>
    </table>
<hr>

    <h3 align="center">LAPORAN JUMLAH BARANG MASUK</h3>
    <div>
        <table border="1" cellspacing="0" cellpadding="3" width="100%">
            <thead>
                <tr>
                    <td>No</td>
                    <td>Tanggal masuk</td>
                    <td>Kode Barang</td>
                    <td>Nama Barang</td>
                    <td>Jumlah Barang</td>
                </tr>
            </thead>
            <tbody>
                @foreach ($barang as $b)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $b->tanggal_masuk }}</td>
                        <td>{{ $b->master_barang->kode_barang }}</td>
                        <td>{{ $b->master_barang->nama_barang }}</td>
                        <td>{{ $b->jumlah }}</td>
                    </tr>
                @endforeach

            </tbody>
        </table>
    </div>


</body>

</html>
