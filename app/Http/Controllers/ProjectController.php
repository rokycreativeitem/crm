<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\File;
use App\Models\Meeting;
use App\Models\Milestone;
use App\Models\Payment;
use App\Models\Project;
use App\Models\Role;
use App\Models\Task;
use App\Models\Timesheet;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ProjectController extends Controller
{

    private $code;
    private $project;
    public function __construct()
    {
        $this->code    = request()->route()->parameter('code');
        $this->project = Project::where('code', $this->code)->first();
    }

    public function index(Request $request, $layout = "")
    {
        $user = Auth::user();
        $page_data['layout'] = $layout;
        $page_data['page_item'] = 12;
      
        if ($request->ajax() && $request->layout == 'grid') {
            $pagination = $request->page_item ?? $page_data['page_item'];
            if($request->search) {
                $page_data['projects'] = Project::where('title', 'like', '%' . $request->search . '%')->paginate($pagination);
                $page_data['search'] = $request->search;
            }else{
                $page_data['projects'] = Project::paginate($pagination);
            }

            return view('projects.ajax_grid', $page_data);
        }
        if($request->ajax() && $layout != 'grid'){
            return app(ServerSideDataController::class)->project_server_side($request->customSearch, $request->category, $request->status, $request->client, $request->staff, $request->minPrice, $request->maxPrice);                      
        }
       
        if (get_current_user_role() == 'client') {
            $page_data['projects'] = Project::with('user')->where('client_id', $user->id)->get();
        } elseif (get_current_user_role() == 'staff') {
            $page_data['projects'] = Project::with('user')->whereJsonContains('staffs', (string) $user->id)->get();
        } else {
            $page_data['projects'] = Project::with('user')->paginate(12);
        }

        $page_data['clients'] = User::where('role_id', 2)->get();
        $page_data['staffs'] = User::where('role_id', 3)->get();

        return view('projects.index', $page_data);
    }

    public function show()
    {

        $page_data['files']      = File::where('project_id', $this->project->id)->get();
        $page_data['milestones'] = Milestone::where('project_id', $this->project->id)->get();
        $page_data['timesheets'] = Timesheet::where('project_id', $this->project->id)->get();
        $page_data['tasks']      = Task::where('project_id', $this->project->id)->get();
        $page_data['meetings']   = Meeting::where('project_id', $this->project->id)->get();
        $page_data['payments']   = Payment::where('project_id', $this->project->id)->get();

        return view('projects.details', $page_data);
    }

    public function create()
    {
        $page_data['projects'] = Project::get();
        $client                = Role::where('title', 'client')->first();
        $page_data['clients']  = User::where('role_id', $client->id)->get();
        $staffs                = Role::where('title', 'staff')->first();
        $page_data['staffs']   = User::where('role_id', $staffs->id)->get();

        return view('projects.create', $page_data);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title'       => 'required|string|max:255',
            'code'        => 'required|string|max:255',
            'description' => 'required|string',
            'category_id' => 'required|integer',
            'client_id'   => 'required|integer',
            'staffs'      => 'required|array',
            'budget'      => 'required|numeric',
            'status'      => 'required|string|max:255',
            'note'        => 'required|string',
            'privacy'     => 'required|string|max:255',

        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ], 422);
        }

        $project['title']           = $request->title;
        $project['code']            = Str::random(6);
        $project['description']     = $request->description;
        $project['category_id']     = $request->category_id;
        $project['client_id']       = $request->client_id;
        $project['staffs']          = json_encode($request->staffs);
        $project['budget']          = $request->budget;
        $project['progress']        = $request->progress;
        $project['status']          = $request->status;
        $project['note']            = $request->note;
        $project['privacy']         = $request->privacy;
        $project['timestamp_start'] = date('Y-m-d', time());
        $project['timestamp_end']   = date('Y-m-d', time());

        Project::insert($project);

        return response()->json([
            'success' => 'Product has been stored.',
        ]);
    }
    public function delete()
    {
        Project::find($this->project->id)->delete();
        return response()->json([
            'success' => 'Product has been deleted.',
        ]);
    }

    public function edit($code)
    {
        $project['project'] = Project::where('code', $code)->first();

        $client             = Role::where('title', 'client')->first();
        $project['clients'] = User::where('role_id', $client->id)->get();

        $staffs            = Role::where('title', 'staff')->first();
        $project['staffs'] = User::where('role_id', $staffs->id)->get();

        return view('projects.edit', $project);
    }

    public function update(Request $request, $code)
    {
        $project['title']           = $request->title;
        $project['description']     = $request->description;
        $project['category_id']     = $request->category_id;
        $project['client_id']       = $request->client_id;
        $project['staffs']          = json_encode($request->staffs);
        $project['budget']          = $request->budget;
        $project['progress']        = $request->progress;
        $project['status']          = $request->status;
        $project['note']            = $request->note;
        $project['privacy']         = $request->privacy;
        $project['timestamp_start'] = date('Y-m-d H:i:s', time());
        $project['timestamp_end']   = date('Y-m-d H:i:s', time());

        Project::where('code', $code)->update($project);

        return response()->json([
            'success' => 'Product has been updated.',
        ]);
    }

    public function multiDelete(Request $request)
    {
        $ids = $request->ids;
        $model = 'App\\Models\\' . ucwords($request->type);
        if (is_array($ids)) {
            foreach($ids as $id) {
                $model::where('id', $id)->delete();
            }
            return response()->json(['success' => get_phrase(ucwords($request->type).' '."deleted successfully!")]);
        }
        return response()->json(['error' => get_phrase('No users selected for deletion.')], 400);
    }

    public function categories(Request $request) {
        if($request->ajax()){
           return app(ServerSideDataController::class)->category_server_side($request->customSearch, $request->category, $request->status, $request->client, $request->staff, $request->minPrice, $request->maxPrice);
        }
        $page_data['categories'] = Category::get();
        return view('projects.category.index', $page_data);
    }

    public function category_create() {
        $page_data['categories'] = Category::where('parent', 0)->get();
        return view('projects.category.create', $page_data);
    }

    public function category_store(Request $request, $id = "") {
        $data['name'] = $request->name;
        $data['parent'] = $request->parent;
        $data['status'] = $request->status;
        $data['created_at'] = Carbon::now();
        if ($id) {
            $data['updated_at'] = Carbon::now();
            Category::where('id', $id)->update($data);
        }else{
            Category::insert($data);
        }
        return response()->json(['success' => 'Category ' . ($id ? 'updated' : 'created') . ' successfully!']);
    }

    public function category_delete($id) {
        Category::where('id', $id)->delete();
        return response()->json(['success' => 'Category deleted successfully!']);
    }

    public function category_edit($id) {
        $page_data['categories'] = Category::where('parent', 0)->get();
        $page_data['category'] = Category::where('id', $id)->first();
        return view('projects.category.edit', $page_data);
    }















    // public function server_side_table(Request $request) {

    //     if($request->type == 'project') {

            
    //     }

    // }
}
