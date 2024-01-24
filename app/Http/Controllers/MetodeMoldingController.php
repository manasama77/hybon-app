<?php

namespace App\Http\Controllers;

use App\Models\MetodeMolding;
use Illuminate\Http\Request;

class MetodeMoldingController extends Controller
{
    public function index()
    {
        $page_title = "Metode Molding";

        $datas = MetodeMolding::orderBy('name', 'asc')->get();

        $data = [
            'page_title' => $page_title,
            'datas'      => $datas,
        ];

        return view('pages.data-reference.metode-molding.index', $data);
    }

    public function create()
    {
        $page_title = "Tambah Data Metode Molding";

        $data = [
            'page_title' => $page_title,
        ];

        return view('pages.data-reference.metode-molding.form', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'max:255', 'string', 'unique:' . MetodeMolding::class],
        ]);

        $data = [
            'name' => $request->name,
        ];

        MetodeMolding::create($data);

        return redirect()->route('data-reference.metode-molding')->with('success', 'Data created successfully.');
    }

    public function edit($id)
    {
        $page_title = "Edit Data Metode Molding";

        $datas = MetodeMolding::find($id);

        $data = [
            'page_title' => $page_title,
            'datas'      => $datas,
        ];

        return view('pages.data-reference.metode-molding.form_edit', $data);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => ['required', 'max:255', 'string', 'unique:' . MetodeMolding::class . ',name,' . $id],
        ]);

        $motif       = MetodeMolding::find($id);
        $motif->name = $request->name;
        $motif->save();

        return redirect()->route('data-reference.metode-molding')->with('success', 'Data updated successfully.');
    }

    public function destroy($id)
    {
        $motif = MetodeMolding::find($id);
        $motif->delete();

        return response()->json(['success' => true]);
    }
}
