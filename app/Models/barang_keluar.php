<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class barang_keluar extends Model
{
    use HasFactory,SoftDeletes;
    protected $guarded = ['id'];

    public function master_barang(){
        return $this->belongsTo(barang::class,'barang_id','id');
    }
}
