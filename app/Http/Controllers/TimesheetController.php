<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Timesheet;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class TimesheetController extends Controller
{
    public function index(Request $request)
    {
        if($request->ajax()){
            return app(ServerSideDataController::class)->timesheet_server_side($request->project_id, $request->customSearch, $request->start_date, $request->end_date, $request->user);                
        }
        $page_data['timesheets'] = Timesheet::get();
        $page_data['users'] = User::get();
        return view('projects.timesheet.index', $page_data);
    }
    public function create()
    {
        $page_data['project_id'] = Project::where('code', request()->query('code'))->value('id');
        $page_data['user_id']    = get_current_user_role();
        $page_data['staffs'] = User::where('role_id', 3)->get();
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
        $data['staff']            = $request->staff;
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
        $page_data['staffs'] = User::where('role_id', 3)->get();
        $page_data['timesheet'] = Timesheet::where('id', $id)->first();
        return view('projects.timesheet.edit', $page_data);
    }

    public function update(Request $request, $id)
    {
        $data['title']           = $request->title;
        $data['staff']            = $request->staff;
        $data['timestamp_start'] = $request->timestamp_start;
        $data['timestamp_end']   = $request->timestamp_end;

        Timesheet::where('id', $id)->update($data);

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
