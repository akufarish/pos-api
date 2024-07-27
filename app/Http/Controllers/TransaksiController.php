<?php

namespace App\Http\Controllers;

use App\Models\BarangTransaksi;
use App\Models\Keranjang;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;


class TransaksiController extends Controller
{
    function Store(Request $request) {

        $user = Auth::user();

        $payload = [
            "bayaran" => $request->bayaran,
            "transaksi_code" => Str::random(6),
            "user_id" => $user->id
        ];

        $transaksi = Transaksi::create($payload);

        $totalHarga = 0;

        foreach($request->barang as $barang) {
            $payload = [
                "transaksi_id" => $transaksi->id,
                "barang_id" => $barang["barang_id"],
                "keranjang_id" => $barang["keranjang_id"],
                "pcs" => $barang["pcs"]
            ];

            
            $barangTransaksi = BarangTransaksi::create($payload);
            $barangs = Keranjang::firstWhere("id", $barangTransaksi->keranjang_id);

            $barangs->is_done = 1;
            $barangs->save();
        }

        $barangTransaksi = BarangTransaksi::where("transaksi_id", $transaksi->id)->get();

        foreach($barangTransaksi as $barangTransaksis) {
            $totalHarga += $barangTransaksis->barang->harga_produk * $barangTransaksis->pcs;
        }

        $transaksi->total_harga = $totalHarga;
        $kembalian = $transaksi->bayaran - $transaksi->total_harga;
        $transaksi->kembalian = $kembalian;
        $transaksi->save();

        $data = Transaksi::firstWhere("id", $transaksi->id);
        
        return response()->json([
            'transaksi' => $data
        ], 201);
    }

    function Index() {
        $user = Auth::user();
        $transaksi = Transaksi::where("user_id", $user->id)->get();

        return response()->json([
            "transaksi" => $transaksi
        ], 200);
    }

    function Show(Transaksi $transaksi) {
        return response()->json([
            "data" => $transaksi
        ], 200);
    }

    
    function getLatest() {
        $user = Auth::user();

        $transaksi = Transaksi::firstWhere("user_id", $user->id)->latest()->first();

        return response()->json([
            "transaksi" => $transaksi
        ], 200);
    }
}
