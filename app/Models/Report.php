<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Report extends Model
{
    use HasFactory;
    use SoftDeletes;
    public $timestamps = false;
    protected $guarded = [];

    public function penjual(): BelongsTo
    {
        // fk di tabel tiket, primary key dari tabel asal tabel penjual
        return $this->belongsTo(Penjual::class, 'id_penjual', 'id_penjual');
    }

    public function pembeli(): BelongsTo
    {
        // fk di tabel tiket, primary key dari tabel asal tabel penjual
        return $this->belongsTo(Pembeli::class, 'id_pembeli', 'id_pembeli');
    }
}
