<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\BarangKeluar;
use App\Models\BarangMasuk;
use App\Models\Kategori;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class BarangController extends Controller
{
    public function index()
    {
        $rsetBarang = Barang::all();
        return view('barang.index', compact('rsetBarang'));
    }

    public function create()
    {
        $rsetKategori = Kategori::all();
        return view('barang.create', compact('rsetKategori'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'merk' => 'required|string|max:50',
            'seri' => 'nullable|string|max:50',
            'spesifikasi' => 'nullable|string',
            'stok' => 'nullable|integer',
            'kategori_id' => 'required|exists:kategori,id',
        ]);

        if ($validator->fails()) {
            return redirect()->route('barang.create')
                ->withErrors($validator)
                ->withInput();
        }

        Barang::create([
            'merk' => $request->merk,
            'seri' => $request->seri,
            'spesifikasi' => $request->spesifikasi,
            'stok' => $request->stok,
            'kategori_id' => $request->kategori_id,
        ]);

        return redirect()->route('barang.index')->with(['success' => 'Data Barang Berhasil Disimpan!']);
    }

    public function show(string $id)
    {
        $rsetBarang = Barang::find($id);
        return view('barang.show', compact('rsetBarang'));
    }

    public function edit(string $id)
    {
        $rsetBarang = Barang::find($id);
        $rsetKategori = Kategori::all();
        return view('barang.edit', compact('rsetBarang', 'rsetKategori'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'merk' => 'required|string|max:50',
            'seri' => 'nullable|string|max:50',
            'spesifikasi' => 'nullable|string',
            'stok' => 'nullable|integer',
            'kategori_id' => 'required|exists:kategori,id',
        ]);

        if ($validator->fails()) {
            return redirect()->route('barang.edit', $id)
                ->withErrors($validator)
                ->withInput();
        }

        $barang = Barang::find($id);

        $barang->update([
            'merk' => $request->merk,
            'seri' => $request->seri,
            'spesifikasi' => $request->spesifikasi,
            'stok' => $request->stok,
            'kategori_id' => $request->kategori_id,
        ]);

        return redirect()->route('barang.index')->with(['success' => 'Data Barang Berhasil Diubah!']);
    }

    public function destroy(string $id)
    {
        if (DB::table('barangmasuk')->where('barang_id', $id)->exists() || DB::table('barangkeluar')->where('barang_id', $id)->exists()) {
            return redirect()->route('barang.index')->with(['Gagal' => 'Barang tidak dapat dihapus!']);
        } else {
            $rsetBarang = Barang::find($id);
            $rsetBarang->delete();
            return redirect()->route('barang.index')->with(['Success' => 'Barang berhasil dihapus!']);
        }
    }

    public function getCategories(): JsonResponse
    {
        $categories = Kategori::all(['id', 'deskripsi']);
        return response()->json($categories);
    }
}