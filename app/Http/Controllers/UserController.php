<?php

namespace App\Http\Controllers;

use App\Models\FileUploader;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index()
    {
        $page_data = User::get();
        return view('users.index', $page_data);
    }

    public function create()
    {
        $page_data['role_id'] = request()->query('id');
        return view('users.create', $page_data);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'validationError' => $validator->getMessageBag()->toArray(),
            ]);
        }
        $file             = $request->file('photo');
        $data['role_id']  = $request->role_id;
        $data['name']     = $request->name;
        $data['email']    = $request->email;
        $data['password'] = Hash::make($request->password);
        $data['photo']    = FileUploader::upload($file, 'user_photos');

        User::insert($data);
        return response()->json([
            'success' => 'User has been stored.',
        ]);
    }

    public function edit(Request $request, $id)
    {
        $data['user']  = User::where('id', $id)->first();
        $data['roles'] = Role::get();
        return view('users.edit', $data);
    }

    public function update(Request $request, $id)
    {
        $file_record = User::find($id);

        if (!$file_record) {
            return response()->json([
                'error' => 'User record not found.',
            ], 404);
        }

        $file          = $request->file('photo');
        $data['name']  = $request->name;
        $data['email'] = $request->email;
        if ($file) {
            $oldFilePath = public_path($file_record->photo);
            if (file_exists($oldFilePath)) {
                unlink($oldFilePath);
            }
            $data['photo'] = FileUploader::upload($file, 'user_photos');
        }

        $file_record->update($data);
        return response()->json([
            'success' => 'User has been updated.',
        ]);
    }

    public function delete($id)
    {
        $file_record = User::find($id);

        if (!$file_record) {
            return response()->json([
                'error' => 'User record not found.',
            ], 404);
        }

        $filePath = public_path($file_record->photo);
        if (file_exists($filePath)) {
            unlink($filePath);
        }
        $file_record->delete();

        User::where('id', $id)->delete();
        return response()->json([
            'success' => 'User has been deleted.',
        ]);
    }

    public function multiDelete(Request $request)
    {
        $ids = $request->input('data');

        if (!empty($ids)) {
            User::whereIn('id', $ids)->delete();
            return response()->json(['success' => 'Users deleted successfully!']);
        }

        return response()->json(['error' => 'No users selected for deletion.'], 400);
    }
}
