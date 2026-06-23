<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class kategori extends Model
{
    protected $fillable = [
        'kode',
        'nama',

    ];

    public function products()
    {
        return $this->belongsToMany(
            MasterItem::class,
            'produk_kategoris', // nama tabel pivot
            'category_id', // foreign key untuk model kategori di tabel pivot
            'item_id'
        );
    }
}
