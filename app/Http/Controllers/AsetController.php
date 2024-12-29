<?php

namespace App\Http\Controllers;

use App\Models\aset;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;

class AsetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = [
            'type_menu' => 'transaksi',
            'menu'      => 'Aset',
            'form'      => 'Form Aset',
            'barang'    => aset::all()
        ];
        return view('pages.aset.index',$data);
    }

    public function getData(){

        if(Auth::user()->role == 1){
            $result  = aset::where('user_id',Auth::user()->id)->get();
        }else{
            $result  = aset::all();
        }


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
        $data = $request->validate([
            'nama_barang' => 'required|string|max:255',
            'jumlah' => 'required|string|max:255',
        ]);

        $data['user_id']    = Auth::user()->id;

        $result = aset::create($data);

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
    public function show(aset $aset)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(aset $aset)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, aset $aset)
    {
         // Validate the request data
         $request->validate([
            'nama_barang' => 'required|string|max:255',
            'jumlah' => 'required|string|max:255',
        ]);

        // Update the category with the new data
        $aset = aset::find($request->id);
        $aset->nama_barang = $request->nama_barang;
        $aset->jumlah = $request->jumlah;
        $aset->user_id    = Auth::user()->id;

        if($aset->save()){
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
    public function destroy(aset $aset)
    {
        if($aset->delete()){
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
