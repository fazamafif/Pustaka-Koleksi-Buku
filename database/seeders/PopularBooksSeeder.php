<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kategori;
use App\Models\Penerbit;
use App\Models\Buku;

class PopularBooksSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Kategori Populer di Indonesia
        $kategoriList = [
            'Self Improvement & Pengembangan Diri',
            'Fiksi & Sastra',
            'Finansial & Bisnis',
            'Filsafat & Psikologi',
            'Religi & Spiritual',
            'Misteri & Thriller',
            'Komik & Grafis',
        ];

        $kategoriMap = [];
        foreach ($kategoriList as $namaKat) {
            $kat = Kategori::firstOrCreate(['nama_kategori' => $namaKat]);
            $kategoriMap[$namaKat] = $kat->id;
        }

        // 2. Penerbit Terkemuka di Indonesia
        $penerbitList = [
            'Gramedia Pustaka Utama',
            'Kepustakaan Populer Gramedia (KPG)',
            'Mizan Pustaka',
            'Bentang Pustaka',
            'Republika Penerbit',
            'Noura Books',
            'Elex Media Komputindo',
            'Bumi Aksara',
            'Haru Media',
            'Grasindo',
        ];

        $penerbitMap = [];
        foreach ($penerbitList as $namaPen) {
            $pen = Penerbit::firstOrCreate(['nama_penerbit' => $namaPen]);
            $penerbitMap[$namaPen] = $pen->id;
        }

        // 3. Koleksi Buku Populer & Best Seller di Indonesia
        $bukuData = [
            [
                'judul' => 'Filosofi Teras',
                'pengarang' => 'Henry Manampiring',
                'tahun_terbit' => 2018,
                'kategori' => 'Filsafat & Psikologi',
                'penerbit' => 'Kepustakaan Populer Gramedia (KPG)',
            ],
            [
                'judul' => 'Atomic Habits (Edisi Bahasa Indonesia)',
                'pengarang' => 'James Clear',
                'tahun_terbit' => 2019,
                'kategori' => 'Self Improvement & Pengembangan Diri',
                'penerbit' => 'Gramedia Pustaka Utama',
            ],
            [
                'judul' => 'The Psychology of Money (Edisi Bahasa Indonesia)',
                'pengarang' => 'Morgan Housel',
                'tahun_terbit' => 2021,
                'kategori' => 'Finansial & Bisnis',
                'penerbit' => 'Gramedia Pustaka Utama',
            ],
            [
                'judul' => 'Bumi',
                'pengarang' => 'Tere Liye',
                'tahun_terbit' => 2014,
                'kategori' => 'Fiksi & Sastra',
                'penerbit' => 'Gramedia Pustaka Utama',
            ],
            [
                'judul' => 'Hujan',
                'pengarang' => 'Tere Liye',
                'tahun_terbit' => 2016,
                'kategori' => 'Fiksi & Sastra',
                'penerbit' => 'Gramedia Pustaka Utama',
            ],
            [
                'judul' => 'Cantik Itu Luka',
                'pengarang' => 'Eka Kurniawan',
                'tahun_terbit' => 2002,
                'kategori' => 'Fiksi & Sastra',
                'penerbit' => 'Gramedia Pustaka Utama',
            ],
            [
                'judul' => 'Laut Bercerita',
                'pengarang' => 'Leila S. Chudori',
                'tahun_terbit' => 2017,
                'kategori' => 'Fiksi & Sastra',
                'penerbit' => 'Kepustakaan Populer Gramedia (KPG)',
            ],
            [
                'judul' => 'Gadis Kretek',
                'pengarang' => 'Ratih Kumala',
                'tahun_terbit' => 2012,
                'kategori' => 'Fiksi & Sastra',
                'penerbit' => 'Gramedia Pustaka Utama',
            ],
            [
                'judul' => 'Laskar Pelangi',
                'pengarang' => 'Andrea Hirata',
                'tahun_terbit' => 2005,
                'kategori' => 'Fiksi & Sastra',
                'penerbit' => 'Bentang Pustaka',
            ],
            [
                'judul' => 'Bumi Manusia',
                'pengarang' => 'Pramoedya Ananta Toer',
                'tahun_terbit' => 1980,
                'kategori' => 'Fiksi & Sastra',
                'penerbit' => 'Bentang Pustaka',
            ],
            [
                'judul' => 'Bicara Itu Ada Seninya',
                'pengarang' => 'Oh Su Hyang',
                'tahun_terbit' => 2018,
                'kategori' => 'Self Improvement & Pengembangan Diri',
                'penerbit' => 'Bhuana Ilmu Populer',
            ],
            [
                'judul' => 'Berani Tidak Disukai',
                'pengarang' => 'Ichiro Kishimi & Fumitake Koga',
                'tahun_terbit' => 2019,
                'kategori' => 'Filsafat & Psikologi',
                'penerbit' => 'Gramedia Pustaka Utama',
            ],
            [
                'judul' => 'Negeri 5 Menara',
                'pengarang' => 'Ahmad Fuadi',
                'tahun_terbit' => 2009,
                'kategori' => 'Fiksi & Sastra',
                'penerbit' => 'Gramedia Pustaka Utama',
            ],
            [
                'judul' => 'Ayat-Ayat Cinta',
                'pengarang' => 'Habiburrahman El Shirazy',
                'tahun_terbit' => 2004,
                'kategori' => 'Religi & Spiritual',
                'penerbit' => 'Republika Penerbit',
            ],
            [
                'judul' => 'Teka-Teki Rumah Aneh (Hen na Ie)',
                'pengarang' => 'Uketsu',
                'tahun_terbit' => 2023,
                'kategori' => 'Misteri & Thriller',
                'penerbit' => 'Gramedia Pustaka Utama',
            ]
        ];

        foreach ($bukuData as $item) {
            // Cek jika penerbit belum ada dalam peta
            if (!isset($penerbitMap[$item['penerbit']])) {
                $p = Penerbit::firstOrCreate(['nama_penerbit' => $item['penerbit']]);
                $penerbitMap[$item['penerbit']] = $p->id;
            }

            Buku::firstOrCreate(
                [
                    'judul' => $item['judul'],
                ],
                [
                    'pengarang' => $item['pengarang'],
                    'tahun_terbit' => $item['tahun_terbit'],
                    'kategori_id' => $kategoriMap[$item['kategori']],
                    'penerbit_id' => $penerbitMap[$item['penerbit']],
                ]
            );
        }
    }
}
