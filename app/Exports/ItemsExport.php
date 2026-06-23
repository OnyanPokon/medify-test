<?php

namespace App\Exports;

use App\Models\MasterItem;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ItemsExport implements FromCollection,  WithHeadings
{
   public function collection()
    {
        $data = MasterItem::with('categories')->get();

        return $data->values()->map(function ($item, $index) {
            return [
                $index + 1, 
                $item->kode,
                $item->nama,
                $item->harga_beli,
                $item->laba,
                $item->supplier,
                $item->jenis,
                $item->categories->pluck('nama')->implode(', '),
            ];
        });
    }

    public function headings(): array
    {
        return [
            'No',
            'Kode',
            'Nama',
            'Harga Beli',
            'Laba',
            'Supplier',
            'Jenis',
            'Kategori',
        ];
    }
}
