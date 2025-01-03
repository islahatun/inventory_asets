<?php

namespace App\Http\Controllers;

use App\Models\barang;
use Illuminate\Http\Request;
use App\Models\barang_keluar;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;

class BarangKeluarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = [
            'type_menu' => 'transaksi',
            'menu'      => 'Barang Keluar',
            'form'      => 'Form Barang Keluar',
            'barang'    => barang::all()
        ];
        return view('pages.barangKeluar.index', $data);
    }

    public function getData(){
        $result  = barang_keluar::all();

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
        //
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
                    'tanggal_keluar' => 'required',
                ]);

                $barang         = barang::find($request->barang_id);

                if($barang->stock ==0){
                    $message = array(
                        'status' => false,
                        'message' => 'Stok barang kosong'
                    );
                    return json_encode($message);
                }

                if(($barang->stok - (int) $request->jumlah) < 0){
                    $message = array(
                        'status' => false,
                        'message' => 'Stok barang Kurang'
                    );
                    return json_encode($message);
                }


                $data['user_id']    = Auth::user()->id;
                $result             = barang_keluar::create($data);

                if ($result) {
                    $barang         = barang::find($request->barang_id);
                    $barang->stok   = $barang->stok - (int) $request->jumlah;
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
    public function show(barang_keluar $barang_keluar)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(barang_keluar $barang_keluar)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, barang_keluar $barang_keluar)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {

        $barang_keluar  = barang_keluar::find($id);
        $barang         = barang::where('id',$barang_keluar->barang_id)->first();
        $barang->stok   = $barang->stok + $barang_keluar->jumlah;
        $barang->save();

        $delete         = barang_keluar::where('id',$id)->delete();

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
}
