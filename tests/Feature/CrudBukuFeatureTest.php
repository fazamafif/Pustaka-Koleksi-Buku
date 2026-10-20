<?php

namespace Tests\Feature;

use App\Models\Buku;
use App\Models\Kategori;
use App\Models\Penerbit;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CrudBukuFeatureTest extends TestCase
{
    use RefreshDatabase;

    public function test_dashboard_renders_with_dynamic_data(): void
    {
        $kategori = Kategori::create(['nama_kategori' => 'Teknologi']);
        $penerbit = Penerbit::create(['nama_penerbit' => 'Informatika']);
        Buku::create([
            'judul' => 'Laravel Modern',
            'pengarang' => 'Taylor',
            'tahun_terbit' => 2024,
            'kategori_id' => $kategori->id,
            'penerbit_id' => $penerbit->id,
        ]);

        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee('Laravel Modern');
        $response->assertSee('Teknologi');
        $response->assertSee('Informatika');
    }

    public function test_buku_crud_lifecycle(): void
    {
        $kategori = Kategori::create(['nama_kategori' => 'Novel']);
        $penerbit = Penerbit::create(['nama_penerbit' => 'Bentang']);

        // Test create
        $response = $this->post(route('Buku.store'), [
            'judul' => 'Laskar Pelangi',
            'pengarang' => 'Andrea Hirata',
            'tahun_terbit' => 2005,
            'kategori_id' => $kategori->id,
            'penerbit_id' => $penerbit->id,
        ]);

        $response->assertRedirect(route('Buku.index'));
        $this->assertDatabaseHas('bukus', ['judul' => 'Laskar Pelangi']);

        $buku = Buku::where('judul', 'Laskar Pelangi')->first();

        // Test search
        $searchResponse = $this->get(route('Buku.index', ['q' => 'Pelangi']));
        $searchResponse->assertStatus(200);
        $searchResponse->assertSee('Laskar Pelangi');

        // Test update
        $updateResponse = $this->put(route('Buku.update', $buku->id), [
            'judul' => 'Laskar Pelangi Edisi Spesial',
            'pengarang' => 'Andrea Hirata',
            'tahun_terbit' => 2008,
            'kategori_id' => $kategori->id,
            'penerbit_id' => $penerbit->id,
        ]);
        $updateResponse->assertRedirect(route('Buku.index'));
        $this->assertDatabaseHas('bukus', ['judul' => 'Laskar Pelangi Edisi Spesial']);

        // Test delete
        $deleteResponse = $this->delete(route('Buku.destroy', $buku->id));
        $deleteResponse->assertRedirect(route('Buku.index'));
        $this->assertDatabaseMissing('bukus', ['id' => $buku->id]);
    }

    public function test_kategori_cannot_be_deleted_if_has_books(): void
    {
        $kategori = Kategori::create(['nama_kategori' => 'Sejarah']);
        $penerbit = Penerbit::create(['nama_penerbit' => 'Kompas']);
        Buku::create([
            'judul' => 'Nusantara',
            'pengarang' => 'Vlekke',
            'tahun_terbit' => 2020,
            'kategori_id' => $kategori->id,
            'penerbit_id' => $penerbit->id,
        ]);

        $response = $this->delete(route('Kategori.destroy', $kategori->id));
        $response->assertSessionHas('error');
        $this->assertDatabaseHas('kategoris', ['id' => $kategori->id]);
    }

    public function test_validation_year_digits_and_required_fields(): void
    {
        $response = $this->post(route('Buku.store'), [
            'judul' => '',
            'pengarang' => '',
            'tahun_terbit' => '24', // invalid year (not 4 digits)
            'kategori_id' => 9999, // non-existent
            'penerbit_id' => 9999,
        ]);

        $response->assertSessionHasErrors(['judul', 'pengarang', 'tahun_terbit', 'kategori_id', 'penerbit_id']);
    }
}
