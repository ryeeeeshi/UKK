<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BarangKeluar;
use App\Models\Barang;
use Illuminate\Support\Facades\Storage;

class BarangKeluarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $rsetBarangKeluar = BarangKeluar::all();
        return view('barangkeluar.index',compact('rsetBarangKeluar'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $barangId = Barang::all();
        return view('barangkeluar.create',compact('barangId'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $request->validate([
            'tgl_keluar'    => 'required',
            'qty_keluar'    => 'required',
            'barang_id'     => 'required',
        ]);


        //create post
        BarangKeluar::create([
            'tgl_keluar'  => $request->tgl_keluar,
            'qty_keluar'  => $request->qty_keluar,
            'barang_id'   => $request->barang_id,
        ]);

        //redirect to index
        return redirect()->route('barang.index')->with(['success' => 'Stok Berhasil Berkurang']);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $rsetBarangKeluar = BarangKeluar::find($id);

        return view('barangkeluar.show', compact('rsetBarangKeluar'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $rsetBarangKeluar = BarangKeluar::find($id);
        return view('barangkeluar.edit', compact('rsetBarangKeluar'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
{
    $request->validate([
        'tgl_keluar' => 'required',
        'qty_keluar' => 'required',
        'barang_id' => 'required',
    ]);

    $rsetBarangKeluar = BarangKeluar::find($id);
    $rsetBarangKeluar->update($request->all());

    return redirect()->route('barangkeluar.index')->with(['success' => 'Data Berhasil Diubah!']);
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $rsetBarangKeluar = BarangKeluar::find($id);

        //delete post
        $rsetBarangKeluar->delete();

        //redirect to index barangkeluar
        return redirect()->route('barangkeluar.index')->with(['warning' => 'Data Berhasil Dihapus!']);
    }
}