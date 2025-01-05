<?php

namespace App\Http\Controllers;

use App\Models\FileUploader;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $page_data['users'] = User::get();
        if ($request->ajax()) {
            return app(ServerSideDataController::class)->user_server_side($request->customSearch, $request->name, $request->email);
        }

        return view('users.index', $page_data);
    }

    public function create()
    {
        $page_data['roles'] = Role::all();

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

        $data['user'] = User::where('id', $id)->first();
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
        if($file_record->photo) {
            $filePath = public_path($file_record->photo);
            if (file_exists($filePath)) {
                unlink($filePath);
            }
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

    public function manage_profile()
    {
        return view('profile.index');
    }
    public function manage_profile_update(Request $request)
    {
        if ($request->type == 'general') {
            $profile['name']      = $request->name;
            $profile['email']     = $request->email;
            $profile['facebook']  = $request->facebook;
            $profile['linkedin']  = $request->linkedin;
            $profile['twitter']  = $request->twitter;
            $profile['about']     = $request->about;
            $profile['skills']    = $request->skills;
            $profile['biography'] = $request->biography;

            $user = User::find(auth()->user()->id);

            if ($request->hasFile('photo')) {
                $file = $request->file('photo');

                if ($user->photo) {
                    $oldFilePath = public_path($user->photo);
                    if (file_exists($oldFilePath)) {
                        unlink($oldFilePath);
                    }
                }

                $profile['photo'] = FileUploader::upload($file, 'user_photos');
            }

            $user->update($profile);
        } else {
            $old_pass_check = Auth::attempt(['email' => auth()->user()->email, 'password' => $request->current_password]);

            if (!$old_pass_check) {
                return redirect()->back()->with('error', get_phrase('Current password wrong.'));
            }

            if ($request->new_password != $request->confirm_password) {
                return redirect()->back()->with('error', get_phrase('Confirm password not same.'));
            }

            $password = Hash::make($request->new_password);
            User::where('id', auth()->user()->id)->update(['password' => $password]);
        }
        return redirect()->back()->with('success', get_phrase('Your changes has been saved.'));

    }
}
