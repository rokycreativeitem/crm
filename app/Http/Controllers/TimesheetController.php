<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Timesheet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class TimesheetController extends Controller
{
    public function index()
    {
        $page_data['timesheets'] = Timesheet::paginate(10);
        return view('projects.timesheet.index', $page_data);
    }
    public function create()
    {
        $page_data['project_id'] = Project::where('code', request()->query('code'))->value('id');
        $page_data['user_id']    = get_current_user_role();
        return view('projects.timesheet.create', $page_data);
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

        $data['project_id']      = $request->project_id;
        $data['user_id']         = Auth::user()->id;
        $data['title']           = $request->title;
        $data['timestamp_start'] = $request->timestamp_start;
        $data['timestamp_end']   = $request->timestamp_end;

        Timesheet::insert($data);
        return response()->json([
            'success' => 'Timesheet has been stored.',
        ]);
    }

    public function delete($id)
    {
        Timesheet::where('id', $id)->delete();
        return response()->json([
            'success' => 'Timesheet has been deleted.',
        ]);
    }

    public function edit(Request $request, $id)
    {
        $data['timesheet'] = Timesheet::where('id', $id)->first();
        return view('projects.timesheet.edit', $data);
    }

    public function update(Request $request, $id)
    {
        $data['title']           = $request->title;
        $data['timestamp_start'] = $request->timestamp_start;
        $data['timestamp_end']   = $request->timestamp_end;

        Timesheet::where('id', $request->id)->update($data);

        return response()->json([
            'success' => 'Timesheet has been updated.',
        ]);
    }

    public function multiDelete(Request $request)
    {
        $ids = $request->input('data');

        if (!empty($ids)) {
            Timesheet::whereIn('id', $ids)->delete();
            return response()->json(['success' => 'Timesheets deleted successfully!']);
        }

        return response()->json(['error' => 'No timesheets selected for deletion.'], 400);
    }
}
