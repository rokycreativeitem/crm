<?php

namespace App\Http\Controllers;

use App\Models\Milestone;
use App\Models\Project;
use App\Models\Role;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
{

    public function index(Request $request, $id)
    {

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

}
