<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterPromo extends Model
{
    use HasFactory;

    protected $table = 'promos';

    public $timestamps = false;

    protected $fillable = [
        'id_penjual',
        'kode_promo',
        'nilai_promo',
        'tipe',
        'min_purchase',
        'status',
    ];
}
