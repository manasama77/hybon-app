<?php

namespace App\Http\Controllers;

use App\Models\TipeBarang;
use Illuminate\Http\Request;

class TipeBarangController extends Controller
{
    public function index()
    {
        $page_title = "Tipe Barang";

        $datas = TipeBarang::latest()->get();

        $data = [
            'page_title' => $page_title,
            'datas'      => $datas,
        ];

        return view('pages.data-reference.tipe-barang.index', $data);
    }

    public function create()
    {
        $page_title = "Tambah Data Tipe Barang";

        $data = [
            'page_title' => $page_title,
        ];

        return view('pages.data-reference.tipe-barang.form', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'max:255', 'string', 'unique:' . TipeBarang::class],
        ]);

        $data = [
            'name' => $request->name,
        ];

        TipeBarang::create($data);

        return redirect()->route('data-reference.tipe-barang')->with('success', 'Data created successfully.');
    }

    public function edit($id)
    {
        $page_title = "Edit Data Tipe Barang";

        $datas = TipeBarang::find($id);

        $data = [
            'page_title' => $page_title,
            'datas'      => $datas,
        ];

        return view('pages.data-reference.tipe-barang.form_edit', $data);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => ['required', 'max:255', 'string', 'unique:' . TipeBarang::class . ',name,' . $id],
        ]);

        $motif       = TipeBarang::find($id);
        $motif->name = $request->name;
        $motif->save();

        return redirect()->route('data-reference.tipe-barang')->with('success', 'Data updated successfully.');
    }

    public function destroy($id)
    {
        $motif = TipeBarang::find($id);
        $motif->delete();

        return response()->json(['success' => true]);
    }
}
