<?php

namespace App\Http\Controllers;

use App\Models\barang;
use App\Models\barang_masuk;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

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
        return view('pages.barangMasuk.index',$data);
    }

    public function getData(){
        $result  = barang_masuk::all();

        return DataTables::of($result)->addIndexColumn()
        ->addColumn('status', function ($data) {
            return 'Aktif';
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
            'barang_id' => 'required',
            'user_id'=> 'required',
            'jumlah'    => 'required',
            'tanggal_masuk'=> 'required',
        ]);

        $result = barang_masuk::create($data);

        if($result){
            $message = array(
                'status' => true,
                'message' => 'Data Berhasil di simpan'
            );
        }else{
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
                    'user_id'=> 'required',
                    'jumlah'    => 'required',
                    'tanggal_masuk'=> 'required',
                ]);

                // Update the category with the new data
                $barangMasuk = barang_masuk::find($request->id);
                $barangMasuk->barang_id = $request->barang_id;
                $barangMasuk->user_id = $request->user_id;
                $barangMasuk->jumlah = $request->jumlah;
                $barangMasuk->tanggal_masuk = $request->tanggal_masuk;

                if($barangMasuk->save()){
                    $message = array(
                        'status' => true,
                        'message' => 'Data Berhasil di ubah'
                    );
                }else{
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
    public function destroy(barang_masuk $barang_masuk)
    {

        if($barang_masuk->delete()){
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
