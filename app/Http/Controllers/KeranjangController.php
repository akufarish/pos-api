<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Keranjang;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KeranjangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $keranjang = Keranjang::with("barang")->where("is_done", 0)->get();

        $totalHarga = 0;

        foreach ($keranjang as $data) {
            $totalHarga += $data->barang->harga_produk * $data->pcs;
        }
        return response()->json([
            "data" => $keranjang ,
            "total_harga" => $totalHarga
        ], 200);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(string $id, Request $request)
    {
        $keranjang = Keranjang::firstWhere("produk_id", $id);
        
        if ($keranjang) {
            if ($keranjang->is_done == 0) {
                $keranjang->pcs = $keranjang->pcs + $request->pcs;
                $keranjang->save();
                
                return response()->json([
                    "data" => $keranjang
                ], 200);
            } else {
                $user = Auth::user();

                $payload = [
                    "produk_id" => $id,
                    "pcs" => $request->pcs,
                    "user_id" => $user->id
                ];
    
                $keranjang = Keranjang::create($payload);
    
                return response()->json([
                    "keranjang" => $keranjang
                ], 201);
            }
        } else {
            $user = Auth::user();

            $payload = [
                "produk_id" => $id,
                "pcs" => $request->pcs,
                "user_id" => $user->id
            ];

            $keranjang = Keranjang::create($payload);

            return response()->json([
                "keranjang" => $keranjang
            ], 201);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Keranjang $keranjang)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Keranjang $keranjang)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Keranjang $keranjang)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Keranjang $keranjang)
    {
        //
    }

}
