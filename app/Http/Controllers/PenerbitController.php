<?php

namespace App\Http\Controllers;

use App\Models\Penerbit;
use Illuminate\Http\Request;

class PenerbitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Penerbit::withCount('bukus');

        if ($request->filled('q')) {
            $query->where('nama_penerbit', 'like', '%' . $request->q . '%');
        }

        $allPenerbit = $query->orderBy('nama_penerbit')->paginate(10)->withQueryString();

        return view('penerbit.index', compact('allPenerbit'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('penerbit.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama_penerbit' => 'required|max:100|unique:penerbits,nama_penerbit',
        ], [
            'nama_penerbit.required' => 'Nama penerbit wajib diisi.',
            'nama_penerbit.unique' => 'Nama penerbit sudah terdaftar.',
            'nama_penerbit.max' => 'Nama penerbit maksimal 100 karakter.',
        ]);

        Penerbit::create($validatedData);

        return redirect()->route('Penerbit.index')->with('success', 'Penerbit "' . $validatedData['nama_penerbit'] . '" berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Penerbit $Penerbit)
    {
        $penerbit = $Penerbit->load('bukus');
        return view('penerbit.show', compact('penerbit'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Penerbit $Penerbit)
    {
        $penerbit = $Penerbit;
        return view('penerbit.edit', compact('penerbit'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Penerbit $Penerbit)
    {
        $validatedData = $request->validate([
            'nama_penerbit' => 'required|max:100|unique:penerbits,nama_penerbit,' . $Penerbit->id,
        ], [
            'nama_penerbit.required' => 'Nama penerbit wajib diisi.',
            'nama_penerbit.unique' => 'Nama penerbit ini sudah ada.',
            'nama_penerbit.max' => 'Nama penerbit maksimal 100 karakter.',
        ]);

        $Penerbit->update($validatedData);

        return redirect()->route('Penerbit.index')->with('success', 'Penerbit berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Penerbit $Penerbit)
    {
        if ($Penerbit->bukus()->exists()) {
            return redirect()->route('Penerbit.index')->with('error', 'Penerbit "' . $Penerbit->nama_penerbit . '" tidak dapat dihapus karena masih memuat ' . $Penerbit->bukus()->count() . ' buku terhubung.');
        }

        $nama = $Penerbit->nama_penerbit;
        $Penerbit->delete();

        return redirect()->route('Penerbit.index')->with('success', 'Penerbit "' . $nama . '" berhasil dihapus.');
    }
}
