<?php

namespace App\Http\Controllers;

use App\Models\File;
use App\Models\FileUploader;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

class FileController extends Controller
{
    public function index(Request $request)
    {

        $page_data['files'] = File::get();

        return view('projects.file.index', $page_data);

    }
    public function create()
    {

        $page_data['project_id'] = Project::where('code', request()->query('code'))->value('id');
        return view('projects.file.create', $page_data);
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'validationError' => $validator->getMessageBag()->toArray(),
            ]);
        }

        $file = $request->file('file');

        $data['project_id'] = $request->project_id;
        $data['user_id']    = Auth::user()->id;
        $data['title']      = $request->title;
        $data['extension']  = $file->getClientOriginalExtension();
        $data['size']       = round(($file->getSize() / 1048576), 2);
        $data['file']       = FileUploader::upload($file, 'project_file');

        File::insert($data);
        return response()->json([
            'success' => 'File has been stored.',
        ]);
    }

    public function delete($id)
    {
        $file_record = File::find($id);

        if (!$file_record) {
            return response()->json([
                'error' => 'File record not found.',
            ], 404);
        }
        $file_path = public_path($file_record->file);
        if (file_exists($file_path)) {
            unlink($file_path);
        }
        $file_record->delete();
        File::where('id', $id)->delete();

        return response()->json([
            'success' => 'File has been deleted.',
        ]);
    }

    public function edit(Request $request, $id)
    {

        $data['file'] = File::where('id', $id)->first();
        return view('projects.file.edit', $data);
    }
    public function update(Request $request, $id)
    {
        $file        = $request->file('file');
        $file_record = File::find($id);

        if (!$file_record) {
            return response()->json([
                'error' => 'File record not found.',
            ], 404);
        }

        $data['title'] = $request->title;

        if ($file) {
            $oldFilePath = public_path($file_record->file);

            if (file_exists($oldFilePath)) {
                unlink($oldFilePath);
            }

            $data['extension'] = $file->getClientOriginalExtension();
            $data['size']      = round(($file->getSize() / 1048576), 2);
            $data['file']      = FileUploader::upload($file, 'project_file');
        }

        $file_record->update($data);

        return response()->json([
            'success' => 'File has been updated.',
        ]);
    }

    public function multiDelete(Request $request)
    {
        $ids = $request->input('data');

        if (!empty($ids)) {
            File::whereIn('id', $ids)->delete();
            return response()->json(['success' => 'Files deleted successfully!']);
        }

        return response()->json(['error' => 'No files selected for deletion.'], 400);
    }

    public function download($id)
    {
        $file      = File::where('id', $id)->first();
        $file_path = public_path($file->file);

        return Response::download($file_path);
    }
}
