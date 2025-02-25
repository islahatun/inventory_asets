<?php

namespace App\Http\Controllers;

use App\Models\barang;
use App\Models\barang_masuk;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;

class BarangMasukController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = [
            'type_menu' => 'transaksi',
            'menu'      => 'Barang Masuk',
            'form'      => 'Form Barang Masuk',
            'barang'    => barang::all()
        ];
        return view('pages.barangMasuk.index', $data);
    }

    public function getData(Request $request)
    {

        $tgl_awal   = $request->tgl_awal;
        $tgl_akhir   = $request->tgl_akhir;


        $query  = barang_masuk::query();
        $result = $query->with('master_barang');

        if($tgl_awal != null && $tgl_akhir != null ){
            $result =$result->whereBetween('tanggal_masuk',[$tgl_awal,$tgl_akhir]);
        }

        $result = $result->get();


        return DataTables::of($result)->addIndexColumn()
            ->addColumn('barang', function ($data) {
                return $data->master_barang->nama_barang;
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
            'menu'      => 'Laporan Barang Masuk',
            'form'      => 'Form Barang Masuk',
        ];
        return view('pages.barangMasuk.index_print', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the request data
        $data =  $request->validate([
            'barang_id'     => 'required',
            'jumlah'        => 'required',
            'tanggal_masuk' => 'required',
        ]);
        $data['user_id']    = Auth::user()->id;
        $result             = barang_masuk::create($data);

        if ($result) {

            $barang         = barang::find($request->barang_id);
            $barang->stok   = $barang->stok + (int) $request->jumlah;
            if ($barang->save()) {
                $message = array(
                    'status' => true,
                    'message' => 'Data Berhasil di simpan'
                );
            } else {
                $message = array(
                    'status' => false,
                    'message' => 'gagal menyimpan data master'
                );
            }
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
    public function show(barang_masuk $barang_masuk)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(barang_masuk $barang_masuk)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, barang_masuk $barang_masuk)
    {
        // Validate the request data
        $request->validate([
            'barang_id' => 'required',
            'user_id' => 'required',
            'jumlah'    => 'required',
            'tanggal_masuk' => 'required',
        ]);

        // Update the category with the new data
        $barangMasuk = barang_masuk::find($request->id);
        $barangMasuk->barang_id = $request->barang_id;
        $barangMasuk->user_id = $request->user_id;
        $barangMasuk->jumlah = $request->jumlah;
        $barangMasuk->tanggal_masuk = $request->tanggal_masuk;

        if ($barangMasuk->save()) {
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
    public function destroy($id)
    {

        $barang_masuk  = barang_masuk::find($id);
        $barang         = barang::where('id',$barang_masuk->barang_id)->first();
        $barang->stok   = $barang->stok - $barang_masuk->jumlah;
        $barang->save();

        $delete         = barang_masuk::where('id',$id)->delete();

        if($delete){
            $message = array(
                'status' => true,
                'message' => 'Data Berhasil dihapus'
            );
        }else{
            $message = array(
                'status' => false,
                'message' => 'Data gagal dihapus'
            );
        }

        echo json_encode($message);
    }
    public function print($tgl_awal = 0, $tgl_akhir= 0)
    {
        $query = barang_masuk::query();
        $barang_masuk  = $query->with('master_barang');
        if($tgl_awal != 0 && $tgl_akhir != 0){
            $barang_masuk = $barang_masuk->whereBetween('tanggal_masuk',[$tgl_awal,$tgl_akhir]);
        }
        $barang_masuk = $barang_masuk->get();

        $data = [
            'logo' => asset('img/logo-cilegon'),
            'barang'    => $barang_masuk
        ];

        // Render view ke dalam PDF
        $pdf = Pdf::loadView('pages.barangMasuk.print', $data);
        return $pdf->download('laporan-barang-masuk.pdf');
    }
}
