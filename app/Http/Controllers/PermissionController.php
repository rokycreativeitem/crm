<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PermissionController extends Controller
{
    public function index(Request $request)
    {

        $page_data['permissions'] = Permission::paginate(10);
        return view('permissions.index', $page_data);

    }
    public function create()
    {
        $data['permission'] = Permission::get();
        return view('permissions.create', $data);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'route' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'validationError' => $validator->getMessageBag()->toArray(),
            ]);
        }

        $data['title'] = $request->title;
        $data['route'] = $request->route;

        Permission::insert($data);
        return response()->json([
            'success' => 'Permission has been stored.',
        ]);
    }

    public function delete($id)
    {
        Permission::where('id', $id)->delete();
        return response()->json([
            'success' => 'Permission has been deleted.',
        ]);
    }

    public function edit(Request $request, $id)
    {

        $data['permission'] = Permission::where('id', $id)->first();
        return view('permissions.edit', $data);
    }
    public function update(Request $request, $id)
    {

        $data['title'] = $request->title;
        $data['route'] = $request->route;

        Permission::where('id', $request->id)->update($data);

        return response()->json([
            'success' => 'Permission has been updated.',
        ]);
    }

    public function multiDelete(Request $request)
    {
        $ids = $request->input('data');

        if (!empty($ids)) {
            Permission::whereIn('id', $ids)->delete();
            return response()->json(['success' => 'Permissions deleted successfully!']);
        }

        return response()->json(['error' => 'No Permissions selected for deletion.'], 400);
    }
}
