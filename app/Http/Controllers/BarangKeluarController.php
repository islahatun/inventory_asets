<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\barang_keluar;
use Yajra\DataTables\DataTables;

class BarangKeluarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    public function getData(){
        $result  = barang_keluar::all();

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
        //
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
    public function destroy(barang_keluar $barang_keluar)
    {
        if($barang_keluar->delete()){
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
