<?php

namespace App\Http\Controllers;

use App\Models\Motif;
use Illuminate\Http\Request;

class MotifController extends Controller
{
    public function index()
    {
        $page_title = "Motif";

        $datas = Motif::latest()->get();

        $data = [
            'page_title' => $page_title,
            'datas'      => $datas,
        ];

        return view('pages.data-reference.motif.index', $data);
    }

    public function create()
    {
        $page_title = "Tambah Data Motif";

        $data = [
            'page_title' => $page_title,
        ];

        return view('pages.data-reference.motif.form', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'max:255', 'string', 'unique:' . Motif::class],
        ]);

        $data = [
            'name' => $request->name,
        ];

        Motif::create($data);

        return redirect()->route('data-reference.motif')->with('success', 'Data created successfully.');
    }

    public function edit($id)
    {
        $page_title = "Edit Data Motif";

        $datas = Motif::find($id);

        $data = [
            'page_title' => $page_title,
            'datas'      => $datas,
        ];

        return view('pages.data-reference.motif.form_edit', $data);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => ['required', 'max:255', 'string', 'unique:' . Motif::class . ',name,' . $id],
        ]);

        $motif       = Motif::find($id);
        $motif->name = $request->name;
        $motif->save();

        return redirect()->route('data-reference.motif')->with('success', 'Data updated successfully.');
    }

    public function destroy($id)
    {
        $motif = Motif::find($id);
        $motif->delete();

        return response()->json(['success' => true]);
    }
}
