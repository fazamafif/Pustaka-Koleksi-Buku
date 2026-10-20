<?php

namespace Database\Seeders;

use App\Models\Buku;
use App\Models\Kategori;
use App\Models\Penerbit;
use Illuminate\Database\Seeder;

class BukuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $books = [
            [
                'id' => 1,
                'judul_buku' => 'Laut Bercerita',
                'pengarang' => 'Leila S. Chudori',
                'tahun' => 2017,
                'penerbit' => 'Kepustakaan Populer Gramedia',
                'kategori' => 'Novel Sastra / Fiksi',
            ],
            [
                'id' => 2,
                'judul_buku' => 'Bumi Manusia',
                'pengarang' => 'Pramoedya Ananta Toer',
                'tahun' => 2005,
                'penerbit' => 'Lentera Dipantara',
                'kategori' => 'Novel Sejarah',
            ],
            [
                'id' => 3,
                'judul_buku' => 'Cantik Itu Luka',
                'pengarang' => 'Eka Kurniawan',
                'tahun' => 2002,
                'penerbit' => 'Gramedia Pustaka Utama',
                'kategori' => 'Novel Sastra / Fiksi',
            ],
            [
                'id' => 4,
                'judul_buku' => 'Filosfi Teras',
                'pengarang' => 'Henry Manampiring',
                'tahun' => 2018,
                'penerbit' => 'Kompas',
                'kategori' => 'Self-Improvement',
            ],
            [
                'id' => 5,
                'judul_buku' => 'You Do You: Discovering Life through Experiments & Self-Awareness',
                'pengarang' => 'Fellexandro Ruby',
                'tahun' => 2020,
                'penerbit' => 'Gramedia Pustaka Utama',
                'kategori' => 'Self-Improvement',
            ],
            [
                'id' => 6,
                'judul_buku' => 'Home Sweet Loan',
                'pengarang' => 'Almira Bastari',
                'tahun' => 2022,
                'penerbit' => 'Gramedia Pustaka Utama',
                'kategori' => 'Novel Metropop',
            ],
            [
                'id' => 7,
                'judul_buku' => 'Negeri 5 Menara',
                'pengarang' => 'A. Fuadi',
                'tahun' => 2009,
                'penerbit' => 'Gramedia Pustaka Utama',
                'kategori' => 'Novel Fiksi',
            ],
            [
                'id' => 8,
                'judul_buku' => 'Seorang Anak yang Bersembunyi di Balik Topeng Superhero',
                'pengarang' => 'dr. Andreas Kurniawan, Sp.KJ',
                'tahun' => 2024,
                'penerbit' => 'Gramedia Pustaka Utama',
                'kategori' => 'Self-Improvement',
            ],
        ];

        foreach ($books as $item) {
            $kategori = Kategori::firstOrCreate([
                'nama_kategori' => $item['kategori'],
            ]);

            $penerbit = Penerbit::firstOrCreate([
                'nama_penerbit' => $item['penerbit'],
            ]);

            Buku::updateOrCreate(
                ['id' => $item['id']],
                [
                    'judul' => $item['judul_buku'],
                    'pengarang' => $item['pengarang'],
                    'tahun_terbit' => $item['tahun'],
                    'kategori_id' => $kategori->id,
                    'penerbit_id' => $penerbit->id,
                ]
            );
        }
    }
}
