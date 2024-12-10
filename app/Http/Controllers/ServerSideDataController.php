<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\File;
use App\Models\Meeting;
use App\Models\Milestone;
use App\Models\Payment;
use App\Models\Project;
use App\Models\Task;
use App\Models\Timesheet;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ServerSideDataController extends Controller
{

    public function project_server_side($string, $category, $status, $client, $staff, $minPrice, $maxPrice)
    {
        $query = Project::query();
        if (!empty($string)) {
            $query->where(function ($q) use ($string) {
                $q->where('title', 'like', "%{$string}%")
                    ->orWhere('code', 'like', "%{$string}%")
                    ->orWhereHas('user', function ($userQuery) use ($string) {
                        $userQuery->where('name', 'like', "%{$string}%");
                    });
            });
        }

        $filter_count = [];
        if ($category != 'all') {
            $filter_count[] = $category;
            $query->where(function ($q) use ($category) {
                $q->where('category_id', $category);
            });
        }
        if ($status != 'all') {
            $filter_count[] = $status;
            $query->where(function ($q) use ($status) {
                $q->where('status', $status);
            });
        }
        if ($client != 'all') {
            $filter_count[] = $client;
            $query->where(function ($q) use ($client) {
                $q->where('client_id', $client);
            });
        }
        if ($staff != 'all') {
            $filter_count[] = $staff;
            $staff          = json_encode($staff);
            $staff          = str_replace('[', '', $staff);
            $staff          = str_replace(']', '', $staff);
            $query->where(function ($q) use ($staff) {
                $q->where('staffs', 'like', "%{$staff}%");
            });
        }

        $maxPrice = (int) $maxPrice;
        $minPrice = (int) $minPrice;
        if ($minPrice > 0 && is_numeric($minPrice) && is_numeric($maxPrice)) {
            $filter_count[] = $minPrice ?? $maxPrice;
            $query->whereBetween('budget', [$minPrice, $maxPrice]);
        }
        return datatables()
            ->eloquent($query)
            ->addColumn('id', function ($project) {
                static $key = 1;
                return '
                <div class="d-flex align-items-center">
                    <input type="checkbox" class="checkbox-item me-2 table-checkbox">
                    <p class="row-number fs-12px">' . $key++ . '</p>
                    <input type="hidden" class="datatable-row-id" value="' . $project->id . '">
                </div>
            ';
            })
            ->addColumn('title', function ($project) {
                return $project?->title;
            })
            ->addColumn('code', function ($project) {
                return $project?->code;
            })
            ->addColumn('client', function ($project) {
                return $project->user->name;
            })
            ->addColumn('staff', function ($project) {
                $staffs     = $project->staffs ? json_decode($project->staffs, true) : [];
                $staffNames = [];
                foreach ($staffs as $staff) {
                    $user = get_user($staff);
                    if ($user) {
                        $staffNames[] = $user->name;
                    }
                }
                return implode(', ', $staffNames);
            })
            ->addColumn('budget', function ($project) {
                return currency($project->budget);
            })
            ->addColumn('progress', function ($project) {
                $progress = $project->progress;
                return '<div class="dAdmin_profile d-flex align-items-start flex-column min-w-200px">
                <span class="p-2 pt-0 fs-12px">' . $progress . '%</span>
                <div class="progress ms-2">
                    <div class="progress-bar bg-primary" role="progressbar"
                    style="width: ' . $progress . '%; "
                    aria-valuenow="' . $progress . '" aria-valuemin="0"
                    aria-valuemax="100">
                    </div>
                </div>
            </div>';
            })
            ->addColumn('status', function ($project) {
                $status      = $project->status;
                $statusLabel = '';
                if ($status == 'in_progress') {
                    $statusLabel = '<span class="in_progress">' . get_phrase('In Progress') . '</span>';
                } elseif ($status == 'not_started') {
                    $statusLabel = '<span class="not_started">' . get_phrase('Not Started') . '</span>';
                } elseif ($status == 'completed') {
                    $statusLabel = '<span class="completed">' . get_phrase('Completed') . '</span>';
                }
                // Return the wrapped HTML
                return $statusLabel;
            })
            ->addColumn('options', function ($project) {
                // Generate routes dynamically
                $editRoute   = route(get_current_user_role() . '.project.edit', $project->code);
                $deleteRoute = route(get_current_user_role() . '.project.delete', $project->code);
                $viewRoute   = route(get_current_user_role() . '.project.details', $project->code);

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
            ->addColumn('context_menu', function ($project) {
                $editRoute   = route(get_current_user_role() . '.project.edit', $project->code);
                $deleteRoute = route(get_current_user_role() . '.project.delete', $project->code);
                $dashboardRoute   = route(get_current_user_role() . '.project.details',['code'=>$project->code, 'tab'=>'dashboard']);
                $milestoneRoute   = route(get_current_user_role() . '.project.details',['code'=>$project->code, 'tab'=>'milestone']);
                $milestoneRoute   = route(get_current_user_role() . '.project.details',['code'=>$project->code, 'tab'=>'milestone']);
                $taskRoute   = route(get_current_user_role() . '.project.details',['code'=>$project->code, 'tab'=>'task']);
                $fileRoute   = route(get_current_user_role() . '.project.details',['code'=>$project->code, 'tab'=>'file']);
                $meetingRoute   = route(get_current_user_role() . '.project.details',['code'=>$project->code, 'tab'=>'meeting']);
                $invoiceRoute   = route(get_current_user_role() . '.project.details',['code'=>$project->code, 'tab'=>'invoice']);
                $ganttRoute   = route(get_current_user_role() . '.project.details',['code'=>$project->code, 'tab'=>'gantt_chart']);
                $timesheetRoute   = route(get_current_user_role() . '.project.details',['code'=>$project->code, 'tab'=>'timesheet']);
                // Generate the context menu
                $contextMenu = [
                    'Edit'   => [
                        'type'        => 'ajax',
                        'name'        => 'Edit',
                        'action_link' => $editRoute,
                        'title'       => 'Edit project',
                    ],
                    'Delete' => [
                        'type'        => 'ajax',
                        'name'        => 'Delete',
                        'action_link' => $deleteRoute,
                        'title'       => 'Delete project',
                    ],
                    'Dashboard'   => [
                        'type'        => 'ajax',
                        'name'        => 'Dashboard',
                        'action_link' => $dashboardRoute,
                        'title'       => 'Dashboard',
                    ],
                    'Milestone'   => [
                        'type'        => 'ajax',
                        'name'        => 'Milestone',
                        'action_link' => $milestoneRoute,
                        'title'       => 'Milestone',
                    ],
                    'Task'   => [
                        'type'        => 'ajax',
                        'name'        => 'Task',
                        'action_link' => $taskRoute,
                        'title'       => 'Task',
                    ],
                    'File'   => [
                        'type'        => 'ajax',
                        'name'        => 'File',
                        'action_link' => $fileRoute,
                        'title'       => 'File',
                    ],
                    'Meeting'   => [
                        'type'        => 'ajax',
                        'name'        => 'Meeting',
                        'action_link' => $meetingRoute,
                        'title'       => 'Meeting',
                    ],
                    'Invoice'   => [
                        'type'        => 'ajax',
                        'name'        => 'Invoice',
                        'action_link' => $invoiceRoute,
                        'title'       => 'Invoice',
                    ],
                    'Timesheet'   => [
                        'type'        => 'ajax',
                        'name'        => 'Timesheet',
                        'action_link' => $timesheetRoute,
                        'title'       => 'Timesheet',
                    ],
                    'Gantt'   => [
                        'type'        => 'ajax',
                        'name'        => 'Gantt Chart',
                        'action_link' => $ganttRoute,
                        'title'       => 'Gantt Chart',
                    ]
                ];

                // JSON encode with unescaped slashes for cleaner URLs
                return json_encode($contextMenu, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
            })
            ->rawColumns(['id', 'title', 'code', 'client', 'staff', 'budget', 'progress', 'status', 'options'])
            ->setRowClass(function () {
                return 'context-menu';
            })
            ->with('filter_count', count($filter_count))
            ->make(true);
    }

    public function category_server_side($string, $category, $status, $client, $staff, $minPrice, $maxPrice)
    {
        $query = Category::query();
        if (!empty($string)) {
            $query->where(function ($q) use ($string) {
                $q->where('name', 'like', "%{$string}%");
            });
        }

        return datatables()
            ->eloquent($query)
            ->addColumn('id', function ($category) {
                static $key = 1;
                return '
                    <div class="d-flex align-items-center">
                        <input type="checkbox" class="checkbox-item me-2 table-checkbox">
                        <p class="row-number fs-12px">' . $key++ . '</p>
                        <input type="hidden" class="datatable-row-id" value="' . $category->id . '">
                    </div>
                ';
            })
            ->addColumn('name', function ($category) {
                return $category?->name;
            })
            ->addColumn('parent', function ($category) {
                if ($category->parent != 0) {
                    $category_parent = Category::find($category->parent);
                    return $category_parent?->name;
                } else {
                    return '';
                }
            })
            ->addColumn('status', function ($category) {
                $statusLabel = '';
                if ($category->status == 1) {
                    $statusLabel = '<span class="completed">' . get_phrase('Active') . '</span>';
                } elseif ($category->status == 0) {
                    $statusLabel = '<span class="in_progress">' . get_phrase('De-Active') . '</span>';
                }
                return $statusLabel;
            })
            ->addColumn('options', function ($category) {
                $editRoute   = route(get_current_user_role() . '.project.category.edit', $category->id);
                $deleteRoute = route(get_current_user_role() . '.project.category.delete', $category->id);

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
                    </ul>
                </div>
            ';
            })
            ->addColumn('context_menu', function ($category) {
                $editUrl   = route(get_current_user_role() . '.project.category.edit', $category->id);
                $deleteUrl = route(get_current_user_role() . '.project.category.delete', $category->id);
                // Generate the context menu
                $contextMenu = [
                    'Edit'   => [
                        'type'        => 'ajax',
                        'name'        => 'Edit',
                        'action_link' => $editUrl,
                        'title'       => 'Edit category',
                    ],
                    'Delete' => [
                        'type'        => 'ajax',
                        'name'        => 'Delete',
                        'action_link' => $deleteUrl,
                        'title'       => 'Delete category',
                    ],
                ];

                // JSON encode with unescaped slashes for cleaner URLs
                return json_encode($contextMenu, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
            })

            ->rawColumns(["id", "name", "parent", "status", "options"])
            ->setRowClass('category-context-menu')
            ->with('filter_count', 0)
            ->make(true);
    }

    public function milestone_server_side($project_code, $string, $task, $start_date, $end_date)
    {
        $filter_count = [];
        $query        = Milestone::query();
        $query->where('project_id', project_id_by_code($project_code));
        if (!empty($string)) {
            $query->where(function ($q) use ($string) {
                $q->where('title', 'like', "%{$string}%");
            });
        }
        if ($task != 'all') {
            $filter_count[] = $task;
            $task           = json_encode($task);
            $task           = str_replace('[', '', $task);
            $task           = str_replace(']', '', $task);
            $query->where(function ($q) use ($task) {
                $q->where('tasks', 'like', "%{$task}%");
            });
        }
        if ($start_date && $end_date) {
            $filter_count[] = $start_date;
            $start_date     = date('Y-m-d H:i:s', strtotime($start_date));
            $end_date       = date('Y-m-d H:i:s', strtotime($end_date));
            $query->where(function ($q) use ($start_date, $end_date) {
                $q->where('timestamp_start', '>=', $start_date);
                $q->where('timestamp_end', '<=', $end_date);
            });
        }

        return datatables()
            ->eloquent($query)
            ->addColumn('id', function ($milestone) {
                static $key = 1;
                return '
                <div class="d-flex align-items-center">
                    <input type="checkbox" class="checkbox-item me-2 table-checkbox">
                    <p class="row-number fs-12px">' . $key++ . '</p>
                    <input type="hidden" class="datatable-row-id" value="' . $milestone->id . '">
                </div>
            ';
            })
            ->addColumn('name', function ($milestone) {
                return $milestone?->title;
            })
            ->addColumn('description', function ($milestone) {
                return $milestone?->description;
            })
            ->addColumn('tasks', function ($milestone) {
                $tasks  = $milestone?->tasks; // Get tasks directly
                $output = '';
                if (is_array($tasks)) { // Check if tasks is already an array
                    foreach ($tasks as $task) {
                        $task_title = Task::where('id', $task)->first()?->title;
                        $output .= '<li>' . htmlspecialchars($task_title, ENT_QUOTES, 'UTF-8') . '</li>';
                    }
                }

                return $output ? '<ul class="circle-style">' . $output . '</ul>' : 'No tasks available';
            })
            ->addColumn('options', function ($milestone) {
                // Generate routes dynamically .milestone.edit', $milestone->id
                $editRoute   = route(get_current_user_role() . '.milestone.edit', $milestone->id);
                $deleteRoute = route(get_current_user_role() . '.milestone.delete', $milestone->id);

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
                    </ul>
                </div>
            ';
            })
            ->addColumn('context_menu', function ($milestone) {
                $editRoute   = route(get_current_user_role() . '.milestone.edit', $milestone->id);
                $deleteRoute = route(get_current_user_role() . '.milestone.delete', $milestone->id);
                // Generate the context menu
                $contextMenu = [
                    'Edit'   => [
                        'type'        => 'ajax',
                        'name'        => 'Edit',
                        'action_link' => $editRoute,
                        'title'       => 'Edit milestone',
                    ],
                    'Delete' => [
                        'type'        => 'ajax',
                        'name'        => 'Delete',
                        'action_link' => $deleteRoute,
                        'title'       => 'Delete milestone',
                    ],
                ];

                // JSON encode with unescaped slashes for cleaner URLs
                return json_encode($contextMenu, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
            })
            ->rawColumns(["id", "title", "description", "tasks", "options"])
            ->setRowClass(function () {
                return 'context-menu';
            })
            ->with('filter_count', count($filter_count))
            ->make(true);
    }

    public function task_server_side($project_code, $string, $team, $start_date, $end_date, $status, $progress)
    {
        $filter_count = [];
        $query        = Task::query();
        $query->where('project_id', project_id_by_code($project_code));
        if (!empty($string)) {
            $query->where(function ($q) use ($string) {
                $q->where('title', 'like', "%{$string}%");
            });
        }
        if ($team != 'all') {
            $filter_count[] = $status;
            $team           = json_encode($team);
            $team           = str_replace('[', '', $team);
            $team           = str_replace(']', '', $team);
            $query->where(function ($q) use ($team) {
                $q->where('team', 'like', "%{$team}%");
            });
        }
        if ($start_date && $end_date) {
            $filter_count[] = $end_date;
            $start_date     = strtotime($start_date);
            $end_date       = strtotime($end_date);
            $query->where(function ($q) use ($start_date, $end_date) {
                $q->where('start_date', '>=', $start_date);
                $q->where('end_date', '<=', $end_date);
            });
        }
        if ($status != 'all') {
            $filter_count[] = $status;
            $query->where(function ($q) use ($status) {
                $q->where('status', $status);
            });
        }
        if ($progress) {
            $filter_count[] = $status;
            $query->where(function ($q) use ($progress) {
                $q->where('progress', $progress);
            });
        }
        return datatables()
            ->eloquent($query)
            ->addColumn('id', function ($milestone) {
                static $key = 1;
                return '
                <div class="d-flex align-items-center">
                    <input type="checkbox" class="checkbox-item me-2 table-checkbox">
                    <p class="row-number fs-12px">' . $key++ . '</p>
                    <input type="hidden" class="datatable-row-id" value="' . $milestone->id . '">
                </div>
            ';
            })
            ->addColumn('title', function ($milestone) {
                return $milestone?->title;
            })
            ->addColumn('team', function ($task) {
                $teams  = json_decode($task->team);
                $output = '';
                if (is_array($teams)) { // Check if tasks is already an array
                    foreach ($teams as $team) {
                        $team_member = User::where('id', $team)->first();
                        $output .= '<li>' . htmlspecialchars($team_member?->name, ENT_QUOTES, 'UTF-8') . '</li>';
                    }
                }
                return $output ? '<ul class="circle-style">' . $output . '</ul>' : 'No tasks available';
            })
            ->addColumn('start_date', function ($task) {
                return date('d-M-y h:i A', $task?->start_date);
            })
            ->addColumn('end_date', function ($task) {
                return date('d-M-y h:i A', $task?->end_date);
            })
            ->addColumn('status', function ($task) {
                $task        = $task->status;
                $statusLabel = '';
                if ($task == 'in_progress') {
                    $statusLabel = '<span class="in_progress">' . get_phrase('In Progress') . '</span>';
                } elseif ($task == 'not_started') {
                    $statusLabel = '<span class="not_started">' . get_phrase('Not Started') . '</span>';
                } elseif ($task == 'completed') {
                    $statusLabel = '<span class="completed">' . get_phrase('Completed') . '</span>';
                }
                // Return the wrapped HTML
                return $statusLabel;
            })
            ->addColumn('progress', function ($task) {
                $progress = $task->progress;
                return '<div class="dAdmin_profile d-flex align-items-start flex-column min-w-200px">
                <span class="p-2 pt-0 fs-12px">' . $progress . '%</span>
                <div class="progress ms-2">
                    <div class="progress-bar bg-primary" role="progressbar"
                    style="width: ' . $progress . '%; "
                    aria-valuenow="' . $progress . '" aria-valuemin="0"
                    aria-valuemax="100">
                    </div>
                </div>
            </div>';
            })
            ->addColumn('options', function ($task) {
                // Generate routes dynamically .milestone.edit', $milestone->id
                $editRoute   = route(get_current_user_role() . '.task.edit', $task->id);
                $deleteRoute = route(get_current_user_role() . '.task.delete', $task->id);

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
                    </ul>
                </div>
            ';
            })
            ->addColumn('context_menu', function ($task) {
                $editRoute   = route(get_current_user_role() . '.task.edit', $task->id);
                $deleteRoute = route(get_current_user_role() . '.task.delete', $task->id);
                // Generate the context menu
                $contextMenu = [
                    'Edit'   => [
                        'type'        => 'ajax',
                        'name'        => 'Edit',
                        'action_link' => $editRoute,
                        'title'       => 'Edit task',
                    ],
                    'Delete' => [
                        'type'        => 'ajax',
                        'name'        => 'Delete',
                        'action_link' => $deleteRoute,
                        'title'       => 'Delete task',
                    ],
                ];

                // JSON encode with unescaped slashes for cleaner URLs
                return json_encode($contextMenu, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
            })
            ->rawColumns(["id", "title", "team", "start_date", "end_date", "status", "progress", "options"])
            ->setRowClass(function () {
                return 'context-menu';
            })
            ->with('filter_count', count($filter_count))
            ->make(true);
    }

    public function file_server_side($project_code, $string, $start_date, $end_date, $type, $uploaded_by, $size)
    {
        $filter_count = [];
        $query        = File::query();
        $query->where('project_id', project_id_by_code($project_code));
        if (!empty($string)) {
            $query->where(function ($q) use ($string) {
                $q->where('title', 'like', "%{$string}%");
            });
        }
        if ($start_date && $end_date) {
            $filter_count[] = $start_date;
            $start_date     = date('Y-m-d H:i:s', strtotime($start_date));
            $end_date       = date('Y-m-d H:i:s', strtotime($end_date));
            $query->where(function ($q) use ($start_date, $end_date) {
                $q->where('timestamp_start', '>=', $start_date);
                $q->where('timestamp_end', '<=', $end_date);
            });
        }
        if($type != 'all') {
            $filter_count[] = $type;
            $query->where('extension', $type);
        }
        if($uploaded_by != 'all') {
            $filter_count[] = $uploaded_by;
            $query->where('user_id', $uploaded_by);
        }
        if ($size !== 'all') {
            $filter_count[] = $size;
            list($minSize, $maxSize) = explode('|', $size);
            $minSize = (float)$minSize;
            $maxSize = (float)$maxSize;
            $query->whereBetween('size', [$minSize, $maxSize]);
        }
        

        return datatables()
            ->eloquent($query)
            ->addColumn('id', function ($file) {
                static $key = 1;
                return '
                <div class="d-flex align-items-center">
                    <input type="checkbox" class="checkbox-item me-2 table-checkbox">
                    <p class="row-number fs-12px">' . $key++ . '</p>
                    <input type="hidden" class="datatable-row-id" value="' . $file->id . '">
                </div>
            ';
            })
            ->addColumn('title', function ($file) {
                return $file?->title;
            })
            ->addColumn('type', function ($file) {
                return strtoupper($file->extension);
            })
            ->addColumn('size', function ($file) {
                return $file->size;
            })
            ->addColumn('date', function ($file) {
                return date('d-M-y h:i A', strtotime($file->timestamp_start));
            })
            ->addColumn('updated_by', function ($file) {
                return User::where('id', $file->user_id)->first()->name;
            })
            ->addColumn('downloaded', function ($file) {
                return '<a href="' . asset($file->file) . '" download="project-file.' . $file->extension . '" class="download-btn"><svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M4.92958 5.39042L4.92958 5.39041L4.92862 5.3905C3.61385 5.5146 2.6542 5.93651 2.02459 6.70783C1.39588 7.47804 1.10332 8.58816 1.10332 10.0736V10.1603C1.10332 11.8027 1.45436 12.987 2.22713 13.7598C2.99991 14.5326 4.18424 14.8836 5.82665 14.8836H10.1733C11.8157 14.8836 13 14.5326 13.7728 13.7615C14.5456 12.9904 14.8967 11.8094 14.8967 10.1736V10.0869C14.8967 8.59144 14.5991 7.4745 13.9602 6.70257C13.3204 5.92962 12.3457 5.5112 11.0111 5.39715C10.7022 5.36786 10.4461 5.59636 10.4169 5.89543C10.3874 6.19756 10.6157 6.46083 10.9151 6.49005L10.9158 6.4901C11.9763 6.57958 12.6917 6.86862 13.1444 7.43161C13.5984 7.99634 13.7967 8.84694 13.7967 10.0803V10.1669C13.7967 11.5202 13.5567 12.4212 12.9921 12.9858C12.4275 13.5504 11.5265 13.7903 10.1733 13.7903H5.82665C4.47345 13.7903 3.57245 13.5504 3.00784 12.9858C2.44324 12.4212 2.20332 11.5202 2.20332 10.1669V10.0803C2.20332 8.85356 2.39823 8.00609 2.84423 7.44127C3.28876 6.8783 3.99097 6.58615 5.03125 6.49007L5.03139 6.49006C5.33896 6.46076 5.5591 6.18959 5.52975 5.88876C5.50032 5.58704 5.22199 5.36849 4.92958 5.39042Z" fill="#6D718C" stroke="#6D718C" stroke-width="0.1"/>
                    <path d="M7.45 9.92028C7.45 10.2212 7.69905 10.4703 8 10.4703C8.30051 10.4703 8.55 10.2283 8.55 9.92028V1.33362C8.55 1.03267 8.30095 0.783618 8 0.783618C7.69905 0.783618 7.45 1.03267 7.45 1.33362V9.92028Z" fill="#6D718C" stroke="#6D718C" stroke-width="0.1"/>
                    <path d="M7.61153 11.0556C7.7214 11.1655 7.86101 11.2169 8.00022 11.2169C8.13943 11.2169 8.27904 11.1655 8.38891 11.0556L10.6222 8.8223C10.8351 8.60944 10.8351 8.25778 10.6222 8.04492C10.4094 7.83206 10.0577 7.83206 9.84487 8.04492L8.00022 9.88957L6.15558 8.04492C5.94272 7.83206 5.59106 7.83206 5.3782 8.04492C5.16534 8.25778 5.16534 8.60944 5.3782 8.8223L7.61153 11.0556Z" fill="#6D718C" stroke="#6D718C" stroke-width="0.1"/>
                    </svg>
                </a>';
            })
            ->addColumn('options', function ($file) {
                // Generate routes dynamically .milestone.edit', $milestone->id
                $editRoute   = route(get_current_user_role() . '.file.edit', $file->id);
                $deleteRoute = route(get_current_user_role() . '.file.delete', $file->id);

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
                    </ul>
                </div>
            ';
            })
            ->addColumn('context_menu', function ($file) {
                $editRoute   = route(get_current_user_role() . '.file.edit', $file->id);
                $deleteRoute = route(get_current_user_role() . '.file.delete', $file->id);
                // Generate the context menu
                $contextMenu = [
                    'Edit'   => [
                        'type'        => 'ajax',
                        'name'        => 'Edit',
                        'action_link' => $editRoute,
                        'title'       => 'Edit file',
                    ],
                    'Delete' => [
                        'type'        => 'ajax',
                        'name'        => 'Delete',
                        'action_link' => $deleteRoute,
                        'title'       => 'Delete file',
                    ],
                ];

                // JSON encode with unescaped slashes for cleaner URLs
                return json_encode($contextMenu, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
            })
            ->rawColumns(["id", "title", "type", "size", "date", "updated_by", "downloaded", "options"])
            ->setRowClass(function () {
                return 'context-menu';
            })
            ->with('filter_count', count($filter_count))
            ->make(true);
    }

    public function meeting_server_side($project_code, $string, $start_date, $end_date)
    {
        $query = Meeting::query();
        $query->where('project_id', project_id_by_code($project_code));
        if (!empty($string)) {
            $query->where(function ($q) use ($string) {
                $q->where('title', 'like', "%{$string}%");
            });
        }
        $filter_count = [];
        if ($start_date && $end_date) {
            $filter_count[] = $start_date;
            $start_date     = date('Y-m-d H:i:s', strtotime($start_date));
            $end_date       = date('Y-m-d H:i:s', strtotime($end_date));
            $query->where(function ($q) use ($start_date, $end_date) {
                $q->where('timestamp_meeting', '>=', $start_date);
                $q->where('timestamp_created', '<=', $end_date);
            });
        }
        return datatables()
            ->eloquent($query)
            ->addColumn('id', function ($meeting) {
                static $key = 1;
                return '
                <div class="d-flex align-items-center">
                    <input type="checkbox" class="checkbox-item me-2 table-checkbox">
                    <p class="row-number fs-12px">' . $key++ . '</p>
                    <input type="hidden" class="datatable-row-id" value="' . $meeting->id . '">
                </div>
            ';
            })
            ->addColumn('title', function ($meeting) {
                return $meeting?->title;
            })
            ->addColumn('time', function ($meeting) {
                return date('d-M-y h:i A', strtotime($meeting->timestamp_meeting));
            })
            ->addColumn('join', function ($meeting) {
                $meeting = json_decode($meeting->joining_data);
                if ($meeting) {
                    $url = $meeting?->start_url;
                    return '<a class="join-btn" href="' . $url . '">' . get_phrase('Start Meeting') . '</a>';
                } else {
                    return '';
                }
            })
            ->addColumn('options', function ($meeting) {
                // Generate routes dynamically .milestone.edit', $milestone->id
                $editRoute   = route(get_current_user_role() . '.meeting.edit', $meeting->id);
                $deleteRoute = route(get_current_user_role() . '.meeting.delete', $meeting->id);

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
                    </ul>
                </div>
            ';
            })
            ->addColumn('context_menu', function ($meeting) {
                $editRoute   = route(get_current_user_role() . '.meeting.edit', $meeting->id);
                $deleteRoute = route(get_current_user_role() . '.meeting.delete', $meeting->id);
                // Generate the context menu
                $contextMenu = [
                    'Edit'   => [
                        'type'        => 'ajax',
                        'name'        => 'Edit',
                        'action_link' => $editRoute,
                        'title'       => 'Edit meeting',
                    ],
                    'Delete' => [
                        'type'        => 'ajax',
                        'name'        => 'Delete',
                        'action_link' => $deleteRoute,
                        'title'       => 'Delete meeting',
                    ],
                ];

                // JSON encode with unescaped slashes for cleaner URLs
                return json_encode($contextMenu, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
            })
            ->rawColumns(["id", "title", "time", "join", "options"])
            ->setRowClass(function () {
                return 'context-menu';
            })
            ->with('filter_count', count($filter_count))
            ->make(true);
    }

    public function timesheet_server_side($project_code, $string, $start_date, $end_date, $user) {
        $query = Timesheet::query();
        $query->where('project_id', project_id_by_code($project_code));
        if (!empty($string)) {
            $query->where(function ($q) use ($string) {
                $q->where('title', 'like', "%{$string}%");
            });
        }
        $filter_count = [];
        if ($start_date && $end_date) {
            $filter_count[] = $start_date;
            $start_date     = date('Y-m-d H:i:s', strtotime($start_date));
            $end_date       = date('Y-m-d H:i:s', strtotime($end_date));
            $query->where(function ($q) use ($start_date, $end_date) {
                $q->where('timestamp_start', '>=', $start_date);
                $q->where('timestamp_end', '<=', $end_date);
            });
        }
        if ($user != 'all') {
            $filter_count[] = $user;
            $query->where('user_id', $user);
        }
        return datatables()
            ->eloquent($query)
            ->addColumn('id', function ($time) {
                static $key = 1;
                return '
                <div class="d-flex align-items-center">
                    <input type="checkbox" class="checkbox-item me-2 table-checkbox">
                    <p class="row-number fs-12px">' . $key++ . '</p>
                    <input type="hidden" class="datatable-row-id" value="' . $time->id . '">
                </div>
            ';
            })
            ->addColumn('title', function ($time) {
                return $time?->title;
            })
            ->addColumn('from', function ($time) {
                return date('d-M-y h:i A', strtotime($time->timestamp_start));
            })
            ->addColumn('user', function ($time) {
                $user = User::where('id', $time->staff)->first();
                if($user) {
                    return $user->name;
                } else {
                    return '';
                }
            })
            ->addColumn('hours', function ($time) {
                $start_time = strtotime($time->timestamp_start);
                $end_time = strtotime($time->timestamp_end);
                $hours = round(($end_time - $start_time) / 3600, 2);
                return $hours.' '.get_phrase('Hours');
            })
            
            ->addColumn('to', function ($time) {
                return date('d-M-y h:i A', strtotime($time->timestamp_end));
            })
            ->addColumn('options', function ($time) {
                // Generate routes dynamically .milestone.edit', $milestone->id
                $editRoute   = route(get_current_user_role() . '.timesheet.edit', $time->id);
                $deleteRoute = route(get_current_user_role() . '.timesheet.delete', $time->id);

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
                    </ul>
                </div>
            ';
            })
            ->addColumn('context_menu', function ($time) {
                $editRoute   = route(get_current_user_role() . '.timesheet.edit', $time->id);
                $deleteRoute = route(get_current_user_role() . '.timesheet.delete', $time->id);
                // Generate the context menu
                $contextMenu = [
                    'Edit' => [
                        'type' => 'ajax',
                        'name' => 'Edit',
                        'action_link' => $editRoute,
                        'title' => 'Edit meeting'
                    ],
                    'Delete' => [
                        'type' => 'ajax',
                        'name' => 'Delete',
                        'action_link' => $deleteRoute,
                        'title' => 'Delete meeting'
                    ]
                ];

                // JSON encode with unescaped slashes for cleaner URLs
                return json_encode($contextMenu, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
            })
            ->rawColumns(["id","title","user","from","hours","to","options"])
            ->setRowClass(function () {
                return 'context-menu';
            })
            ->with('filter_count', count($filter_count))
            ->make(true);
    }

    public function invoice_server_side($project_code, $string, $date) {
        $query = Payment::query();
        $query->where('project_id', project_id_by_code($project_code));
        if (!empty($string)) {
            $query->where(function ($q) use ($string) {
                $q->where('title', 'like', "%{$string}%");
            });
        }
        $filter_count = [];
        if ($date) {
            $filter_count[] = $date;
            $start_date     = date('Y-m-d', strtotime($date));
            $query->whereDate('timestamp_start', $start_date);
        }
        return datatables()
            ->eloquent($query)
            ->addColumn('id', function ($invoice) {
                static $key = 1;
                return '
                <div class="d-flex align-items-center">
                    <input type="checkbox" class="checkbox-item me-2 table-checkbox">
                    <p class="row-number fs-12px">' . $key++ . '</p>
                    <input type="hidden" class="datatable-row-id" value="' . $invoice->id . '">
                </div>
            ';
            })
            ->addColumn('title', function ($invoice) {
                return $invoice?->title;
            })
            ->addColumn('payment', function ($invoice) {
                return currency($invoice->payment);
            })
            ->addColumn('time', function ($invoice) {
                return date('d-M-y h:i A', strtotime($invoice->timestamp_start));
            })
            ->addColumn('options', function ($invoice) {
                // Generate routes dynamically .milestone.edit', $milestone->id
                $editRoute   = route(get_current_user_role() . '.invoice.edit', $invoice->id);
                $deleteRoute = route(get_current_user_role() . '.invoice.delete', $invoice->id);
                $invoiceRoute = route(get_current_user_role() . '.invoice.edit', $invoice->id);
                return '
                <div class="dropdown disable-right-click ol-icon-dropdown ol-icon-dropdown-transparent">
                    <button class="btn ol-btn-secondary dropdown-toggle m-auto" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <span class="fi-rr-menu-dots-vertical"></span>
                    </button>
                    <ul class="dropdown-menu">
                        <li>
                            <a class="dropdown-item" href="'.$invoiceRoute.'">' . get_phrase('Invoice') . '</a>
                        </li>
                        <li>
                            <a class="dropdown-item" onclick="rightCanvas(\'' . $editRoute . '\', \'Edit project\')" href="#">' . get_phrase('Edit') . '</a>
                        </li>
                        <li>
                            <a class="dropdown-item" onclick="confirmModal(\'' . $deleteRoute . '\')" href="javascript:void(0)">' . get_phrase('Delete') . '</a>
                        </li>
                    </ul>
                </div>
            ';
            })
            ->addColumn('context_menu', function ($invoice) {
                $editRoute   = route(get_current_user_role() . '.invoice.edit', $invoice->id);
                $deleteRoute = route(get_current_user_role() . '.invoice.delete', $invoice->id);
                $invoiceRoute = route(get_current_user_role() . '.invoice.edit', $invoice->id);
                // Generate the context menu
                $contextMenu = [
                    'Invoice' => [
                        'type' => 'url',
                        'name' => 'Invoice',
                        'action_link' => $invoiceRoute,
                        'title' => 'View Invoice'
                    ],
                    'Edit' => [
                        'type' => 'ajax',
                        'name' => 'Edit',
                        'action_link' => $editRoute,
                        'title' => 'Edit meeting'
                    ],
                    'Delete' => [
                        'type' => 'ajax',
                        'name' => 'Delete',
                        'action_link' => $deleteRoute,
                        'title' => 'Delete meeting'
                    ]
                ];

                // JSON encode with unescaped slashes for cleaner URLs
                return json_encode($contextMenu, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
            })
            ->rawColumns(["id","title","payment","time","options"])
            ->setRowClass(function () {
                return 'context-menu';
            })
            ->with('filter_count', count($filter_count))
            ->make(true);
    }

    public function project_report_server_side($string, $project, $paymentMethod, $status, $minAmount, $maxAmount)
    {
        $query = Payment::query();

        return datatables()
            ->eloquent($query)
            ->addColumn('id', function ($payment) {
                return '
            <div class="d-flex align-items-center">
                <input type="checkbox" class="checkbox-item me-2 table-checkbox">
                <p class="row-number fs-12px">' . $payment->id . '</p>
                <input type="hidden" class="datatable-row-id" value="' . $payment->id . '">
            </div>';
            })
            ->addColumn('date', function ($payment) {
                return date('Y-m-d', strtotime($payment->timestamp_start));
            })
            ->addColumn('project', function ($payment) {
                return $payment->project->title ?? '-';
            })
            ->addColumn('amount', function ($payment) {
                return currency($payment->payment);
            })
            ->addColumn('payment_method', function ($payment) {
                return $payment->payment_method;
            })
            ->addColumn('status', function ($payment) {
                $status      = $payment->status;
                $statusLabel = '';
                if ($status == 'completed') {
                    $statusLabel = '<span class="badge bg-success">' . get_phrase('Completed') . '</span>';
                } elseif ($status == 'pending') {
                    $statusLabel = '<span class="badge bg-warning">' . get_phrase('Pending') . '</span>';
                } elseif ($status == 'failed') {
                    $statusLabel = '<span class="badge bg-danger">' . get_phrase('Failed') . '</span>';
                }
                return $statusLabel;
            })
            ->rawColumns(['id', 'timestamp_start', 'project', 'payment', 'payment_method', 'status'])
            ->setRowClass(function () {
                return 'context-menu';
            })
            ->make(true);
    }

    // public function report_server_side($string, $status, $paymentMethod, $minPayment, $maxPayment)
    // {
    //     $query = Payment::query();

    //     return datatables()
    //         ->eloquent($query)
    //         ->addColumn('id', function ($payment) {
    //             return '
    //         <div class="d-flex align-items-center">
    //             <input type="checkbox" class="checkbox-item me-2 table-checkbox">
    //             <p class="row-number fs-12px">' . $payment->id . '</p>
    //             <input type="hidden" class="datatable-row-id" value="' . $payment->id . '">
    //         </div>';
    //         })
    //         ->addColumn('date', function ($payment) {
    //             return date('Y-m-d', strtotime($payment->timestamp_start));
    //         })
    //         ->addColumn('project', function ($payment) {
    //             return $payment->project->title ?? '-';
    //         })
    //         ->addColumn('amount', function ($payment) {
    //             return currency($payment->payment);
    //         })
    //         ->addColumn('payment_method', function ($payment) {
    //             return $payment->payment_method;
    //         })
    //         ->addColumn('status', function ($payment) {
    //             $status      = $payment->status;
    //             $statusLabel = '';
    //             if ($status == 'completed') {
    //                 $statusLabel = '<span class="badge bg-success">' . get_phrase('Completed') . '</span>';
    //             } elseif ($status == 'pending') {
    //                 $statusLabel = '<span class="badge bg-warning">' . get_phrase('Pending') . '</span>';
    //             } elseif ($status == 'failed') {
    //                 $statusLabel = '<span class="badge bg-danger">' . get_phrase('Failed') . '</span>';
    //             }
    //             return $statusLabel;
    //         })
    //         ->rawColumns(['id', 'timestamp_start', 'project', 'payment', 'payment_method', 'status'])
    //         ->setRowClass(function () {
    //             return 'context-menu';
    //         })
    //         ->make(true);
    // }

    public function client_report_server_side($string, $project, $paymentMethod, $status, $minAmount, $maxAmount)
    {
        // $query = Payment::query();
        // $query = $query->select('*')->groupBy('user_id');
        $query = Payment::query();
        $query = $query->select('user_id', DB::raw('SUM(amount) as total_amount'))
            ->groupBy('user_id');

        // if (!empty($string)) {
        //     $query->where(function ($q) use ($string) {
        //         $q->where('id', 'like', "%{$string}%")
        //             ->orWhereHas('project', function ($projectQuery) use ($string) {
        //                 $projectQuery->where('title', 'like', "%{$string}%");
        //             });
        //     });
        // }

        // if ($project != 'all') {
        //     $query->where('project_id', $project);
        // }

        // if ($paymentMethod != 'all') {
        //     $query->where('payment_method', $paymentMethod);
        // }

        // if ($status != 'all') {
        //     $query->where('status', $status);
        // }

        // $minAmount = (int) $minAmount;
        // $maxAmount = (int) $maxAmount;
        // if ($minAmount > 0 && $maxAmount > 0 && is_numeric($minAmount) && is_numeric($maxAmount)) {
        //     $query->whereBetween('payment', [$minAmount, $maxAmount]);
        // }

        // Get distinct client ids for mapping
        // $clients = Project::distinct('client_id')->pluck('client_id')->mapWithKeys(function ($id) {
        //     return [$id => get_user($id)->name ?? '-'];
        // });

        return datatables()
            ->eloquent($query)
            ->addColumn('id', function ($payment) {
                return '        <div class="d-flex align-items-center">
                                    <input type="checkbox" class="checkbox-item me-2 table-checkbox">
                                    <p class="row-number fs-12px">' . $payment->id . '</p>
                                    <input type="hidden" class="datatable-row-id" value="' . $payment->id . '">
                                </div>';
            })
            ->addColumn('date', function ($payment) {
                return date('Y-m-d', strtotime($payment->timestamp_start));
            })
            ->addColumn('user_id', function ($payment) {
                return $payments->user_id ?? '-';
            })
            ->addColumn('amount', function ($payment) {
                return currency($payment->payment);
            })
            ->addColumn('payment_method', function ($payment) {
                return $payment->payment_method;
            })
            ->addColumn('status', function ($payment) {
                $status      = $payment->status;
                $statusLabel = '';
                if ($status == 'completed') {
                    $statusLabel = '<span class="badge bg-success">' . get_phrase('Completed') . '</span>';
                } elseif ($status == 'pending') {
                    $statusLabel = '<span class="badge bg-warning">' . get_phrase('Pending') . '</span>';
                } elseif ($status == 'failed') {
                    $statusLabel = '<span class="badge bg-danger">' . get_phrase('Failed') . '</span>';
                }
                return $statusLabel;
            })
            ->rawColumns(['id', 'timestamp_start', 'user_id', 'payment', 'payment_method', 'status'])
            ->setRowClass(function () {
                return 'context-menu';
            })
            ->make(true);
    }

    public function user_server_side($string, $name, $email)
    {
        $role  = request()->route()->parameter('type');
        $query = User::query();
        $query->whereHas('role', function ($q) use ($role) {
            $q->where('title', $role);
        });

        // General string search
        // if (!empty($string)) {
        //     $query->where(function ($q) use ($string) {
        //         $q->where('name', 'like', "%{$string}%")
        //             ->orWhere('email', 'like', "%{$string}%")
        //             ->orWhere('id', 'like', "%{$string}%");
        //     });
        // }

        // // Filter by name if provided
        // if (!empty($name)) {
        //     $query->where('name', 'like', "%{$name}%");
        // }

        // // Filter by email if provided
        // if (!empty($email)) {
        //     $query->where('email', 'like', "%{$email}%");
        // }

        return datatables()
            ->eloquent($query)
            ->addColumn('id', function ($user) {
                static $key = 1;
                return '
            <div class="d-flex align-items-center">
                <input type="checkbox" class="checkbox-item me-2 table-checkbox">
                <p class="row-number fs-12px">' . $key++ . '</p>
                <input type="hidden" class="datatable-row-id" value="' . $user->id . '">
            </div>';
            })
            ->addColumn('name', function ($user) {
                return $user?->name;
            })
            ->addColumn('email', function ($user) {
                return $user?->email;
            })
            ->addColumn('options', function ($user) {
                $editRoute   = route(get_current_user_role() . '.user.edit', $user->id);
                $deleteRoute = route(get_current_user_role() . '.user.delete', $user->id);

                return '
            <div class="dropdown disable-right-click ol-icon-dropdown ol-icon-dropdown-transparent">
                <button class="btn ol-btn-secondary dropdown-toggle m-auto" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <span class="fi-rr-menu-dots-vertical"></span>
                </button>
                <ul class="dropdown-menu">
                    <li>
                        <a class="dropdown-item" onclick="rightCanvas(\'' . $editRoute . '\', \'Edit user\')" href="#">' . get_phrase('Edit') . '</a>
                    </li>
                    <li>
                        <a class="dropdown-item" onclick="confirmModal(\'' . $deleteRoute . '\')" href="javascript:void(0)">' . get_phrase('Delete') . '</a>
                    </li>
                </ul>
            </div>';
            })
            ->addColumn('context_menu', function ($user) {
                $editRoute   = route(get_current_user_role() . '.user.edit', $user->id);
                $deleteRoute = route(get_current_user_role() . '.user.delete', $user->id);
                // Generate the context menu
                $contextMenu = [
                    'Edit'   => [
                        'type'        => 'ajax',
                        'name'        => 'Edit',
                        'action_link' => $editRoute,
                        'title'       => 'Edit user',
                    ],
                    'Delete' => [
                        'type'        => 'ajax',
                        'name'        => 'Delete',
                        'action_link' => $deleteRoute,
                        'title'       => 'Delete user',
                    ],
                ];

                // JSON encode with unescaped slashes for cleaner URLs
                return json_encode($contextMenu, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
            })
            ->rawColumns(['id', 'name', 'email', 'options'])
            ->setRowClass(function () {
                return 'context-menu';
            })
            ->make(true);
    }

}
