<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class pengajuan extends Model
{
    use HasFactory;
    protected $guarded =['id'];

    public function barang(){
        return $this->belongsTo(barang::class,'id_barang','id');
    }

    public function user(){
        return $this->belongsTo(user::class,'user_id','id');
    }
}
