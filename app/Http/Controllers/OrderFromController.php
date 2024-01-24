<?php

namespace App\Http\Controllers;

use App\Models\OrderFrom;
use Illuminate\Http\Request;

class OrderFromController extends Controller
{
    public function index()
    {
        $page_title = "Order From";

        $datas = OrderFrom::orderBy('name', 'asc')->get();

        $data = [
            'page_title' => $page_title,
            'datas'      => $datas,
        ];

        return view('pages.data-reference.order-from.index', $data);
    }

    public function create()
    {
        $page_title = "Tambah Data Order From";

        $data = [
            'page_title' => $page_title,
        ];

        return view('pages.data-reference.order-from.form', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'max:255', 'string', 'unique:' . OrderFrom::class],
        ]);

        $data = [
            'name' => $request->name,
        ];

        OrderFrom::create($data);

        return redirect()->route('data-reference.order-from')->with('success', 'Data created successfully.');
    }

    public function edit($id)
    {
        $page_title = "Edit Data Order From";

        $datas = OrderFrom::find($id);

        $data = [
            'page_title' => $page_title,
            'datas'      => $datas,
        ];

        return view('pages.data-reference.order-from.form_edit', $data);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => ['required', 'max:255', 'string', 'unique:' . OrderFrom::class . ',name,' . $id],
        ]);

        $motif       = OrderFrom::find($id);
        $motif->name = $request->name;
        $motif->save();

        return redirect()->route('data-reference.order-from')->with('success', 'Data updated successfully.');
    }

    public function destroy($id)
    {
        $motif = OrderFrom::find($id);
        $motif->delete();

        return response()->json(['success' => true]);
    }
}
