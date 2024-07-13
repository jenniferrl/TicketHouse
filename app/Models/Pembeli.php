<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Pembeli extends Authenticatable
{   
    use HasFactory;
    
    public $timestamps = false; //kalo gaada ini otomatis dibuatkan createdAt dan updatedAt
    protected $guarded = [];
    
}
