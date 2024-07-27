<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Transaksi extends Model
{
    use HasFactory;
    protected $table = "transaksis";
    protected $guarded = ["id"];

    protected $with = ["barang"];

    function barang() : HasMany {
        return $this->hasMany(BarangTransaksi::class, "transaksi_id");
    }
}
