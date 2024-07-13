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
        Schema::create('pembelis', function (Blueprint $table) {
            $table->string('id_pembeli')->primary();
            $table->string('username');
            $table->string('name');
            $table->string('email');
            $table->string('no_telp');
            $table->char('jk');
            $table->string('password');         ;
            $table->integer('poin')->default(0);
            $table->string('profile_picture')->nullable();
            $table->date('tgl_lahir');
            $table->string('refferal');
            $table->boolean('status')->default(true);
            $table->date('joined_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembelis');
    }
};
