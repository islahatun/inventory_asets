<?php

namespace App\Http\Controllers;

use App\Models\barang;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(){
        $data = [
            'type_menu' => 'dashboard',
            'menu'      => 'Dashboard',
            'barang'    => barang::all()

        ];
        return view('pages.dashboard', $data);
    }
}
