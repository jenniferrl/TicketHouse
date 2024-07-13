<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class View extends Model
{ //untuk menyimpan data total view per harinya (laporan kunjungan admin)
    use HasFactory;
    public $timestamps = false;
    protected $guarded = [];
}
