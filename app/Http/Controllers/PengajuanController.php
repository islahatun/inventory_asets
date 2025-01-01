<?php

namespace App\Http\Controllers;

use App\Models\barang;
use App\Models\pengajuan;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;

class PengajuanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = [
            'type_menu' => 'transaksi',
            'menu'      => 'Pengajuan',
            'form'      => 'Form Pengajuan',
            'barang'    => barang::all()
        ];
        return view('pages.pengajuan.index',$data);
    }

    public function getData(){

        if(Auth::user()->role == 1){
            $result  = pengajuan::where('user_id',Auth::user()->id)->get();
        }else{
            $result  = pengajuan::all();
        }


        return DataTables::of($result)->addIndexColumn()
        ->addColumn('nama_barang', function ($data) {
            return $data->barang->nama_barang;
        })
        ->addColumn('status', function ($data) {
            if($data->status == 1){
                $result = 'Pengajuan';
            }else if($data->status == 2){
                $result = 'Disetujui';
            }else{
                $result = 'Ditolak';
            }
            return $result;
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
            'id_barang' => 'required|string|max:255',
            'jumlah' => 'required|string|max:255',
        ]);

        $data['user_id']    = Auth::user()->id;
        $data['status']    = 1;

        $result = pengajuan::create($data);

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
    public function show(pengajuan $pengajuan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(pengajuan $pengajuan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, pengajuan $pengajuan)
    {
         // Validate the request data
         $request->validate([
            'id_barang' => 'required|string|max:255',
            'jumlah' => 'required|string|max:255',
        ]);

        // Update the category with the new data
        $pengajuan = pengajuan::find($request->id);
        $pengajuan->id_barang = $request->nama_barang;
        $pengajuan->jumlah = $request->jumlah;

        if($pengajuan->save()){
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

    public function validasi(Request $request){

         // Validate the request data
         $request->validate([
            'status' => 'required|string|max:255',
        ]);

        // Update the category with the new data
        $pengajuan = pengajuan::find($request->id);
        $pengajuan->ststus = $request->ststus;
        $pengajuan->alasan = $request->alasan;

        if($pengajuan->save()){
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
    public function destroy(pengajuan $pengajuan)
    {
        if($pengajuan->delete()){
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
