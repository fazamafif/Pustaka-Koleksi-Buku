<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Kategori::withCount('bukus');

        if ($request->filled('q')) {
            $query->where('nama_kategori', 'like', '%' . $request->q . '%');
        }

        $allKategori = $query->orderBy('nama_kategori')->paginate(10)->withQueryString();

        return view('kategori.index', compact('allKategori'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('kategori.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama_kategori' => 'required|max:100|unique:kategoris,nama_kategori',
        ], [
            'nama_kategori.required' => 'Nama kategori wajib diisi.',
            'nama_kategori.unique' => 'Nama kategori sudah terdaftar.',
            'nama_kategori.max' => 'Nama kategori maksimal 100 karakter.',
        ]);

        Kategori::create($validatedData);

        return redirect()->route('Kategori.index')->with('success', 'Kategori "' . $validatedData['nama_kategori'] . '" berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Kategori $Kategori)
    {
        $kategori = $Kategori->load('bukus');
        return view('kategori.show', compact('kategori'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Kategori $Kategori)
    {
        $kategori = $Kategori;
        return view('kategori.edit', compact('kategori'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Kategori $Kategori)
    {
        $validatedData = $request->validate([
            'nama_kategori' => 'required|max:100|unique:kategoris,nama_kategori,' . $Kategori->id,
        ], [
            'nama_kategori.required' => 'Nama kategori wajib diisi.',
            'nama_kategori.unique' => 'Nama kategori ini sudah ada.',
            'nama_kategori.max' => 'Nama kategori maksimal 100 karakter.',
        ]);

        $Kategori->update($validatedData);

        return redirect()->route('Kategori.index')->with('success', 'Kategori berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Kategori $Kategori)
    {
        if ($Kategori->bukus()->exists()) {
            return redirect()->route('Kategori.index')->with('error', 'Kategori "' . $Kategori->nama_kategori . '" tidak dapat dihapus karena masih memuat ' . $Kategori->bukus()->count() . ' buku terhubung.');
        }

        $nama = $Kategori->nama_kategori;
        $Kategori->delete();

        return redirect()->route('Kategori.index')->with('success', 'Kategori "' . $nama . '" berhasil dihapus.');
    }
}
