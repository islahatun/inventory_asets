<?php

namespace App\Http\Controllers;

use App\Models\departement;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\DataTables;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = [
            'type_menu' => 'master',
            'menu'      => 'user',
            'form'      => 'Form User',
            'divisi'    => departement::all()
        ];
        return view('pages.user.index',$data);
    }

    public function getData(){
        $result  = User::with('departement')->get();

        return DataTables::of($result)->addIndexColumn()
        ->addColumn('role', function ($data) {
            if($data->role ==1){
                $return = 'User';
            }else if($data->role ==2){
                $return = 'Administrator';
            }else{
                $return = 'Pengawa';
            }
            return $return;
        })
        ->addColumn('departement', function ($data) {

            return $data->departement;
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
            'departement_id' => 'required',
            'email'=> 'required',
            'role'=> 'required',
        ]);


        $data['user_code'] = random_int(10000, 99999);
        $data['password'] = Hash::make('Password');

        $result = User::create($data);

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
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        // Validate the request data
        $request->validate([
            'departement_id' => 'required',
            'email'=> 'required',
            'role'=> 'required',
        ]);

        // Update the category with the new data
        $user = User::find($request->id);
        $user->departement_id = $request->departement_id;
        $user->email = $request->email;
        $user->role = $request->role;


        if($user->save()){
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
    public function destroy(User $user)
    {
        if($user->delete()){
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
