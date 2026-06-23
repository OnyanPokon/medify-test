<?php

namespace App\Http\Controllers;

use App\Models\kategori;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    public function index()
    {
        return view('kategoris.index.index');
    }

    public function search(Request $request)
    {
        $data_search = kategori::query();

        if ($request->filled('kode')) {
            $data_search->where('kode', $request->kode);
        }

        if ($request->filled('nama')) {
            $data_search->where('nama', 'LIKE', '%' . $request->nama . '%');
        }

        $data = $data_search
            ->select(
                'kode',
                'nama'
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
        if ($method == 'new') {
            $item = [];
        } else {
            $item = kategori::find($id);
        }
        $data['item'] = $item;
        $data['method'] = $method;
        return view('kategoris.form.index', $data);
    }

    public function singleView($kode)
    {
        $data['data'] = Kategori::with('products')
            ->where('kode', $kode)
            ->firstOrFail();

        return view('kategoris.single.index', $data);
    }

    public function formSubmit(Request $request, $method, $id = 0)
    {
        if ($method == 'new') {
            $data_item = new kategori;
            $kode = kategori::count('id');
            $kode = $kode + 1;
            $kode = str_pad($kode, 5, '0', STR_PAD_LEFT);
            sleep(3);
        } else {
            $data_item = kategori::find($id);
            $kode = $data_item->kode;
        }

        $request->validate([
            'nama' => 'required|string|max:255',
        ]);

        $data_item->nama = $request->nama;
        $data_item->kode = $kode;

        $data_item->save();

        return redirect('kategoris');
    }

    public function delete($id)
    {
        kategori::find($id)->delete();
        return redirect('kategoris');
    }

    public function exportPdf($kode)
    {
        $kategori = Kategori::with('products')
            ->where('kode', $kode)
            ->firstOrFail();

        $pdf = Pdf::loadView('kategoris.doc.printPdfTemplate', [
            'kategori' => $kategori
        ]);

        return $pdf->download('kategori-' . $kategori->kode . '.pdf');
    }
}
