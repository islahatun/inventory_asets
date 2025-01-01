<?php

namespace App\Http\Controllers;

use App\Models\barang;
use Illuminate\Http\Request;
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
        ];
        return view('pages.barang.index',$data);
    }

    public function getData(){
        $result  = barang::all();

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
        $lastKode = barang::max('kode_barang');
        // Validate the request data
        $data =  $request->validate([
            'nama_barang' => 'required',
            'satuan'=> 'required',
        ]);

        $data['kode_barang']    = $this->generateKodeBarang();

        $result = barang::create($data);

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

         ]);

         // Update the category with the new data
         $barang = barang::find($request->id);
         $barang->nama_barang = $request->nama_barang;
         $barang->satuan = $request->satuan;

         if($barang->save()){
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
    public function destroy(barang $barang)
    {
        if($barang->delete()){
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

    function generateKodeBarang() {
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
        return 'BRG-' . str_pad($newNumber, 4, '0', STR_PAD_LEFT);
    }
}
