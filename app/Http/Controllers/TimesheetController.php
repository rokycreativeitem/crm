<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Timesheet;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;

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

    public function exportFile(Request $request, $file, $code) {

        $query = Timesheet::query();
        $query->where('project_id', project_id_by_code($code));

        if (isset($request->customSearch)) {
            $string = $request->customSearch;
            $query->where(function ($q) use ($string) {
                $q->where('title', 'like', "%{$string}%");
            });
        }

        if ($request->start_date && $request->end_date) {
            $start_date     = date('Y-m-d H:i:s', strtotime($request->start_date));
            $end_date       = date('Y-m-d H:i:s', strtotime($request->end_date));
            $query->where(function ($q) use ($start_date, $end_date) {
                $q->where('timestamp_start', '>=', $start_date);
                $q->where('timestamp_end', '<=', $end_date);
            });
        }
        
        if ($request->user && $request->user != 'all') {
            $user = $request->user;
            $query->where(function ($q) use ($user) {
                $q->where('user_id', $user);
            });
        }

        $page_data['timesheets'] = count($request->all()) > 0 ? $query->get() : Timesheet::where('project_id', project_id_by_code($code))->get();

        if ($file == 'pdf') {
            $pdf = FacadePdf::loadView('projects.timesheet.pdf', $page_data);
            return $pdf->download('timesheet.pdf');
        }
        if ($file == 'print') {
            $pdf = FacadePdf::loadView('projects.timesheet.pdf', $page_data);
            return $pdf->stream('timesheet.pdf');
        }
    
        if ($file == 'csv') {
            $fileName = 'timesheet.csv';

            $headers = [
                "Content-type"        => "text/csv",
                "Content-Disposition" => "attachment; filename=$fileName",
                "Pragma"              => "no-cache",
                "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
                "Expires"             => "0"
            ];
    
            // Use the filtered query to get the projects for CSV
            $users = count($request->all()) > 0 ? $query->get() : User::where('project_id', project_id_by_code($code))->get();
    
            $columns = ['#', 'title', 'user', 'staff', 'start_date', 'end_date'];
            
            $callback = function() use ($columns, $users) {
                $file = fopen('php://output', 'w');
                fputcsv($file, $columns);
    
                $count = 1;
                foreach ($users as $item) {    
                    fputcsv($file, [
                        $count,
                        $item->title,
                        User::where('id', $item->user_id)->first()->name,
                        User::where('id', $item->staff)->first()->name,
                        date('d-M-y h:i A', strtotime($item->timestamp_start)),
                        date('d-M-y h:i A', strtotime($item->timestamp_end))
                    ]);
                    $count++;
                }
    
                fclose($file);
            };
    
            return response()->stream($callback, 200, $headers);
        }
    
        // If no valid file type was provided
        return response()->json(['error' => 'Invalid file type'], 400);
    }
}
