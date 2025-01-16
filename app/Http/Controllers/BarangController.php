<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\barang;
use App\Models\header_barang;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Yajra\DataTables\DataTables;

class BarangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = [
            'type_menu' => 'master',
            'menu'      => 'Barang',
            'form'      => 'Form Barang',
            'header'    => header_barang::all()
        ];
        return view('pages.barang.index', $data);
    }

    public function getData()
    {
        $result  = barang::with('header_barang')->get();

        return DataTables::of($result)->addIndexColumn()
            ->addColumn('status', function ($data) {
                return 'Aktif';
            })
            ->addColumn('id_header', function ($data) {
                return $data->header_barang->kode_header;
            })

            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data = [
            'type_menu' => 'report',
            'menu'      => 'Laporan Stok Opname',
            'form'      => 'Form Stok Opname',
        ];
        return view('pages.barang.index_print', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $lastKode = barang::max('kode_barang');
        // Validate the request data
        $data =  $request->validate([
            'nama_barang' => 'required',
            'satuan' => 'required',
            'harga' => 'required',
            'id_header' => 'required',
        ]);

        $data['kode_barang']    = $this->generateKodeBarang($request->id_header);

        $result = barang::create($data);

        if ($result) {
            $message = array(
                'status' => true,
                'message' => 'Data Berhasil di simpan'
            );
        } else {
            $message = array(
                'status' => false,
                'message' => 'Data gagal di simpan'
            );
        }

        echo json_encode($message);
    }

    /**
     * Display the specified resource.
     */
    public function show(barang $barang)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(barang $barang)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, barang $barang)
    {
        // Validate the request data
        $request->validate([
            'nama_barang'   => 'required',
            'satuan'       => 'required',
            'harga'       => 'required',
            'id_header'       => 'required',

        ]);

        // Update the category with the new data
        $barang = barang::find($request->id);
        $barang->nama_barang = $request->nama_barang;
        $barang->satuan = $request->satuan;
        $barang->harga = $request->harga;
        $barang->id_header = $request->id_header;

        if ($barang->save()) {
            $message = array(
                'status' => true,
                'message' => 'Data Berhasil di ubah'
            );
        } else {
            $message = array(
                'status' => false,
                'message' => 'Data gagal di ubah'
            );
        }

        echo json_encode($message);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(barang $barang)
    {
        if ($barang->delete()) {
            $message = array(
                'status' => true,
                'message' => 'Data Berhasil dihapus'
            );
        } else {
            $message = array(
                'status' => false,
                'message' => 'Data gagal dihapus'
            );
        }

        echo json_encode($message);
    }

    function generateKodeBarang($id_header)
    {

        $header = header_barang::find($id_header);
        // Cari kode barang terakhir
        $lastKode = Barang::max('kode_barang');

        if ($lastKode) {
            // Ambil angka dari kode terakhir dan tambahkan 1
            $lastNumber = (int) substr($lastKode, 4); // Misal: 'BRG-0001' -> 1
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1; // Jika belum ada data
        }

        // Format kode barang baru
        return $header->kode_header . '-' . str_pad($newNumber, 4, '0', STR_PAD_LEFT);
    }

    public function print($tgl_awal = 0, $tgl_akhir = 0)
    {

        Carbon::setLocale('id');

        $query = barang::query();
        $barang  = $query->with('header_barang', 'barang_masuk', 'barang_keluar');
        if ($tgl_awal != 0 && $tgl_akhir != 0) {
            $barang->whereBetween('created_at', [$tgl_awal, $tgl_akhir]);
            $barang->whereHas('barang_masuk', function ($data) use ($tgl_awal, $tgl_akhir) {
                $data->whereBetween('tanggal_masuk', [$tgl_awal, $tgl_akhir]);
            });
            $barang->whereHas('barang_keluar', function ($data) use ($tgl_awal, $tgl_akhir) {
                $data->whereBetween('tanggal_keluar', [$tgl_awal, $tgl_akhir]);
            });
        }
        $barang = $barang->get()->groupBy(function ($item) {
            return $item->header_barang->id; // Mengelompokkan berdasarkan id_header
        });
        $data = [
            'tgl_awal'  => Carbon::parse($tgl_awal)->translatedFormat('d F Y'),
            'tgl_akhir' => Carbon::parse($tgl_akhir)->translatedFormat('d F Y'),
            'barang'    => $barang
        ];

        // Render view ke dalam PDF
        $pdf = Pdf::loadView('pages.barang.print', $data)
            ->setPaper([0, 0, 841.89, 1500], 'landscape');
        return $pdf->download('Stok Opname.pdf');
    }
}
