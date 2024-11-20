<?php

namespace App\Http\Controllers;

use App\Models\File;
use App\Models\Meeting;
use App\Models\Milestone;
use App\Models\Payment;
use App\Models\Project;
use App\Models\Role;
use App\Models\Task;
use App\Models\Timesheet;
use App\Models\User;
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

    public function index(Request $request)
    {
        $user = Auth::user();

        if (get_current_user_role() == 'client') {
            $page_data['projects'] = Project::with('user')->where('client_id', $user->id)->get();
        } elseif (get_current_user_role() == 'staff') {
            $page_data['projects'] = Project::with('user')->whereJsonContains('staffs', (string) $user->id)->get();
        } else {
            $page_data['projects'] = Project::with('user')->get();
        }

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















    public function server_side_table(Request $request) {

        if($request->type == 'project') {

            // Start query
            $query = Project::query();
            // Apply custom search filter if provided
            if (!empty($request->customSearch)) {
                $customSearch = $request->customSearch;
                $query->where(function ($q) use ($customSearch) {
                    $q->where('title', 'like', "%{$customSearch}%")
                    ->orWhere('code', 'like', "%{$customSearch}%")
                    ->orWhereHas('user', function ($userQuery) use ($customSearch) {
                        $userQuery->where('name', 'like', "%{$customSearch}%");
                    });
                });
            }
            // Format response for DataTables
            // $key = 1;
        
            return datatables()
            ->eloquent($query)
            ->addColumn('id', function ($project) {
                static $key = 1;
                return '
                    <div class="d-flex align-items-center">
                        <input type="checkbox" class="checkbox-item me-2 table-checkbox">
                        <p class="row-number fs-12px">' . $key++ . '</p>
                        <input type="hidden" class="datatable-row-id" value="'.$project->id.'">
                    </div>
                ';
            })
            ->addColumn('title', function ($project) {
                $title = $project?->title;
                return '<div class="dAdmin_profile d-flex align-items-center min-w-200px">
                            <div class="dAdmin_profile_name">
                                <h4 class="title fs-12px">'.$title.'</h4>
                            </div>
                        </div>';
            })
            ->addColumn('code', function ($project) {
                $code = $project?->code;
                return '<div class="dAdmin_profile d-flex align-items-center min-w-200px">
                            <div class="dAdmin_profile_name">
                                <h4 class="title fs-12px">'.$code.'</h4>
                            </div>
                        </div>';
            })
            ->addColumn('client', function ($project) {
                $client = $project->user->name;
                return '<div class="dAdmin_profile d-flex align-items-center min-w-200px">
                            <div class="dAdmin_profile_name">
                                <h4 class="title fs-12px">'.$client.'</h4>
                            </div>
                        </div>';
            })
            ->addColumn('staff', function ($project) {
                $staffs = $project->staffs ? json_decode($project->staffs, true) : [];
                $staffNames = [];
    
                foreach ($staffs as $staff) {
                    $user = get_user($staff);
                    if ($user) {
                        $staffNames[] = $user->name;
                    }
                }
    
                return '<div class="dAdmin_profile d-flex align-items-center min-w-200px">
                            <div class="dAdmin_profile_name">
                                <h4 class="title fs-12px">'.implode(', ', $staffNames).'</h4>
                            </div>
                        </div>';
            })
            ->addColumn('budget', function ($project) {
                $budget = $project->budget;
                return '<div class="dAdmin_profile d-flex align-items-center min-w-200px">
                            <div class="dAdmin_profile_name">
                                <h4 class="title fs-12px">'.currency($budget).'</h4>
                            </div>
                        </div>';
            })
            ->addColumn('progress', function ($project) {
                $progress = $project->progress;
                return '<div class="dAdmin_profile d-flex align-items-start flex-column min-w-200px">
                    <span class="p-2 pt-0 fs-12px">'.$progress.'%</span>
                    <div class="progress ms-2">
                        <div class="progress-bar bg-primary" role="progressbar"
                        style="width: '.$progress.'%; "
                        aria-valuenow="'.$progress.'" aria-valuemin="0"
                        aria-valuemax="100">
                        </div>
                    </div>
                </div>';
            })
            ->addColumn('status', function ($project) {
                $status = $project->status;
                $statusLabel = '';
    
                if ($status == 'in_progress') {
                    $statusLabel = '<span class="in_progress">' . get_phrase('In Progress') . '</span>';
                } elseif ($status == 'not_started') {
                    $statusLabel = '<span class="not_started">' . get_phrase('Not Started') . '</span>';
                } elseif ($status == 'completed') {
                    $statusLabel = '<span class="completed">' . get_phrase('Completed') . '</span>';
                }
            
                // Return the wrapped HTML
                return '<div class="dAdmin_profile_name">' . $statusLabel . '</div>';
            })
            ->addColumn('options', function ($project) {
                // Generate routes dynamically
                $editRoute = route(get_current_user_role() . '.project.edit', $project->code);
                $deleteRoute = route(get_current_user_role() . '.project.delete', $project->code);
                $viewRoute = route(get_current_user_role() . '.project.details', $project->code);
            
                // Return the dropdown HTML
                return '
                    <div class="dropdown disable-right-click ol-icon-dropdown ol-icon-dropdown-transparent">
                        <button class="btn ol-btn-secondary dropdown-toggle m-auto" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <span class="fi-rr-menu-dots-vertical"></span>
                        </button>
                        <ul class="dropdown-menu">
                            <li>
                                <a class="dropdown-item" onclick="rightCanvas(\'' . $editRoute . '\', \'Edit project\')" href="#">' . get_phrase('Edit') . '</a>
                            </li>
                            <li>
                                <a class="dropdown-item" onclick="confirmModal(\'' . $deleteRoute . '\')" href="javascript:void(0)">' . get_phrase('Delete') . '</a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="' . $viewRoute . '">' . get_phrase('View Project') . '</a>
                            </li>
                        </ul>
                    </div>
                ';
            })        
            ->rawColumns(['id','title','code','client','staff','budget','progress','status','options']) // To render the HTML in 'options' column
            ->setRowClass(function () {
                return 'context-menu'; // Add context-menu class to each row
            })
            ->make(true);
        }

    }
}
