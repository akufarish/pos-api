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
        Schema::create('barang_transaksis', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("transaksi_id");
            $table->unsignedBigInteger("barang_id");
            $table->unsignedBigInteger("keranjang_id");
            $table->bigInteger("pcs");
            $table->timestamps();

            $table->foreign("transaksi_id")->references("id")->on("transaksis");
            $table->foreign("barang_id")->references("id")->on("barangs");
            $table->foreign("keranjang_id")->references("id")->on("keranjangs");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('barang_transaksis');
    }
};
