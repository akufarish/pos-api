<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Keranjang extends Model
{
    use HasFactory;

    protected $table = "keranjangs";
    protected $guarded = ["id"];

    function barang() : BelongsTo {
        return $this->belongsTo(Barang::class, "produk_id");
    }
}
