<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Penerbit;
use App\Models\Kategori;
use Illuminate\Http\Request;

class BukuController extends Controller
{
    /**
     * Display a listing of the resource with eager loading, search, and pagination.
     */
    // Existing index method remains unchanged

    /**
     * Display a collection of popular books in Indonesia.
     */
    public function popular()
    {
        // Assuming popularity is determined by recent addition or a 'popularity' field.
        // For now, we fetch the latest 10 books with their category and publisher.
        $books = Buku::with(['kategori', 'penerbit'])
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        return view('buku.popular', compact('books'));
    }
    public function index(Request $request)
    {
        $query = Buku::with(['kategori', 'penerbit']);

        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function ($sub) use ($q) {
                $sub->where('judul', 'like', "%{$q}%")
                    ->orWhere('pengarang', 'like', "%{$q}%");
            });
        }

        if ($request->filled('kategori_id')) {
            $query->where('kategori_id', $request->kategori_id);
        }

        $allBuku = $query->latest()->paginate(10)->withQueryString();
        $kategoris = Kategori::all();

        return view('buku.index', compact('allBuku', 'kategoris'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $penerbit = Penerbit::orderBy('nama_penerbit')->get();
        $kategori = Kategori::orderBy('nama_kategori')->get();

        return view('buku.create', compact('penerbit', 'kategori'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'judul' => 'required|max:200',
            'pengarang' => 'required|max:100',
            'tahun_terbit' => 'required|digits:4|integer|min:1800|max:' . (date('Y') + 1),
            'kategori_id' => 'required|exists:kategoris,id',
            'penerbit_id' => 'required|exists:penerbits,id',
        ], [
            'judul.required' => 'Judul buku wajib diisi.',
            'pengarang.required' => 'Nama pengarang wajib diisi.',
            'tahun_terbit.required' => 'Tahun terbit wajib diisi.',
            'tahun_terbit.digits' => 'Tahun terbit harus 4 digit tahun (contoh: 2024).',
            'kategori_id.required' => 'Silakan pilih kategori buku.',
            'kategori_id.exists' => 'Kategori yang dipilih tidak valid.',
            'penerbit_id.required' => 'Silakan pilih penerbit buku.',
            'penerbit_id.exists' => 'Penerbit yang dipilih tidak valid.',
        ]);

        Buku::create($validatedData);

        return redirect()->route('Buku.index')->with('success', 'Buku "' . $validatedData['judul'] . '" berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Buku $Buku)
    {
        $buku = $Buku->load(['kategori', 'penerbit']);
        return view('buku.show', compact('buku'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Buku $Buku)
    {
        $buku = $Buku;
        $penerbit = Penerbit::orderBy('nama_penerbit')->get();
        $kategori = Kategori::orderBy('nama_kategori')->get();

        return view('buku.edit', compact('buku', 'penerbit', 'kategori'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Buku $Buku)
    {
        $validatedData = $request->validate([
            'judul' => 'required|max:200',
            'pengarang' => 'required|max:100',
            'tahun_terbit' => 'required|digits:4|integer|min:1800|max:' . (date('Y') + 1),
            'kategori_id' => 'required|exists:kategoris,id',
            'penerbit_id' => 'required|exists:penerbits,id',
        ], [
            'judul.required' => 'Judul buku wajib diisi.',
            'pengarang.required' => 'Nama pengarang wajib diisi.',
            'tahun_terbit.required' => 'Tahun terbit wajib diisi.',
            'tahun_terbit.digits' => 'Tahun terbit harus 4 digit tahun (contoh: 2024).',
            'kategori_id.required' => 'Silakan pilih kategori buku.',
            'kategori_id.exists' => 'Kategori yang dipilih tidak valid.',
            'penerbit_id.required' => 'Silakan pilih penerbit buku.',
            'penerbit_id.exists' => 'Penerbit yang dipilih tidak valid.',
        ]);

        $Buku->update($validatedData);

        return redirect()->route('Buku.index')->with('success', 'Data buku "' . $Buku->judul . '" berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Buku $Buku)
    {
        $judul = $Buku->judul;
        $Buku->delete();

        return redirect()->route('Buku.index')->with('success', 'Buku "' . $judul . '" berhasil dihapus.');
    }
}
