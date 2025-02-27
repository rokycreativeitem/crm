<?php

namespace App\Http\Controllers;

use App\Models\Meeting;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;


class MeetingController extends Controller
{
    public function __construct()
    {
        date_default_timezone_set('Asia/Dhaka');
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            return app(ServerSideDataController::class)->meeting_server_side($request->project_id, $request->customSearch, $request->start_date, $request->end_date);
        }
        $page_data['meetings'] = Meeting::paginate(10);
        return view('projects.meeting.index', $page_data);
    }

    public function create()
    {
        $page_data['project_id'] = Project::where('code', request()->query('code'))->value('id');
        return view('projects.meeting.create', $page_data);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title'             => 'required|string|max:255',
            'timestamp_meeting' => 'required',

        ]);

        if ($validator->fails()) {
            return response()->json([
                'validationError' => $validator->getMessageBag()->toArray(),
            ]);
        }

        $data['project_id']        = $request->project_id;
        $data['title']             = $request->title;
        $data['timestamp_meeting'] = $request->timestamp_meeting;

        $joiningData    = ZoomMeetingController::createMeeting($request->title, $data['timestamp_meeting']);
        $joiningInfoArr = json_decode($joiningData, true);

        if (is_array($joiningInfoArr) && array_key_exists('code', $joiningInfoArr) && $joiningInfoArr) {
            return response()->json([
                'success' => get_phrase($joiningInfoArr['message']),
            ]);
        }

        $data['provider']     = 'zoom';
        $data['joining_data'] = $joiningData ?? null;

        Meeting::insert($data);
        return response()->json([
            'success' => 'Meeting has been stored.',
        ]);
    }

    public function delete($id)
    {
        $meeting = Meeting::where('id', $id)->first();

        // $meeting = Meeting::join('projects', 'project_meetings.project_id', 'projects.id')
        //     ->where('project_meetings.id', $id)
        //     ->where('projects.user_id', Auth::user()->id)->first();

        // if (!$meeting) {
        //     Session::flash('error', get_phrase('Data not found.'));
        //     return redirect()->back();
        // }

        $oldMeetingData = json_decode($meeting->joining_data, true);
        ZoomMeetingController::deleteMeeting($oldMeetingData['id']);
        $meeting->delete();

        return response()->json([
            'success' => 'Meeting has been deleted.',
        ]);
    }

    public function edit(Request $request, $id)
    {

        $data['meeting'] = Meeting::where('id', $id)->first();
        return view('projects.meeting.edit', $data);
    }
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'title'             => 'required|string',
            'timestamp_meeting' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $meeting = Meeting::join('projects', 'project_meetings.project_id', '=', 'projects.id')
            ->where('project_meetings.id', $id)
            ->where('projects.user_id', Auth::user()->id)
            ->select('project_meetings.*')
            ->first();
        // $meeting = Meeting::join('projects', 'project_meetings.project_id', '=', 'projects.id')
        //     ->where('project_meetings.id', $id)
        //     ->where('projects.user_id', Auth::user()->id)
        //     ->select('project_meetings.*')
        //     ->first();
        $meeting = Meeting::where('id', $id)->first();

        if (!$meeting) {
            Session::flash('error', get_phrase('Data not found.'));
            return redirect()->back();
        }


        $data['title']             = $request->title;
        $data['timestamp_meeting'] = $request->timestamp_meeting;

        if ($meeting->provider == 'zoom') {
            $oldMeetingData = json_decode($meeting->joining_data, true);
            ZoomMeetingController::updateMeeting($request->title, $request->timestamp_meeting, $oldMeetingData['id']);
            $oldMeetingData["start_time"] = date('Y-m-d\TH:i:s', strtotime($request->timestamp_meeting));
            $oldMeetingData["topic"]      = $request->title;
            $data['joining_data']         = json_encode($oldMeetingData);
        }

        $meeting->update($data);

        // Meeting::where('id', $id)->update($data);

        Session::flash('success', get_phrase('Live class has been updated.'));
        return redirect()->back();
    }

    public function multiDelete(Request $request)
    {
        $ids = $request->input('data');

        if (!empty($ids)) {
            Meeting::whereIn('id', $ids)->delete();
            return response()->json(['success' => 'Meeting deleted successfully!']);
        }

        return response()->json(['error' => 'No meeting selected for deletion.'], 400);
    }

    public function join($id)
    {
        $current_time  = time();
        $extended_time = $current_time + (60 * 15);

        $meeting = Meeting::select('project_meetings.*', 'projects.user_id as host_id')
            ->join('projects', 'project_meetings.project_id', '=', 'projects.id')
            ->where('project_meetings.id', $id)
            ->first();

        if (!$meeting) {
            Session::flash('error', get_phrase('Meeting not found.'));
            return redirect()->back();
        }

        if ($meeting->provider == 'zoom') {
            $page_data['meeting'] = $meeting;
            $page_data['user']    = get_user_info($meeting->host_id);
            $page_data['is_host'] = 1;
            return view('projects.meeting.join', $page_data);
        } else {
            $meeting_info = json_decode($meeting->joining_data, true);
            return redirect($meeting_info['start_url']);
        }
    }

    public function stop_class($id)
    {
        $class = Meeting::join('projects', 'project_meetings.project_id', 'projects.id')
            ->where('project_meetings.id', $id)
            ->where('projects.user_id', Auth::user()->id)
            ->select('project_meetings.*')
            ->first();

        if (!$class) {
            Session::flash('error', get_phrase('Data not found.'));
            return redirect()->back();
        }

        $class->update(['force_stop' => 1]);
        Session::flash('success', get_phrase('Class has been ended.'));
        return redirect()->back();
    }
    public function live_class_join($id)
    {
        $meeting = Meeting::where('id', $id)->first();

        if ($meeting->provider == 'zoom') {
            if (get_settings('zoom_web_sdk') == 'active') {
                return view('projects.meeting.zoom_meeting', ['meeting' => $meeting]);
            } else {
                $meeting_info = json_decode($meeting->additional_info, true);
                return redirect($meeting_info['start_url']);
            }
        } else {
            return view('projects.meeting.zoom_meeting', ['meeting' => $meeting]);
        }
    }
    public function exportFile(Request $request, $file, $code) {

        $query = Meeting::query();

        $query->where('project_id', project_id_by_code($code));

        if (isset($request->customSearch)) {
            $string = $request->customSearch;
            $query->where(function ($q) use ($string) {
                $q->where('title', 'like', "%{$string}%");
            });
        }

        if ($request->date) {
            $start_date     = date('Y-m-d', strtotime($request->date));
            $query->whereDate('timestamp_start', $start_date);
        }
    
        $page_data['meetings'] = count($request->all()) > 0 ? $query->get() : Meeting::where('project_id', project_id_by_code($code))->get();

        if ($file == 'pdf') {
            $pdf = FacadePdf::loadView('projects.meeting.pdf', $page_data);
            return $pdf->download('meeting.pdf');
        }
        if ($file == 'print') {
            $pdf = FacadePdf::loadView('projects.meeting.pdf', $page_data);
            return $pdf->stream('meeting.pdf');
        }
    
        if ($file == 'csv') {
            $fileName = 'meeting.csv';

            $headers = [
                "Content-type"        => "text/csv",
                "Content-Disposition" => "attachment; filename=$fileName",
                "Pragma"              => "no-cache",
                "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
                "Expires"             => "0"
            ];
    
            // Use the filtered query to get the projects for CSV
            $users = count($request->all()) > 0 ? $query->get() : Meeting::where('project_id', project_id_by_code($code))->get();
    
            $columns = ['#', 'title', 'project', 'provider', 'start_date'];
            
            $callback = function() use ($columns, $users) {
                $file = fopen('php://output', 'w');
                fputcsv($file, $columns);
    
                $count = 1;
                foreach ($users as $item) {    
                    fputcsv($file, [
                        $count,
                        $item->title,
                        Project::where('id', $item->project_id)->value('title'),
                        $item->provider,
                        date('d-M-y h:i A', strtotime($item->timestamp_meeting))
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
