<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BarangMasuk;
use App\Models\Barang;
use Illuminate\Support\Facades\Storage;

class BarangMasukController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $rsetBarangMasuk = BarangMasuk::with('barang')->latest()->paginate(10);

        return view('barangmasuk.index', compact('rsetBarangMasuk'))
            ->with('i', (request()->input('page', 1) - 1) * 10);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $barangId = Barang::all();
        return view('barangmasuk.create', compact('barangId'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'tgl_masuk' => 'required',
            'qty_masuk' => 'required',
            'barang_id' => 'required',
        ]);

        //create post
        BarangMasuk::create([
            'tgl_masuk' => $request->tgl_masuk,
            'qty_masuk' => $request->qty_masuk,
            'barang_id' => $request->barang_id,
        ]);

        //redirect to index with success message
        return redirect()->route('barang.index')->with(['success' => 'Stok Berhasil Bertambah!']);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $rsetBarangMasuk = BarangMasuk::find($id);
        return view('barangmasuk.show', compact('rsetBarangMasuk'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $rsetBarangMasuk = BarangMasuk::find($id);
        return view('barangmasuk.edit', compact('rsetBarangMasuk'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'tgl_masuk' => 'required',
            'qty_masuk' => 'required',
            'barang_id' => 'required',
        ]);

        $rsetBarangMasuk = BarangMasuk::find($id);
        $rsetBarangMasuk->update($request->all());

        //redirect to index with success message
        return redirect()->route('barangmasuk.index')->with(['success' => 'Data Berhasil Diubah']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $rsetBarangMasuk = BarangMasuk::find($id);

        //delete post
        $rsetBarangMasuk->delete();

        //redirect to index with success message
        return redirect()->route('barangmasuk.index')->with(['warning' => 'Data Berhasil Dihapus!']);
    }
}