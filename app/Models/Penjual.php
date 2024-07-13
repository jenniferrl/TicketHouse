<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
class Penjual extends Authenticatable
{
    use HasFactory;
    public $timestamps = false;
    protected $guarded = [];

    //model relationship
    public function tiket(): HasMany
    {
        return $this->hasMany(Tiket::class, 'id_penjual', 'id_penjual');// nama field fk di tabel tiket, nama field local di tabel penjual
    }
}
