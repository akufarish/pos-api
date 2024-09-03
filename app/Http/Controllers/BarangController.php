<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BarangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Barang::all();

        return response()->json([
            "data" => $data
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
    public function store(Request $request)
    {

        $file = $request->file("image");

            $extension = $file->extension();
            $dir = "storage/barang/";
            $name = Str::random(32) . '.' . $extension;
            $foto = $dir . $name;

        $payload = [
            "nama_produk" => $request->nama_produk,
            "harga_produk" => $request->harga_produk,
            "pcs" => $request->pcs,
            "image" => $foto
        ];

        Barang::create($payload);

        $file->move($dir, $name);

        return response()->json([
            "barangs" => $payload
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = Barang::firstWhere("id", $id);

        return response()->json([
            "barang" => $data
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
