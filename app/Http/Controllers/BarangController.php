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
            'barang'    => barang::all()
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
        // Validate the request data
        $data =  $request->validate([
            'nama_barang' => 'required',
            'satuan'=> 'required',
        ]);

        $data['kode_barang']    =

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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(barang $barang)
    {
        //
    }
}
