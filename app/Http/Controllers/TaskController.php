<?php

namespace App\Http\Controllers;

use App\Models\Milestone;
use App\Models\Project;
use App\Models\Role;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;

class TaskController extends Controller
{

    public function index(Request $request, $id ="")
    {
        if($request->ajax()){
            return app(ServerSideDataController::class)->task_server_side($request->project_id, $request->customSearch, $request->team, $request->start_date, $request->end_date, $request->status, $request->progress);                
        }

        $page_data['teams'] = User::where('role_id', 3)->get();
        $page_data['project_tasks'] = Task::paginate(10);
        return view('projects.task.index', $page_data);
    }

    public function create()
    {
        $page_data['project_id'] = Project::where('code', request()->query('code'))->value('id');

        $staffs              = Role::where('title', 'staff')->first();
        $page_data['staffs'] = User::where('role_id', $staffs->id)->get();
        return view('projects.task.create', $page_data);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title'      => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date'   => 'required|date',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'validationError' => $validator->getMessageBag()->toArray(),
            ]);
        }

        $data['project_id'] = $request->project_id;
        $data['title']      = $request->title;
        $data['status']     = $request->status;
        $data['progress']   = $request->progress;
        $data['team']       = json_encode($request->team);
        $data['start_date'] = strtotime($request->start_date);
        $data['end_date']   = strtotime($request->end_date);

        Task::insert($data);
        return response()->json([
            'success' => 'Task has been stored.',
        ]);
    }

    public function delete($id)
    {
        Task::where('id', $id)->delete();

        $milestones = Milestone::whereJsonContains('tasks', $id)->get();
        foreach ($milestones as $milestone) {
            $tasks = $milestone->tasks;
            if (($key = array_search($id, $tasks)) !== false) {
                unset($tasks[$key]);
                $milestone->tasks = array_values($tasks);
                $milestone->save();
            }
        }

        return response()->json([
            'success' => 'Task has been deleted.',
        ]);
    }

    public function edit(Request $request, $id)
    {
        $data['task'] = Task::where('id', $id)->first();
        $staffs         = Role::where('title', 'staff')->first();
        $data['staffs'] = User::where('role_id', $staffs->id)->get();
        return view('projects.task.edit', $data);
    }
    public function update(Request $request, $id)
    {
        $project['title']      = $request->title;
        $project['status']     = $request->status;
        $project['progress']   = $request->progress;
        $project['team']       = json_encode($request->team);
        $project['start_date'] = strtotime($request->start_date);
        $project['end_date']   = strtotime($request->end_date);
        Task::where('id', $request->id)->update($project);
        return response()->json([
            'success' => 'Task has been updated.',
        ]);
    }

    public function multiDelete(Request $request)
    {
        $ids = $request->input('data');

        if (!empty($ids)) {
            Task::whereIn('id', $ids)->delete();
            return response()->json(['success' => 'Tasks deleted successfully!']);
        }

        return response()->json(['error' => 'No tasks selected for deletion.'], 400);
    }

    public function exportFile(Request $request, $file) {

        $query = Task::query();

        if (isset($request->customSearch)) {
            $string = $request->customSearch;
            $query->where(function ($q) use ($string) {
                $q->where('title', 'like', "%{$string}%");
            });
        }

        if ($request->team && $request->team != 'all') {
            $team           = json_encode($request->team);
            $team           = str_replace('[', '', $team);
            $team           = str_replace(']', '', $team);
            $query->where(function ($q) use ($team) {
                $q->where('team', 'like', "%{$team}%");
            });
        }
        if ($request->start_date && $request->end_date) {
            $start_date     = strtotime($request->start_date);
            $end_date       = strtotime($request->end_date);
            $query->where(function ($q) use ($start_date, $end_date) {
                $q->where('start_date', '>=', $start_date);
                $q->where('end_date', '<=', $end_date);
            });
        }
        if ($request->status && $request->status != 'all') {
            $status = $request->status;
            $query->where(function ($q) use ($status) {
                $q->where('status', $status);
            });
        }
        if ($request->progress) {
            $progress = $request->progress;
            $query->where(function ($q) use ($progress) {
                $q->where('progress', $progress);
            });
        }

        if ($file == 'pdf') {
            $page_data['tasks'] = $query->exists() ? $query->get() : Task::get();
            $pdf = FacadePdf::loadView('projects.task.pdf', $page_data);
            return $pdf->download('tasks.pdf');
        }
        if ($file == 'print') {
            $page_data['tasks'] = $query->exists() ? $query->get() : Task::get();
            $pdf = FacadePdf::loadView('projects.task.pdf', $page_data);
            return $pdf->stream('tasks.pdf');
        }
    
        if ($file == 'csv') {
            $fileName = 'tasks.csv';

            $headers = [
                "Content-type"        => "text/csv",
                "Content-Disposition" => "attachment; filename=$fileName",
                "Pragma"              => "no-cache",
                "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
                "Expires"             => "0"
            ];
    
            // Use the filtered query to get the projects for CSV
            $users = $query->exists() ? $query->get() : Task::all();
    
            $columns = ['#', 'title', 'status', 'progress', 'team', 'start_date', 'end_date'];
            
            $callback = function() use ($columns, $users) {
                $file = fopen('php://output', 'w');
                fputcsv($file, $columns);
                $count = 1;
            
                foreach ($users as $item) { 
                    $userName = []; // Store task titles as an array
            
                    foreach (json_decode($item->team) as $user) {
                        $taskModel = User::where('id', $user)->first();
                        if ($taskModel) {
                            $userName[] = $taskModel->name;
                        }
                    }
                    fputcsv($file, [
                        $count,
                        $item->title,
                        ucwords(str_replace('_', '', $item->status)),
                        $item->progress.'%',
                        implode(', ', $userName),
                        date('d-M-y h:i A', $item->start_date),
                        date('d-M-y h:i A', $item->end_date)
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
