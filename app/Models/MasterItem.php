<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MasterItem extends Model
{
    protected $fillable = [
        'nama',
        'kode',
        'harga_beli',
        'laba',
        'supplier',
        'jenis',
        'foto_produk'
    ];

    public function categories()
    {
        return $this->belongsToMany(
            kategori::class,
            'produk_kategoris', // nama pivot table
            'item_id', // foreign key untuk model MasterItem di pivot table
            'category_id' // foreign key untuk model kategori di pivot table
        );
    }
}
