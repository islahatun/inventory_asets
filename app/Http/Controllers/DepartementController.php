<?php

namespace App\Http\Controllers;

use App\Models\Departement;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class DepartementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = [
            'type_menu' => 'master',
            'menu'      => 'Divisi',
            'form'      => 'Form Divisi'
        ];
        return view('pages.departement.index',$data);

    }

    public function getData(){
        $result  = Departement::all();

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
                $request->validate([
                    'name_departement' => 'required|string|max:255',
                ]);

                $result = Departement::create($request->all());

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
    public function show(Departement $departement)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Departement $departement)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Departement $departement)
    {
         // Validate the request data
         $request->validate([
            'name_departement' => 'required|string|max:255',
        ]);

        // Update the category with the new data
        $departement = Departement::find($request->id);
        $departement->name_departement = $request->name_departement;

        if($departement->save()){
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
    public function destroy(Departement $departement)
    {
        if($departement->delete()){
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
