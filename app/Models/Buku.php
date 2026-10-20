<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class Buku extends Model
{
    //
    protected $guarded = [];
    public function kategori(): belongsTo 
    {
        return  $this->belongsTo(Kategori::class);
    }
    
    public function penerbit(): belongsTo 
    {
        return  $this->belongsTo(Penerbit::class);
    }
    


    
}