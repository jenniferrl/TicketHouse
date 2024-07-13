<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Tiket extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function penjual(): BelongsTo
    {
        // fk di tabel tiket, primary key dari tabel asal tabel penjual
        return $this->belongsTo(Penjual::class, 'id_penjual', 'id_penjual');
    }

    public function pembelian(): HasMany
    {
        return $this->hasMany(Pembelian::class, 'id_tiket', 'id_tiket');// nama field fk tiket diikuti pk di tabel tiket 
    }
}

