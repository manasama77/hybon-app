<?php

namespace App\Http\Controllers;

use App\Models\BarangJadi;
use Illuminate\Http\Request;

class BarangJadiController extends Controller
{
    public function index()
    {
        $page_title = "Barang Jadi";

        $datas = BarangJadi::latest()->get();

        $data = [
            'page_title' => $page_title,
            'datas'      => $datas,
        ];

        return view('pages.data-reference.barang-jadi.index', $data);
    }

    public function show($id)
    {
        $barang_jadi = BarangJadi::find($id);

        return response()->json($barang_jadi);
    }

    public function create()
    {
        $page_title = "Tambah Data Barang Jadi";

        $data = [
            'page_title' => $page_title,
        ];

        return view('pages.data-reference.barang-jadi.form', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'       => ['required', 'max:255', 'string', 'unique:' . BarangJadi::class],
            'harga_jual' => ['required'],
        ]);

        $data = [
            'name'       => $request->name,
            'harga_jual' => $request->harga_jual,
        ];

        BarangJadi::create($data);

        return redirect()->route('data-reference.barang-jadi')->with('success', 'Data created successfully.');
    }

    public function edit($id)
    {
        $page_title = "Edit Data Barang Jadi";

        $datas = BarangJadi::find($id);

        $data = [
            'page_title' => $page_title,
            'datas'      => $datas,
        ];

        return view('pages.data-reference.barang-jadi.form_edit', $data);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => ['required', 'max:255', 'string', 'unique:' . BarangJadi::class . ',name,' . $id],
            'harga_jual' => ['required'],
        ]);

        $motif             = BarangJadi::find($id);
        $motif->name       = $request->name;
        $motif->harga_jual = $request->harga_jual;
        $motif->save();

        return redirect()->route('data-reference.barang-jadi')->with('success', 'Data updated successfully.');
    }

    public function destroy($id)
    {
        $motif = BarangJadi::find($id);
        $motif->delete();

        return response()->json(['success' => true]);
    }
}
