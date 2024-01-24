<?php

namespace App\Http\Controllers;

use App\Models\MetodeMolding;
use App\Models\SubMolding;
use Exception;
use Illuminate\Http\Request;

class SubMoldingController extends Controller
{
    public function index()
    {
        $page_title = "Sub Molding";

        $datas = SubMolding::with('metode_molding')->orderBy('name', 'asc')->get();

        $data = [
            'page_title' => $page_title,
            'datas'      => $datas,
        ];

        return view('pages.data-reference.sub-molding.index', $data);
    }

    public function show($id)
    {
        try {
            $data = SubMolding::where('metode_molding_id', $id)->get();

            return response()->json(['success' => true, 'data' => $data, 'message' => "success"]);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'data' => [], 'message' => $e->getMessage()]);
        }
    }

    public function create()
    {
        $page_title = "Tambah Data Sub Molding";

        $metode_moldings = MetodeMolding::orderBy('name', 'asc')->get();

        $data = [
            'page_title'      => $page_title,
            'metode_moldings' => $metode_moldings,
        ];

        return view('pages.data-reference.sub-molding.form', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'metode_molding_id' => ['required', 'exists:' . MetodeMolding::class . ',id'],
            'name'              => ['required', 'max:255', 'string', 'unique:' . SubMolding::class],
        ]);

        $data = [
            'metode_molding_id' => $request->metode_molding_id,
            'name'              => $request->name,
        ];

        SubMolding::create($data);

        return redirect()->route('data-reference.sub-molding')->with('success', 'Data created successfully.');
    }

    public function edit($id)
    {
        $page_title = "Edit Data Sub Molding";

        $datas = SubMolding::find($id);
        $metode_moldings = MetodeMolding::orderBy('name', 'asc')->get();

        $data = [
            'page_title'      => $page_title,
            'datas'           => $datas,
            'metode_moldings' => $metode_moldings,
        ];

        return view('pages.data-reference.sub-molding.form_edit', $data);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => ['required', 'max:255', 'string', 'unique:' . SubMolding::class . ',name,' . $id],
        ]);

        $motif       = SubMolding::find($id);
        $motif->name = $request->name;
        $motif->save();

        return redirect()->route('data-reference.sub-molding')->with('success', 'Data updated successfully.');
    }

    public function destroy($id)
    {
        $motif = SubMolding::find($id);
        $motif->delete();

        return response()->json(['success' => true]);
    }
}
