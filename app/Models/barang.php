<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class barang extends Model
{
    use HasFactory,SoftDeletes;
    protected $guarded =['id'];

    public function header_barang(){
        return $this->belongsTo(header_barang::class,'id_header','id');
    }

    public function barang_masuk(){
        return $this->hasMany(barang_masuk::class,'barang_id','id');
    }
    public function barang_keluar(){
        return $this->hasMany(barang_keluar::class,'barang_id','id');
    }
}
