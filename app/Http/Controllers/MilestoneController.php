<?php

namespace App\Http\Controllers;

use App\Models\Milestone;
use App\Models\Project;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MilestoneController extends Controller
{
    public function index(Request $request)
    {
        $page_data = Milestone::get();

        return view('projects.milestone.index', $page_data);
    }

    public function create()
    {
        $page_data['project_id'] = Project::where('code', request()->query('code'))->value('id');
        return view('projects.milestone.create', $page_data);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'tasks' => 'required|array',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'validationError' => $validator->getMessageBag()->toArray(),
            ]);
        }

        $data['project_id']  = $request->project_id;
        $data['title']       = $request->title;
        $data['description'] = $request->description;
        $data['tasks']       = json_encode($request->tasks);

        Milestone::insert($data);
        return response()->json([
            'success' => 'Milestone has been stored.',
        ]);
    }

    public function delete($id)
    {
        Milestone::where('id', $id)->delete();
        return response()->json([
            'success' => 'Milestone has been deleted.',
        ]);
    }

    public function edit(Request $request, $id)
    {

        $data['milestone'] = Milestone::where('id', $id)->first();
        return view('projects.milestone.edit', $data);
    }
    public function update(Request $request, $id)
    {

        $project['title'] = $request->title;

        Milestone::where('id', $request->id)->update($project);

        return response()->json([
            'success' => 'Milestone has been updated.',
        ]);
    }

    public function multiDelete(Request $request)
    {
        $ids = $request->input('data');

        if (!empty($ids)) {
            Milestone::whereIn('id', $ids)->delete();
            return response()->json(['success' => 'Milestone deleted successfully!']);
        }

        return response()->json(['error' => 'No milestone selected for deletion.'], 400);
    }

    public function show($id)
    {
        $milestone          = Milestone::where('id', $id)->first();
        $task_id            = $milestone->tasks ? json_decode($milestone->tasks) : [];
        $page_data['tasks'] = Task::whereIn('id', $task_id)->get();

        return view('projects.milestone.tasks', $page_data);
    }

}
