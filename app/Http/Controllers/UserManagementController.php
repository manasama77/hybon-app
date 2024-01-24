<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserManagementController extends Controller
{
    public function index()
    {
        $page_title = "User Management";

        $datas = User::orderBy('name', 'asc')->get();

        $data = [
            'page_title' => $page_title,
            'datas'      => $datas,
        ];

        return view('pages.user-management.index', $data);
    }

    public function create()
    {
        $page_title = "Tambah Data User";

        $data = [
            'page_title' => $page_title,
        ];

        return view('pages.user-management.form', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'     => ['required', 'max:255', 'string'],
            'username' => ['required', 'max:255', 'string', 'unique:' . User::class],
            'password' => ['required', 'max:255', 'string', 'min:8', 'confirmed'],
        ]);

        $data = [
            'name'     => $request->name,
            'username' => $request->username,
            'password' => $request->password,
        ];

        User::create($data);

        return redirect()->route('user-management')->with('success', 'Data created successfully.');
    }

    public function edit($id)
    {
        $page_title = "Edit Data User";

        $datas = User::find($id);

        $data = [
            'page_title' => $page_title,
            'data'       => $datas,
        ];

        return view('pages.user-management.form_edit', $data);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => ['required', 'max:255', 'string'],
        ]);

        $motif       = User::find($id);
        $motif->name = $request->name;
        $motif->save();

        return redirect()->route('user-management')->with('success', 'Data updated successfully.');
    }

    public function destroy($id)
    {
        $motif = User::find($id);
        $motif->delete();

        return response()->json(['success' => true]);
    }

    public function reset_password($id)
    {
        $page_title = "Reset Password User";

        $datas = User::find($id);

        $data = [
            'page_title' => $page_title,
            'data'       => $datas,
        ];

        return view('pages.user-management.reset_password', $data);
    }

    public function proses_reset_password(Request $request, $id)
    {
        $request->validate([
            'password' => ['required', 'max:255', 'string', 'min:8', 'confirmed'],
        ]);

        $motif           = User::find($id);
        $motif->password = $request->password;
        $motif->save();

        return redirect()->route('user-management')->with('success', 'Data updated successfully.');
    }
}
