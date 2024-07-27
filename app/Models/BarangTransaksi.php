<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BarangTransaksi extends Model
{
    use HasFactory;
    protected $table = 'barang_transaksis';
    protected $guarded = ["id"];

    protected $with = ["barang"];

    function barang() : BelongsTo {
        return $this->belongsTo(Barang::class, "barang_id");
    }
}
