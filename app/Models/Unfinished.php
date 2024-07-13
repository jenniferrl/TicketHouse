<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unfinished extends Model
{
    use HasFactory; //untuk menyimpan transaksi yang belum selesai dibayar
    protected $guarded = [];
    public $timestamps = false;

}
