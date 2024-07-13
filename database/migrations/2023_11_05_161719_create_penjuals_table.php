<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('penjuals', function (Blueprint $table) {
            $table->string('id_penjual')->primary();
            $table->string('username');
            $table->string('name');
            $table->string('email');
            $table->string('no_telp');
            $table->char('jk');
            $table->string('password');         ;
            $table->string('profile_picture')->nullable();
            $table->date('tgl_lahir');
            $table->integer('saldo')->default(0);
            $table->boolean('premium_status')->default(false);
            $table->boolean('status')->default(true);
            $table->date('joined_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penjuals');
    }
};
