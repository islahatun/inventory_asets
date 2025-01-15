<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\header_barang;
use Yajra\DataTables\DataTables;

class HeaderBarangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = [
            'type_menu' => 'master',
            'menu'      => 'Header Barang',
            'form'      => 'Form Header Barang'
        ];
        return view('pages.headerBarang.index', $data);
    }

    public function getData()
    {
        $result  = header_barang::all();

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
        $request->validate([
            'name' => 'required|string|max:255',
            'kode_header' => 'required|string|max:255',
        ]);

        $result = header_barang::create($request->all());

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
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id) {}

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, header_barang $header_barang)
    {
        // Validate the request data
        $request->validate([
            'name' => 'required|string|max:255',
        ]);


        // Update the category with the new data
        $header = header_barang::find($request->id);
        $header->name = $request->name;

        if ($header->save()) {
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
    public function destroy(string $id)
    {

        $data = header_barang::where('id', $id)->delete();
        if ($data) {
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
}
