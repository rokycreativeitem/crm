<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RoleController extends Controller
{
    public function index()
    {
        $page_data['roles'] = Role::paginate(15);
        return view('roles.index', $page_data);
    }

    public function create()
    {
        return view('roles.create');
    }

    public function store(Request $request)
    {
        $role['title'] = $request->title;

        Role::insert($role);
        return response()->json([
            'success' => 'Product has been updated.',
        ]);
    }

    public function edit($id)
    {
        $page_data['role'] = Role::find($id);
        return view('roles.edit', $page_data);
    }

    public function update(Request $request, $id)
    {
        $role['title'] = $request->title;

        $validator = Validator::make($role, [
            'title' => 'required|string|max:255|unique:roles,title,' . $id,
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }

        Role::find($id)->update($role);
        return redirect()->back()->with('success', get_phrase('Role has been updated.'));
    }

    public function delete($id)
    {
        Role::find($id)->delete();
        return redirect()->back()->with('success', get_phrase('Role has been deleted.'));
    }
}
