<?php

namespace App\Http\Controllers;

use App\Exports\ItemsExport;
use App\Models\kategori;
use App\Models\MasterItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class MasterItemsController extends Controller
{
    public function index()
    {
        return view('master_items.index.index');
    }

    public function search(Request $request)
    {
        $data_search = MasterItem::query();

        if ($request->filled('kode')) {
            $data_search->where('kode', $request->kode);
        }

        if ($request->filled('nama')) {
            $data_search->where('nama', 'LIKE', '%' . $request->nama . '%');
        }

        if ($request->filled('hargamin')) {
            $data_search->where('harga_beli', '>=', $request->hargamin);
        }

        if ($request->filled('hargamax')) {
            $data_search->where('harga_beli', '<=', $request->hargamax);
        }

        $data = $data_search
            ->select(
                'kode',
                'nama',
                'jenis',
                'harga_beli',
                'laba',
                'supplier',
                'foto_produk'
            )
            ->orderBy('id')
            ->get();

        return response()->json([
            'status' => 200,
            'data' => $data
        ]);
    }

    public function formView($method, $id = 0)
    {
        $categories = kategori::all();

        if ($method == 'new') {
            $item = new MasterItem();
        } else {
            $item = MasterItem::with('categories')->findOrFail($id);
        }

        return view('master_items.form.index', [
            'item' => $item,
            'method' => $method,
            'categories' => $categories
        ]);
    }

    public function singleView($kode)
    {
        $data['data'] = MasterItem::with('categories')
            ->where('kode', $kode)
            ->firstOrFail();

        return view('master_items.single.index', $data);
    }
    public function formSubmit(Request $request, $method, $id = 0)
    {
        if ($method == 'new') {
            $data_item = new MasterItem;
            $kode = MasterItem::count('id');
            $kode = $kode + 1;
            $kode = str_pad($kode, 5, '0', STR_PAD_LEFT);
            sleep(3);
        } else {
            $data_item = MasterItem::find($id);
            $kode = $data_item->kode;
        }

        $request->validate([
            'nama' => 'required|string|max:255',
            'harga_beli' => 'required|numeric|min:0',
            'laba' => 'required|numeric|min:0|max:100',
            'supplier' => 'required|string|max:255',
            'categories' => 'required|array',
            'jenis' => 'required|string|max:255',
            'foto_produk' => $method == 'new'
                ? 'required|image|mimes:jpg,jpeg,png,webp|max:2048'
                : 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048'
        ]);

        DB::beginTransaction();

        $data_item->nama = $request->nama;
        $data_item->harga_beli = $request->harga_beli;
        $data_item->laba = $request->laba;
        $data_item->kode = $kode;
        $data_item->supplier = $request->supplier;
        $data_item->jenis = $request->jenis;
        if ($request->hasFile('foto_produk')) {

            $path = $request->file('foto_produk')
                ->store('produk', 'public');

            $data_item->foto_produk = $path;
        }
        $data_item->save();

        $data_item->categories()->sync($request->categories);

        DB::commit();

        return redirect('master-items');
    }

    public function delete($id)
    {
        MasterItem::find($id)->delete();
        return redirect('master-items');
    }

    public function updateRandomData()
    {
        $data = MasterItem::get();
        foreach ($data as $item) {
            $kode = $item->id;
            $kode = str_pad($kode, 5, '0', STR_PAD_LEFT);

            $item->harga_beli = rand(100, 1000000);
            $item->laba = rand(10, 99);
            $item->kode = $kode;
            $item->supplier = $this->getRandomSupplier();
            $item->jenis = $this->getRandomJenis();
            $item->save();
        }
    }

    private function getRandomSupplier()
    {
        $array = ['Tokopaedi', 'Bukulapuk', 'TokoBagas', 'E Commurz', 'Blublu'];
        $random = rand(0, 4);
        return $array[$random];
    }

    private function getRandomJenis()
    {
        $array = ['Obat', 'Alkes', 'Matkes', 'Umum', 'ATK'];
        $random = rand(0, 4);
        return $array[$random];
    }

    public function exportExcel()
    {
        return Excel::download(new ItemsExport, 'master-items.xlsx');
    }
}
