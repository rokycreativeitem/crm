<?php

namespace App\Http\Controllers;

use App\Models\Addon;
use App\Models\Category;
use App\Models\File;
use App\Models\Invoice;
use App\Models\Meeting;
use App\Models\Milestone;
use App\Models\offlinePayment;
use App\Models\Payment_history;
use App\Models\Payment_purpose;
use App\Models\Project;
use App\Models\Role;
use App\Models\RolePermission;
use App\Models\Task;
use App\Models\Timesheet;
use App\Models\User;
use Faker\Provider\ar_EG\Payment;
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
        if ($category && $category != 'all') {
            $filter_count[] = $category;
            $query->where(function ($q) use ($category) {
                $q->where('category_id', $category);
            });
        }
        if ($status && $status != 'all') {
            $filter_count[] = $status;
            $query->where(function ($q) use ($status) {
                $q->where('status', $status);
            });
        }
        if ($client && $client != 'all') {
            $filter_count[] = $client;
            $query->where(function ($q) use ($client) {
                $q->where('client_id', $client);
            });
        }
        if ($staff && $staff != 'all') {
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
                return $project->user?->name;
            })
            ->addColumn('staff', function ($project) {
                $staffs     = $project->staffs ? json_decode($project->staffs, true) : [];
                $staffNames = [];
                foreach ($staffs as $staff) {
                    $user = get_user($staff);
                    if ($user) {
                        $staffNames[] = $user?->name;
                    }
                }
                return implode(', ', $staffNames);
            })
            ->addColumn('budget', function ($project) {
                return currency($project->budget);
            })
            ->addColumn('progress', function ($project) {
                $progress = $project->progress;
                return '<div class="dAdmin_profile d-flex gap-2 align-items-center min-w-200px">
                <div class="progress">
                    <div class="progress-bar bg-primary" role="progressbar"
                    style="width: ' . $progress . '%; "
                    aria-valuenow="' . $progress . '" aria-valuemin="0"
                    aria-valuemax="100">
                    </div>
                </div>
                 <span class="fs-12px">' . $progress . '%</span>
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

                $options = '';
                if (has_permission('project.edit')) {
                    $options .= '
                        <li>
                            <a class="dropdown-item" onclick="rightCanvas(\'' . $editRoute . '\', \'Edit project\')" href="javascript:void(0)">' . get_phrase('Edit') . '</a>
                        </li>
                    ';
                }
                if (has_permission('project.delete')) {
                    $options .= '
                        <li>
                            <a class="dropdown-item" onclick="confirmModal(\'' . $deleteRoute . '\')" href="javascript:void(0)">' . get_phrase('Delete') . '</a>
                        </li>
                    ';
                }
                if (has_permission('project.details')) {
                    $options .= '
                        <li>
                            <a class="dropdown-item" href="' . $viewRoute . '">' . get_phrase('View Project') . '</a>
                        </li>
                    ';
                }
                if (empty($options)) {
                    $options = '<li><span class="dropdown-item text-muted">' . get_phrase('No actions available') . '</span></li>';
                }

                return '
                    <div class="dropdown disable-right-click ol-icon-dropdown ol-icon-dropdown-transparent">
                        <button class="btn ol-btn-secondary dropdown-toggle m-auto" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <span class="fi-rr-menu-dots-vertical fs-12px"></span>
                        </button>
                        <ul class="dropdown-menu">' . $options . '</ul>
                    </div>
                ';
            })

            ->addColumn('context_menu', function ($project) {
                $editRoute      = route(get_current_user_role() . '.project.edit', $project->code);
                $deleteRoute    = route(get_current_user_role() . '.project.delete', $project->code);
                $dashboardRoute = route(get_current_user_role() . '.project.details', ['code' => $project->code, 'tab' => 'dashboard']);
                $milestoneRoute = route(get_current_user_role() . '.project.details', ['code' => $project->code, 'tab' => 'milestone']);
                $milestoneRoute = route(get_current_user_role() . '.project.details', ['code' => $project->code, 'tab' => 'milestone']);
                $taskRoute      = route(get_current_user_role() . '.project.details', ['code' => $project->code, 'tab' => 'task']);
                $fileRoute      = route(get_current_user_role() . '.project.details', ['code' => $project->code, 'tab' => 'file']);
                $meetingRoute   = route(get_current_user_role() . '.project.details', ['code' => $project->code, 'tab' => 'meeting']);
                $invoiceRoute   = route(get_current_user_role() . '.project.details', ['code' => $project->code, 'tab' => 'invoice']);
                $ganttRoute     = route(get_current_user_role() . '.project.details', ['code' => $project->code, 'tab' => 'gantt_chart']);
                $timesheetRoute = route(get_current_user_role() . '.project.details', ['code' => $project->code, 'tab' => 'timesheet']);
                $contextMenu    = [];

                if (has_permission('project.details')) {
                    $contextMenu['Dashboard'] = [
                        'type'        => 'ajax',
                        'name'        => get_phrase('Dashboard'),
                        'action_link' => $dashboardRoute,
                        'title'       => get_phrase('Dashboard'),
                    ];
                    if (has_permission('milestones')) {
                        $contextMenu['Milestone'] = [
                            'type'        => 'ajax',
                            'name'        => get_phrase('Milestone'),
                            'action_link' => $milestoneRoute,
                            'title'       => get_phrase('Milestone'),
                        ];
                    }
                    if (has_permission('tasks')) {
                        $contextMenu['Task'] = [
                            'type'        => 'ajax',
                            'name'        => get_phrase('Task'),
                            'action_link' => $taskRoute,
                            'title'       => get_phrase('Task'),
                        ];
                    }
                    if (has_permission('files')) {
                        $contextMenu['File'] = [
                            'type'        => 'ajax',
                            'name'        => get_phrase('File'),
                            'action_link' => $fileRoute,
                            'title'       => get_phrase('File'),
                        ];
                    }
                    if (has_permission('meetings')) {
                        $contextMenu['Meeting'] = [
                            'type'        => 'ajax',
                            'name'        => get_phrase('Meeting'),
                            'action_link' => $meetingRoute,
                            'title'       => get_phrase('Meeting'),
                        ];
                    }
                    if (has_permission('invoice')) {
                        $contextMenu['Invoice'] = [
                            'type'        => 'ajax',
                            'name'        => get_phrase('Invoice'),
                            'action_link' => $invoiceRoute,
                            'title'       => get_phrase('Invoice'),
                        ];
                    }
                    if (has_permission('timesheets')) {
                        $contextMenu['Timesheet'] = [
                            'type'        => 'ajax',
                            'name'        => get_phrase('Timesheet'),
                            'action_link' => $timesheetRoute,
                            'title'       => get_phrase('Timesheet'),
                        ];
                    }
                    if (has_permission('gantt.chart')) {
                        $contextMenu['Gantt'] = [
                            'type'        => 'ajax',
                            'name'        => get_phrase('Gantt Chart'),
                            'action_link' => $ganttRoute,
                            'title'       => get_phrase('Gantt Chart'),
                        ];
                    }
                    if (has_permission('project.edit')) {
                        $contextMenu['Edit'] = [
                            'type'        => 'ajax',
                            'name'        => get_phrase('Edit'),
                            'action_link' => $editRoute,
                            'title'       => get_phrase('Edit project'),
                        ];
                    }
                    if (has_permission('project.delete')) {
                        $contextMenu['Delete'] = [
                            'type'        => 'ajax',
                            'name'        => get_phrase('Delete'),
                            'action_link' => $deleteRoute,
                            'title'       => get_phrase('Delete project'),
                        ];
                    }
                }
                // Fallback for empty context menu
                if (empty($contextMenu)) {
                    $contextMenu = [
                        'NoActions' => [
                            'type'  => 'info',
                            'name'  => get_phrase('No actions available'),
                            'action_link' => 'javascript:void(0)',
                            'title' => get_phrase('No actions are permitted for this project'),
                        ],
                    ];
                }
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

    public function category_server_side($string)
{
    // Fetch all categories
    $categories = Category::orderBy('parent', 'asc')->orderBy('id', 'asc')->get();

    // Recursive function to arrange categories in a hierarchical order
    function getHierarchicalCategories($categories, $parentId = 0, &$result = [])
    {
        foreach ($categories as $category) {
            if ($category->parent == $parentId) {
                $result[] = $category;
                getHierarchicalCategories($categories, $category->id, $result);
            }
        }
        return $result;
    }

    // Get properly ordered categories
    $sortedCategories = getHierarchicalCategories($categories);

    // Apply search filter if required
    if (!empty($string)) {
        $sortedCategories = collect($sortedCategories)->filter(function ($category) use ($string) {
            return stripos($category->name, $string) !== false;
        })->values();
    }

    return datatables()
        ->collection($sortedCategories) // Use collection instead of eloquent
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
            $dash = '';
            if($category->parent) {
                $dash = '- ';
            }
            return $dash.$category?->name;
        })
        ->addColumn('parent', function ($category) {
            return $category->parent ? Category::find($category->parent)?->name : '';
        })
        ->addColumn('status', function ($category) {
            return $category->status == 1
                ? '<span class="completed">' . get_phrase('Active') . '</span>'
                : '<span class="in_progress">' . get_phrase('De-Active') . '</span>';
        })
        ->addColumn('options', function ($category) {
            $editRoute   = route(get_current_user_role() . '.project.category.edit', $category->id);
            $deleteRoute = route(get_current_user_role() . '.project.category.delete', $category->id);
            $options = '';

            if (has_permission('project.category.edit')) {
                $options .= '
                    <li>
                        <a class="dropdown-item" onclick="rightCanvas(\'' . $editRoute . '\', \'Edit category\')" href="javascript:void(0)">' . get_phrase('Edit') . '</a>
                    </li>
                ';
            }
            if (has_permission('project.category.delete')) {
                $options .= '
                    <li>
                        <a class="dropdown-item" onclick="confirmModal(\'' . $deleteRoute . '\')" href="javascript:void(0)">' . get_phrase('Delete') . '</a>
                    </li>
                ';
            }
            if (empty($options)) {
                $options = '<li><span class="dropdown-item text-muted">' . get_phrase('No actions available') . '</span></li>';
            }

            return '
                <div class="dropdown disable-right-click ol-icon-dropdown ol-icon-dropdown-transparent">
                    <button class="btn ol-btn-secondary dropdown-toggle m-auto" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <span class="fi-rr-menu-dots-vertical"></span>
                    </button>
                    <ul class="dropdown-menu">' . $options . '</ul>
                </div>
            ';
        })
        ->rawColumns(["id", "name", "parent", "status", "options"])
        ->setRowClass('context-menu')
        ->with('filter_count', count($sortedCategories))
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

                $options = '';
                if (has_permission('milestone.edit')) {
                    $options .= '
                        <li>
                            <a class="dropdown-item" onclick="rightCanvas(\'' . $editRoute . '\', \'Edit milestone\')" href="javascript:void(0)">' . get_phrase('Edit') . '</a>
                        </li>
                    ';
                }
                if (has_permission('milestone.delete')) {
                    $options .= '
                        <li>
                            <a class="dropdown-item" onclick="confirmModal(\'' . $deleteRoute . '\')" href="javascript:void(0)">' . get_phrase('Delete') . '</a>
                        </li>
                    ';
                }
                if (empty($options)) {
                    $options = '<li><span class="dropdown-item text-muted fs-12px">' . get_phrase('No actions available') . '</span></li>';
                }
                return '
                <div class="dropdown disable-right-click ol-icon-dropdown ol-icon-dropdown-transparent">
                    <button class="btn ol-btn-secondary dropdown-toggle m-auto" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <span class="fi-rr-menu-dots-vertical fs-12px"></span>
                    </button>
                    <ul class="dropdown-menu">' . $options . '</ul>
                </div>
            ';
            })
            ->addColumn('context_menu', function ($milestone) {
                $editRoute   = route(get_current_user_role() . '.milestone.edit', $milestone->id);
                $deleteRoute = route(get_current_user_role() . '.milestone.delete', $milestone->id);
                // Generate the context menu
                $contextMenu = [];
                if (has_permission('milestone.edit')) {
                    $contextMenu['Edit'] = [
                        'type'        => 'ajax',
                        'name'        => get_phrase('Edit'),
                        'action_link' => $editRoute,
                        'title'       => get_phrase('Edit milestone'),
                    ];
                }
                if (has_permission('milestone.delete')) {
                    $contextMenu['Delete'] = [
                        'type'        => 'ajax',
                        'name'        => get_phrase('Delete'),
                        'action_link' => $deleteRoute,
                        'title'       => get_phrase('Delete milestone'),
                    ];
                }
                if (empty($contextMenu)) {
                    $contextMenu = [
                        'NoActions' => [
                            'type'  => 'info',
                            'name'  => get_phrase('No actions available'),
                            'action_link' => 'javascript:void(0)',
                            'title' => get_phrase('No actions are permitted for this project'),
                        ],
                    ];
                }
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

                $options = '';
                if (has_permission('task.edit')) {
                    $options .= '
                        <li>
                            <a class="dropdown-item" onclick="rightCanvas(\'' . $editRoute . '\', \'Edit task\')" href="javascript:void(0)">' . get_phrase('Edit') . '</a>
                        </li>
                    ';
                }
                if (has_permission('task.delete')) {
                    $options .= '
                        <li>
                            <a class="dropdown-item" onclick="confirmModal(\'' . $deleteRoute . '\')" href="javascript:void(0)">' . get_phrase('Delete') . '</a>
                        </li>
                    ';
                }
                if (empty($options)) {
                    $options = '<li><span class="dropdown-item text-muted fs-12px">' . get_phrase('No actions available') . '</span></li>';
                }
                return '
                    <div class="dropdown disable-right-click ol-icon-dropdown ol-icon-dropdown-transparent">
                        <button class="btn ol-btn-secondary dropdown-toggle m-auto" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <span class="fi-rr-menu-dots-vertical"></span>
                        </button>
                        <ul class="dropdown-menu">' . $options . '</ul>
                    </div>
                ';
            })
            ->addColumn('context_menu', function ($task) {
                $editRoute   = route(get_current_user_role() . '.task.edit', $task->id);
                $deleteRoute = route(get_current_user_role() . '.task.delete', $task->id);
                // Generate the context menu
                $contextMenu = [];
                if (has_permission('task.edit')) {
                    $contextMenu['Edit'] = [
                        'type'        => 'ajax',
                        'name'        => get_phrase('Edit'),
                        'action_link' => $editRoute,
                        'title'       => get_phrase('Edit task'),
                    ];
                }
                if (has_permission('task.delete')) {
                    $contextMenu['Delete'] = [
                        'type'        => 'ajax',
                        'name'        => get_phrase('Delete'),
                        'action_link' => $deleteRoute,
                        'title'       => get_phrase('Delete task'),
                    ];
                }
                if (empty($contextMenu)) {
                    $contextMenu = [
                        'NoActions' => [
                            'type'  => 'info',
                            'name'  => get_phrase('No actions available'),
                            'action_link' => 'javascript:void(0)',
                            'title' => get_phrase('No actions are permitted for this project'),
                        ],
                    ];
                }
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
        if ($type != 'all') {
            $filter_count[] = $type;
            $query->where('extension', $type);
        }
        if ($uploaded_by != 'all') {
            $filter_count[] = $uploaded_by;
            $query->where('user_id', $uploaded_by);
        }
        if ($size !== 'all') {
            $filter_count[]          = $size;
            list($minSize, $maxSize) = explode('|', $size);
            $minSize                 = (float) $minSize;
            $maxSize                 = (float) $maxSize;
            $query->whereBetween('size', [$minSize, $maxSize]);
        }

            if (auth()->user()->role_id != 1 && has_permission('file.download')) {
                $getRolePermissions = ["id", "title", "type", "size", "date", "updated_by", "options"];
            } else {
                $getRolePermissions = ["id", "title", "type", "size", "date", "updated_by", "downloaded", "options"];
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
                $editRoute   = route(get_current_user_role() . '.file.edit', $file->id);
                $deleteRoute = route(get_current_user_role() . '.file.delete', $file->id);

                $options = '';
                if (has_permission('file.edit')) {
                    $options .= '
                        <li>
                            <a class="dropdown-item" onclick="rightCanvas(\'' . $editRoute . '\', \'Edit file\')" href="javascript:void(0)">' . get_phrase('Edit') . '</a>
                        </li>
                    ';
                }
                if (has_permission('file.delete')) {
                    $options .= '
                        <li>
                            <a class="dropdown-item" onclick="confirmModal(\'' . $deleteRoute . '\')" href="javascript:void(0)">' . get_phrase('Delete') . '</a>
                        </li>
                    ';
                }
                if (empty($options)) {
                    $options = '<li><span class="dropdown-item text-muted fs-12px">' . get_phrase('No actions available') . '</span></li>';
                }
                return '
                <div class="dropdown disable-right-click ol-icon-dropdown ol-icon-dropdown-transparent">
                    <button class="btn ol-btn-secondary dropdown-toggle m-auto" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <span class="fi-rr-menu-dots-vertical"></span>
                    </button>
                    <ul class="dropdown-menu">' . $options . '</ul>
                </div>
            ';
            })
            ->addColumn('context_menu', function ($file) {
                $editRoute   = route(get_current_user_role() . '.file.edit', $file->id);
                $deleteRoute = route(get_current_user_role() . '.file.delete', $file->id);
                // Generate the context menu
                $contextMenu = [];
                if (has_permission('file.edit')) {
                    $contextMenu['Edit'] = [
                        'type'        => 'ajax',
                        'name'        => get_phrase('Edit'),
                        'action_link' => $editRoute,
                        'title'       => get_phrase('Edit file'),
                    ];
                }
                if (has_permission('file.delete')) {
                    $contextMenu['Delete'] = [
                        'type'        => 'ajax',
                        'name'        => get_phrase('Delete'),
                        'action_link' => $deleteRoute,
                        'title'       => get_phrase('Delete file'),
                    ];
                }
                if (empty($contextMenu)) {
                    $contextMenu = [
                        'NoActions' => [
                            'type'  => 'info',
                            'name'  => get_phrase('No actions available'),
                            'action_link' => 'javascript:void(0)',
                            'title' => get_phrase('No actions are permitted for this project'),
                        ],
                    ];
                }
                // JSON encode with unescaped slashes for cleaner URLs
                return json_encode($contextMenu, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
            })
            ->rawColumns($getRolePermissions)
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

                $options = '';
                if (has_permission('meeting.edit')) {
                    $options .= '
                        <li>
                            <a class="dropdown-item" onclick="rightCanvas(\'' . $editRoute . '\', \'Edit meeting\')" href="javascript:void(0)">' . get_phrase('Edit') . '</a>
                        </li>
                    ';
                }
                if (has_permission('meeting.delete')) {
                    $options .= '
                        <li>
                            <a class="dropdown-item" onclick="confirmModal(\'' . $deleteRoute . '\')" href="javascript:void(0)">' . get_phrase('Delete') . '</a>
                        </li>
                    ';
                }
                if (empty($options)) {
                    $options = '<li><span class="dropdown-item text-muted fs-12px">' . get_phrase('No actions available') . '</span></li>';
                }
                return '
                <div class="dropdown disable-right-click ol-icon-dropdown ol-icon-dropdown-transparent">
                    <button class="btn ol-btn-secondary dropdown-toggle m-auto" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <span class="fi-rr-menu-dots-vertical"></span>
                    </button>
                    <ul class="dropdown-menu">' . $options . '</ul>
                </div>
            ';
            })
            ->addColumn('context_menu', function ($meeting) {
                $editRoute   = route(get_current_user_role() . '.meeting.edit', $meeting->id);
                $deleteRoute = route(get_current_user_role() . '.meeting.delete', $meeting->id);
                // Generate the context menu
                $contextMenu = [];
                if (has_permission('meeting.edit')) {
                    $contextMenu['Edit'] = [
                        'type'        => 'ajax',
                        'name'        => get_phrase('Edit'),
                        'action_link' => $editRoute,
                        'title'       => get_phrase('Edit meeting'),
                    ];
                }
                if (has_permission('meeting.delete')) {
                    $contextMenu['Delete'] = [
                        'type'        => 'ajax',
                        'name'        => get_phrase('Delete'),
                        'action_link' => $deleteRoute,
                        'title'       => get_phrase('Delete meeting'),
                    ];
                }
                if (empty($contextMenu)) {
                    $contextMenu = [
                        'NoActions' => [
                            'type'  => 'info',
                            'name'  => get_phrase('No actions available'),
                            'action_link' => 'javascript:void(0)',
                            'title' => get_phrase('No actions are permitted for this project'),
                        ],
                    ];
                }
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

    public function timesheet_server_side($project_code, $string, $start_date, $end_date, $user)
    {
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
                if ($user) {
                    return $user->name;
                } else {
                    return '';
                }
            })
            ->addColumn('hours', function ($time) {
                $start_time = strtotime($time->timestamp_start);
                $end_time   = strtotime($time->timestamp_end);
                $hours      = round(($end_time - $start_time) / 3600, 2);
                return $hours . ' ' . get_phrase('Hours');
            })

            ->addColumn('to', function ($time) {
                return date('d-M-y h:i A', strtotime($time->timestamp_end));
            })
            ->addColumn('options', function ($time) {
                // Generate routes dynamically .milestone.edit', $milestone->id
                $editRoute   = route(get_current_user_role() . '.timesheet.edit', $time->id);
                $deleteRoute = route(get_current_user_role() . '.timesheet.delete', $time->id);

                $options = '';
                if (has_permission('timesheet.edit')) {
                    $options .= '
                        <li>
                            <a class="dropdown-item" onclick="rightCanvas(\'' . $editRoute . '\', \'Edit project\')" href="javascript:void(0)">' . get_phrase('Edit') . '</a>
                        </li>
                    ';
                }
                if (has_permission('timesheet.delete')) {
                    $options .= '
                        <li>
                            <a class="dropdown-item" onclick="confirmModal(\'' . $deleteRoute . '\')" href="javascript:void(0)">' . get_phrase('Delete') . '</a>
                        </li>
                    ';
                }
                if (empty($options)) {
                    $options = '<li><span class="dropdown-item text-muted fs-12px">' . get_phrase('No actions available') . '</span></li>';
                }
                return '
                <div class="dropdown disable-right-click ol-icon-dropdown ol-icon-dropdown-transparent">
                    <button class="btn ol-btn-secondary dropdown-toggle m-auto" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <span class="fi-rr-menu-dots-vertical"></span>
                    </button>
                    <ul class="dropdown-menu">' . $options . '</ul>
                </div>
            ';
            })
            ->addColumn('context_menu', function ($time) {
                $editRoute   = route(get_current_user_role() . '.timesheet.edit', $time->id);
                $deleteRoute = route(get_current_user_role() . '.timesheet.delete', $time->id);
                // Generate the context menu
                $contextMenu = [];
                if (has_permission('timesheet.edit')) {
                    $contextMenu['Edit'] = [
                        'type'        => 'ajax',
                        'name'        => get_phrase('Edit'),
                        'action_link' => $editRoute,
                        'title'       => get_phrase('Edit timesheet'),
                    ];
                }
                if (has_permission('timesheet.delete')) {
                    $contextMenu['Delete'] = [
                        'type'        => 'ajax',
                        'name'        => get_phrase('Delete'),
                        'action_link' => $deleteRoute,
                        'title'       => get_phrase('Delete timesheet'),
                    ];
                }
                if (empty($contextMenu)) {
                    $contextMenu = [
                        'NoActions' => [
                            'type'  => 'info',
                            'name'  => get_phrase('No actions available'),
                            'action_link' => 'javascript:void(0)',
                            'title' => get_phrase('No actions are permitted for this project'),
                        ],
                    ];
                }
                // JSON encode with unescaped slashes for cleaner URLs
                return json_encode($contextMenu, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
            })
            ->rawColumns(["id", "title", "user", "from", "hours", "to", "options"])
            ->setRowClass(function () {
                return 'context-menu';
            })
            ->with('filter_count', count($filter_count))
            ->make(true);
    }

    public function invoice_server_side($project_code, $string, $date)
    {
        $query = Invoice::query();

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
            ->addColumn('due_date', function ($invoice) {
                if ($invoice->due_date) {
                    return date('d-M-y h:i A', strtotime($invoice?->due_date));
                }
                return '';
            })
            ->addColumn('payment_status', function ($invoice) {
                $statusLabel = '';

                switch ($invoice->payment_status) {
                    case 'processing':
                        $statusLabel = '<span class="processing">' . get_phrase('Processing') . '</span>';
                        break;
                    case 'unpaid':
                        $statusLabel = '<span class="unpaid">' . get_phrase('Unpaid') . '</span>';
                        break;
                    case 'paid':
                        $statusLabel = '<span class="completed">' . get_phrase('Completed') . '</span>';
                        break;
                    default:
                        $statusLabel = '<span class="unknown">' . get_phrase('Unknown') . '</span>';
                        break;
                }
                return $statusLabel;
            })
            ->addColumn('options', function ($invoice) {
                // Generate routes dynamically
                $editRoute    = route(get_current_user_role() . '.invoice.edit', $invoice->id);
                $deleteRoute  = route(get_current_user_role() . '.invoice.delete', $invoice->id);
                $invoiceRoute = route(get_current_user_role() . '.invoice.view', $invoice->id);
                $payoutRoute  = route(get_current_user_role() . '.invoice.payout', $invoice->id);

                $options = '';
                if (has_permission('invoice.edit')) {
                    $options .= '
                            <li>
                                <a class="dropdown-item" onclick="rightCanvas(\'' . $editRoute . '\', \'Edit invoice\')" href="javascript:void(0)">' . get_phrase('Edit') . '</a>
                            </li>
                        ';
                }
                if (has_permission('invoice.delete')) {
                    $options .= '
                            <li>
                                <a class="dropdown-item" onclick="confirmModal(\'' . $deleteRoute . '\')" href="javascript:void(0)">' . get_phrase('Delete') . '</a>
                            </li>
                        ';
                }
                if (has_permission('invoice.view')) {
                    $options .= '
                            <li>
                                <a class="dropdown-item" href="' . $invoiceRoute . '">' . get_phrase('Invoice') . '</a>
                            </li>
                        ';
                }
                if (has_permission('invoice.payout')) {
                    $options .= '
                            <li>
                                <a class="dropdown-item" href="' . $payoutRoute . '">' . get_phrase('Payout') . '</a>
                            </li>
                        ';
                }
                if (empty($options)) {
                    $options = '<li><span class="dropdown-item text-muted fs-12px">' . get_phrase('No actions available') . '</span></li>';
                }
                return '
                <div class="dropdown disable-right-click ol-icon-dropdown ol-icon-dropdown-transparent">
                    <button class="btn ol-btn-secondary dropdown-toggle m-auto" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <span class="fi-rr-menu-dots-vertical"></span>
                    </button>
                    <ul class="dropdown-menu">' . $options . '</ul>
                </div>
                ';
            })
            ->addColumn('context_menu', function ($invoice) {
                $editRoute    = route(get_current_user_role() . '.invoice.edit', $invoice->id);
                $deleteRoute  = route(get_current_user_role() . '.invoice.delete', $invoice->id);
                $invoiceRoute = route(get_current_user_role() . '.invoice.view', $invoice->id);
                // Generate the context menu
                $contextMenu = [];
                if (has_permission('invoice.edit')) {
                    $contextMenu['Edit'] = [
                        'type'        => 'ajax',
                        'name'        => get_phrase('Edit'),
                        'action_link' => $editRoute,
                        'title'       => get_phrase('Edit meeting'),
                    ];
                }
                if (has_permission('invoice.delete')) {
                    $contextMenu['Delete'] = [
                        'type'        => 'ajax',
                        'name'        => get_phrase('Delete'),
                        'action_link' => $deleteRoute,
                        'title'       => get_phrase('Delete meeting'),
                    ];
                }
                if (has_permission('invoice.view')) {
                    $contextMenu['Invoice'] = [
                        'type'        => 'ajax',
                        'name'        => get_phrase('Invoice'),
                        'action_link' => $invoiceRoute,
                        'title'       => get_phrase('View invoice'),
                    ];
                }
                // if (has_permission('invoice.payout')) {
                //     $contextMenu['Payout'] = [
                //         'type'        => 'ajax',
                //         'name'        => get_phrase('Payout'),
                //         'action_link' => $invoiceRoute,
                //         'title'       => get_phrase('Payout invoice'),
                //     ];
                // }
                if (empty($contextMenu)) {
                    $contextMenu = [
                        'NoActions' => [
                            'type'  => 'info',
                            'name'  => get_phrase('No actions available'),
                            'action_link' => 'javascript:void(0)',
                            'title' => get_phrase('No actions are permitted for this project'),
                        ],
                    ];
                }
                // JSON encode with unescaped slashes for cleaner URLs
                return json_encode($contextMenu, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
            })
            ->rawColumns(["id","title","payment","time","due_date","payment_status","options"])
            ->setRowClass(function () {
                return 'context-menu';
            })
            ->with('filter_count', count($filter_count))
            ->make(true);
    }

    public function addon_server_side($string)
    {
        $query = Addon::query();
        if (!empty($string)) {
            $query->where(function ($q) use ($string) {
                $q->where('name', 'like', "%{$string}%");
            });
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
            ->addColumn('name', function ($addon) {
                return $addon?->name;
            })
            ->addColumn('version', function ($addon) {
                return $addon->version;
            })
            ->addColumn('status', function ($addon) {
                if ($addon->status == 1) {
                    $statusLabel = '<span class="completed">' . get_phrase('Active') . '</span>';
                } else {
                    $statusLabel = '<span class="not_started">' . get_phrase('Deactive') . '</span>';
                }
                return $statusLabel;
            })
            ->addColumn('options', function ($addon) {
                // Generate routes dynamically .milestone.edit', $milestone->id
                $editRoute   = route(get_current_user_role() . '.addon.edit', $addon->id);
                $deleteRoute = route(get_current_user_role() . '.addon.delete', $addon->id);

                $options = '';
                if (has_permission('addon.edit')) {
                    $options .= '
                        <li>
                            <a class="dropdown-item" onclick="rightCanvas(\'' . $editRoute . '\', \'Edit addon\')" href="javascript:void(0)">' . get_phrase('Edit') . '</a>
                        </li>
                    ';
                }
                if (has_permission('addon.delete')) {
                    $options .= '
                        <li>
                            <a class="dropdown-item" onclick="confirmModal(\'' . $deleteRoute . '\')" href="javascript:void(0)">' . get_phrase('Delete') . '</a>
                        </li>
                    ';
                }
                if (empty($options)) {
                    $options = '<li><span class="dropdown-item text-muted">' . get_phrase('No actions available') . '</span></li>';
                }
                return '
                <div class="dropdown disable-right-click ol-icon-dropdown ol-icon-dropdown-transparent">
                    <button class="btn ol-btn-secondary dropdown-toggle m-auto" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <span class="fi-rr-menu-dots-vertical"></span>
                    </button>
                    <ul class="dropdown-menu">' . $options . '</ul>
                </div>
            ';
            })
            ->addColumn('context_menu', function ($addon) {
                $editRoute   = route(get_current_user_role() . '.addon.edit', $addon->id);
                $deleteRoute = route(get_current_user_role() . '.addon.delete', $addon->id);
                // Generate the context menu
                $contextMenu = [];
                if (has_permission('addon.edit')) {
                    $contextMenu['Edit'] = [
                        'type'        => 'ajax',
                        'name'        => 'Edit',
                        'action_link' => $editRoute,
                        'title'       => 'Edit addon',
                    ];
                }
                if (has_permission('addon.delete')) {
                    $contextMenu['Delete'] = [
                        'type'        => 'ajax',
                        'name'        => 'Delete',
                        'action_link' => $deleteRoute,
                        'title'       => 'Delete addon',
                    ];
                }
                if (empty($contextMenu)) {
                    $contextMenu = [
                        'NoActions' => [
                            'type'  => 'info',
                            'name'  => get_phrase('No actions available'),
                            'action_link' => 'javascript:void(0)',
                            'title' => get_phrase('No actions are permitted for this project'),
                        ],
                    ];
                }
                // JSON encode with unescaped slashes for cleaner URLs
                return json_encode($contextMenu, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
            })
            ->rawColumns(["id", "name", "version", "status", "options"])
            ->setRowClass(function () {
                return 'context-menu';
            })
            ->make(true);
    }

    public function project_report_server_side($string, $payment_method, $start_date, $minPrice, $maxPrice)
    {
        $query = Payment_history::query();

        $query = $query->select(
            'project_code',
            DB::raw('MAX(date_added) as date_added'),
            DB::raw('SUM(amount) as total_amount'),
            DB::raw('GROUP_CONCAT(DISTINCT payment_type SEPARATOR ", ") as payment_types')
        )->groupBy('project_code');

        $filter_count = [];
        if (!empty($string)) {
            $query->where(function ($q) use ($string) {
                $q->where('project_code', 'like', "%{$string}%")
                ->orWhereHas('project', function ($userQuery) use ($string) {
                    $userQuery->where('title', 'like', "%{$string}%");
                });
            });
        }

        $maxPrice = str_replace('$','',$maxPrice);
        $minPrice = str_replace('$','',$minPrice);
        if ($minPrice > 0 && is_numeric($minPrice) && is_numeric($maxPrice)) {
            $filter_count[] = $minPrice ?? $maxPrice;
            $query->havingRaw('SUM(amount) BETWEEN ? AND ?', [$minPrice, $maxPrice]);
        }

        if ($payment_method != 'all') {
            $filter_count[] = $payment_method;
            $query->where('payment_type', $payment_method);
        }

        
        if (!empty($start_date)) {
            $filter_count[] = $start_date;
            $start_date = date('Y-m-d', strtotime($start_date));
            $query->whereRaw("DATE(FROM_UNIXTIME(date_added)) = ?", [$start_date]);
        }

        return datatables()
            ->eloquent($query)
            ->addColumn('id', function ($report) {
                static $key = 1;
                return '
                <div class="d-flex align-items-center">
                    <p class="row-number fs-12px">' . $key++ . '</p>
                    <input type="hidden" class="datatable-row-id" value="' . $report->id . '">
                </div>';
            })
            ->addColumn('date', function ($report) {
                return date('d-M-y h:i A', $report->date_added);
            })

            ->addColumn('project', function ($report) {
                return Project::where('code', $report->project_code)->first()->title;
            })
            ->addColumn('amount', function ($report) {
                return currency($report->total_amount);
            })
            ->addColumn('payment_types', function ($report) {
                return $report->payment_types;
            })
            ->rawColumns(["id", "date", "project", "amount", "payment_types"])
            ->with('filter_count', count($filter_count))
            ->make(true);
    }

    public function client_report_server_side($string, $payment_method, $start_date, $minPrice, $maxPrice)
    {

        $query = Payment_history::query();

        $query = $query->select(
            'user_id',
            DB::raw('MAX(date_added) as date_added'),
            DB::raw('SUM(amount) as total_amount'),
            DB::raw('GROUP_CONCAT(DISTINCT payment_type SEPARATOR ", ") as payment_types')
        )->groupBy('user_id');

        if (!empty($string)) {
            $query->where(function ($q) use ($string) {
                $q->where('project_code', 'like', "%{$string}%")
                ->orWhereHas('user', function ($userQuery) use ($string) {
                    $userQuery->where('name', 'like', "%{$string}%");
                });
            });
        }

        $filter_count = [];

        $maxPrice = str_replace('$','',$maxPrice);
        $minPrice = str_replace('$','',$minPrice);
       
        if ($minPrice > 0 && is_numeric($minPrice) && is_numeric($maxPrice)) {
            $filter_count[] = $minPrice ?? $maxPrice;
            // $query->whereBetween('amount', [$minPrice, $maxPrice]);
            $query->havingRaw('SUM(amount) BETWEEN ? AND ?', [$minPrice, $maxPrice]);
        }

        if (!empty($start_date)) {
            $filter_count[] = $start_date;
            $start_date = date('Y-m-d', strtotime($start_date));
            $query->whereRaw("DATE(FROM_UNIXTIME(date_added)) = ?", [$start_date]);
        }

        if ($payment_method != 'all') {
            $filter_count[] = $payment_method;
            $query->where('payment_type', $payment_method);
        }

        return datatables()
            ->eloquent($query)
            ->addColumn('id', function ($history) {
                static $key = 1;
                return '<div class="d-flex align-items-center">
                            <input type="checkbox" class="checkbox-item me-2 table-checkbox">
                            <p class="row-number fs-12px">' . $key++ . '</p>
                            <input type="hidden" class="datatable-row-id" value="' . $history->id . '">
                        </div>';
            })
            ->addColumn('date', function ($history) {
                // return date('Y-m-d', strtotime($history->timestamp_start));
                return date('d-M-y h:i A', $history->date_added);
            })
            ->addColumn('client', function ($history) {
                return User::where('id', $history->user_id)->first()->name;
            })
            ->addColumn('amount', function ($history) {
                return currency($history->total_amount);
            })
            ->addColumn('payment_types', function ($history) {
                return $history->payment_types;
            })
            ->rawColumns(["id", "date", "client", "amount", "payment_types"])
            ->with('filter_count', count($filter_count))
            ->make(true);
    }

    public function role_server_side($string, $role)
    {
        $query = Role::query();

        return datatables()
            ->eloquent($query)
            ->addColumn('id', function ($role) {
                static $key = 1;
                return '
            <div class="d-flex align-items-center">
                <input type="checkbox" class="checkbox-item me-2 table-checkbox">
                <p class="row-number fs-12px">' . $key++ . '</p>
                <input type="hidden" class="datatable-row-id" value="' . $role->id . '">
            </div>';
            })
            ->addColumn('role', function ($role) {
                return $role->title ?: '-';
            })
            ->addColumn('options', function ($role) {
                $permissionRoute = route(get_current_user_role() . '.role.permission', ['role' => $role->id]);

                if (has_permission('role.permission')) {
                    return '<div class="text-center">
                    <a class="fs-12px btn ol-btn-outline-secondary m-auto" onclick="modal(\'User Permissions\',\'' . $permissionRoute . '\', \'modal-xl\')">' . get_phrase('Permissions') . '</a>
                    </div>
                    ';
                }
                if (empty($options)) {
                    return '<li><span class="dropdown-item text-muted">' . get_phrase('No actions available') . '</span></li>';
                }
            })
            ->addColumn('context_menu', function ($role) {
                $permissionRoute = route(get_current_user_role() . '.role.permission', $role->title);
                // Generate the context menu
                $contextMenu = [];
                if (has_permission('role.permission')) {
                    $contextMenu['Permissions'] = [
                        'type'        => 'ajax',
                        'name'        => 'Permissions',
                        'action_link' => $permissionRoute,
                        'title'       => 'Edit permissions',
                    ];
                }
                if (empty($contextMenu)) {
                    $contextMenu = [
                        'NoActions' => [
                            'type'  => 'info',
                            'name'  => get_phrase('No actions available'),
                            'action_link' => 'javascript:void(0)',
                            'title' => get_phrase('No actions are permitted for this project'),
                        ],
                    ];
                }
                // JSON encode with unescaped slashes for cleaner URLs
                return json_encode($contextMenu, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
            })
            ->rawColumns(['id', 'title', 'options'])
            ->setRowClass(function () {
                return 'context-menu';
            })
            ->make(true);
    }
    public function user_server_side($string)
    {
        $role  = request()->route()->parameter('type');
        $query = User::query();
        $query->whereHas('role', function ($q) use ($role) {
            $q->where('title', $role);
        });

        if (!empty($string)) {
            $query->where(function ($q) use ($string) {
                $q->where('name', 'like', "%{$string}%")
                    ->orWhere('email', 'like', "%{$string}%");
            });
        }

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
            ->addColumn('photo', function ($user) {

                $photoPath = $user->photo ? get_image($user->photo) : get_image('assets/global/images/default.jpg');

                
            
                $photo = '
                    <img src="'.$photoPath.'" width="40" height="40" class="object-fit rounded" alt="">
                ';
                
                return $photo;
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

                $options = '';
                if (has_permission('user.edit')) {
                    $options .= '
                        <li>
                            <a class="dropdown-item" onclick="rightCanvas(\'' . $editRoute . '\', \'Edit user\')" href="javascript:void(0)">' . get_phrase('Edit') . '</a>
                        </li>
                    ';
                }
                if (has_permission('user.delete')) {
                    $options .= '
                        <li>
                            <a class="dropdown-item" onclick="confirmModal(\'' . $deleteRoute . '\')" href="javascript:void(0)">' . get_phrase('Delete') . '</a>
                        </li>
                    ';
                }
                if (empty($options)) {
                    $options = '<li><span class="dropdown-item text-muted">' . get_phrase('No actions available') . '</span></li>';
                }
                return '
            <div class="dropdown disable-right-click ol-icon-dropdown ol-icon-dropdown-transparent">
                <button class="btn ol-btn-secondary dropdown-toggle m-auto" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <span class="fi-rr-menu-dots-vertical"></span>
                </button>
                <ul class="dropdown-menu">' . $options . '</ul>
            </div>';
            })
            ->addColumn('context_menu', function ($user) {
                $editRoute   = route(get_current_user_role() . '.user.edit', $user->id);
                $deleteRoute = route(get_current_user_role() . '.user.delete', $user->id);
                // Generate the context menu
                $contextMenu = [];
                if (has_permission('user.edit')) {
                    $contextMenu['Edit'] = [
                        'type'        => 'ajax',
                        'name'        => 'Edit',
                        'action_link' => $editRoute,
                        'title'       => 'Edit user',
                    ];
                }
                if (has_permission('user.delete')) {
                    $contextMenu['Delete'] = [
                        'type'        => 'ajax',
                        'name'        => 'Delete',
                        'action_link' => $deleteRoute,
                        'title'       => 'Delete user',
                    ];
                }
                if (empty($contextMenu)) {
                    $contextMenu = [
                        'NoActions' => [
                            'type'  => 'info',
                            'name'  => get_phrase('No actions available'),
                            'action_link' => 'javascript:void(0)',
                            'title' => get_phrase('No actions are permitted for this project'),
                        ],
                    ];
                }
                // JSON encode with unescaped slashes for cleaner URLs
                return json_encode($contextMenu, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
            })
            ->rawColumns(['id', 'photo', 'name', 'email', 'options'])
            ->setRowClass(function () {
                return 'context-menu';
            })
            ->make(true);
    }

    public function offline_payments_server_side($string, $status, $user, $start_date, $minPrice, $maxPrice)
    {
      
        $query = OfflinePayment::query();
        if (!empty($string)) {
            $query->where(function ($q) use ($string) {
                $q->WhereHas('user', function ($userQuery) use ($string) {
                    $userQuery->where('name', 'like', "%{$string}%");
                });                
            });
        }

        $filter_count = [];

        $maxPrice = str_replace('$','',$maxPrice);
        $minPrice = str_replace('$','',$minPrice);
        if ($minPrice > 0 && is_numeric($minPrice) && is_numeric($maxPrice)) {
            $filter_count[] = $minPrice ?? $maxPrice;
            $query->whereBetween('total_amount', [$minPrice, $maxPrice]);
        }

        if ($status != 'all') {
            $filter_count[] = $status;
            $query->where('status', $status);
        }
        if ($user != 'all') {
            $filter_count[] = $user;
            $query->where('user_id', $user);
        }

        
        if (!empty($start_date)) {
            $filter_count[] = $start_date;
            $start_date = date('Y-m-d', strtotime($start_date));
            $query->whereDate("created_at", $start_date);
        }

        return datatables()
            ->eloquent($query)
            ->addColumn('id', function ($payment) {
                static $key = 1;
                return '
            <div class="d-flex align-items-center">
                <input type="checkbox" class="checkbox-item me-2 table-checkbox">
                <p class="row-number fs-12px">' . $key++ . '</p>
                <input type="hidden" class="datatable-row-id" value="' . $payment->id . '">
            </div>';
            })
            ->addColumn('user_info', function ($payment) {
                $user = get_user_info($payment->user_id);
                return '<div class="dAdmin_profile d-flex align-items-center min-w-200px">
                        <div>
                            <h4 class="title fs-14px">' . $user->name . '</h4>
                            <p class="sub-title text-12px">' . $user->email . '</p>
                        </div>
                    </div>';
            })
            ->addColumn('item_type', function ($payment) {
                if ($payment->item_type === 'invoice') {
                    $invoices     = Invoice::whereIn('id', json_decode($payment->items, true))->get();
                    $invoiceLinks = '';
                    foreach ($invoices as $invoice) {
                        $invoiceLinks .= '<p class="sub-title text-12px">
                                        <a href="javascript:void(0)" class="text-muted me-3">' . $invoice->title . '</a>
                                     </p>';
                    }
                    return $invoiceLinks;
                }
                return '';
            })
            ->addColumn('total_amount', function ($payment) {
                return currency($payment->total_amount);
            })
            ->addColumn('date', function ($payment) {
                return '<div class="sub-title2 text-12px">
                        <p>' . date('d-M-y', strtotime($payment->created_at)) . '</p>
                    </div>';
            })
            ->addColumn('download', function ($payment) {
                $route = route('admin.offline.payment.doc', $payment->id);
                return '<a class="download-btn" href="' . $route . '">
                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M4.92958 5.39042L4.92958 5.39041L4.92862 5.3905C3.61385 5.5146 2.6542 5.93651 2.02459 6.70783C1.39588 7.47804 1.10332 8.58816 1.10332 10.0736V10.1603C1.10332 11.8027 1.45436 12.987 2.22713 13.7598C2.99991 14.5326 4.18424 14.8836 5.82665 14.8836H10.1733C11.8157 14.8836 13 14.5326 13.7728 13.7615C14.5456 12.9904 14.8967 11.8094 14.8967 10.1736V10.0869C14.8967 8.59144 14.5991 7.4745 13.9602 6.70257C13.3204 5.92962 12.3457 5.5112 11.0111 5.39715C10.7022 5.36786 10.4461 5.59636 10.4169 5.89543C10.3874 6.19756 10.6157 6.46083 10.9151 6.49005L10.9158 6.4901C11.9763 6.57958 12.6917 6.86862 13.1444 7.43161C13.5984 7.99634 13.7967 8.84694 13.7967 10.0803V10.1669C13.7967 11.5202 13.5567 12.4212 12.9921 12.9858C12.4275 13.5504 11.5265 13.7903 10.1733 13.7903H5.82665C4.47345 13.7903 3.57245 13.5504 3.00784 12.9858C2.44324 12.4212 2.20332 11.5202 2.20332 10.1669V10.0803C2.20332 8.85356 2.39823 8.00609 2.84423 7.44127C3.28876 6.8783 3.99097 6.58615 5.03125 6.49007L5.03139 6.49006C5.33896 6.46076 5.5591 6.18959 5.52975 5.88876C5.50032 5.58704 5.22199 5.36849 4.92958 5.39042Z" fill="#6D718C" stroke="#6D718C" stroke-width="0.1"/>
                    <path d="M7.45 9.92028C7.45 10.2212 7.69905 10.4703 8 10.4703C8.30051 10.4703 8.55 10.2283 8.55 9.92028V1.33362C8.55 1.03267 8.30095 0.783618 8 0.783618C7.69905 0.783618 7.45 1.03267 7.45 1.33362V9.92028Z" fill="#6D718C" stroke="#6D718C" stroke-width="0.1"/>
                    <path d="M7.61153 11.0556C7.7214 11.1655 7.86101 11.2169 8.00022 11.2169C8.13943 11.2169 8.27904 11.1655 8.38891 11.0556L10.6222 8.8223C10.8351 8.60944 10.8351 8.25778 10.6222 8.04492C10.4094 7.83206 10.0577 7.83206 9.84487 8.04492L8.00022 9.88957L6.15558 8.04492C5.94272 7.83206 5.59106 7.83206 5.3782 8.04492C5.16534 8.25778 5.16534 8.60944 5.3782 8.8223L7.61153 11.0556Z" fill="#6D718C" stroke="#6D718C" stroke-width="0.1"/>
                    </svg>
                    </a>';
            })
            ->addColumn('status', function ($payment) {
                $statuses = [
                    1 => '<span class="accepted">' . get_phrase('Accepted') . '</span>',
                    2 => '<span class="suspended">' . get_phrase('Suspended') . '</span>',
                    0 => '<span class="pending">' . get_phrase('Pending') . '</span>',
                ];
                return $statuses[$payment->status] ?? '<span class="badge bg-secondary">Unknown</span>';
            })
            ->addColumn('options', function ($payment) {
                $downloadRoute = route(get_current_user_role() . '.offline.payment.doc', $payment->id);
                $acceptRoute   = route(get_current_user_role() . '.offline.payment.accept', $payment->id);
                $declineRoute  = route(get_current_user_role() . '.offline.payment.decline', $payment->id);

                $options = '';
                if (has_permission('offline.payment.doc')) {
                    $options .= '
                        <li>
                            <a class="dropdown-item" href="' . $downloadRoute . '">' . get_phrase('Download') . '</a>
                        </li>
                    ';
                }
                if (has_permission('offline.payment.accept')) {
                    $options .= '
                        <li>
                            <a class="dropdown-item" href="' . $acceptRoute . '">' . get_phrase('Accept') . '</a>
                        </li>
                    ';
                }
                if (has_permission('offline.payment.decline')) {
                    $options .= '
                        <li>
                            <a class="dropdown-item" href="javascript:void(0)" onclick="confirmModal(\'' . $declineRoute . '\')">' . get_phrase('Decline') . '</a>
                        </li>
                    ';
                }
                if (empty($options)) {
                    $options = '<li><span class="dropdown-item text-muted">' . get_phrase('No actions available') . '</span></li>';
                }
                return '
                <div class="dropdown disable-right-click ol-icon-dropdown ol-icon-dropdown-transparent">
                        <button class="btn ol-btn-secondary dropdown-toggle m-auto" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <span class="fi-rr-menu-dots-vertical"></span>
                        </button>
                        <ul class="dropdown-menu">' . $options . '</ul>
                    </div>';
            })
            ->addColumn('context_menu', function ($payment) {
                $downloadRoute = route(get_current_user_role() . '.offline.payment.doc', $payment->id);
                $acceptRoute   = route(get_current_user_role() . '.offline.payment.accept', $payment->id);
                $declineRoute  = route(get_current_user_role() . '.offline.payment.decline', $payment->id);
                // Generate the context menu
                $contextMenu = [];
                if (has_permission('offline.payment.doc')) {
                    $contextMenu['Download'] = [
                        'type'        => 'ajax',
                        'name'        => get_phrase('Download'),
                        'action_link' => $downloadRoute,
                        'title'       => get_phrase('Download payment document'),
                    ];
                }
                if (has_permission('offline.payment.accept')) {
                    $contextMenu['Accept'] = [
                        'type'        => 'ajax',
                        'name'        => get_phrase('Accept'),
                        'action_link' => $acceptRoute,
                        'title'       => get_phrase('Accept payment'),
                    ];
                }
                if (has_permission('offline.payment.decline')) {
                    $contextMenu['Decline'] = [
                        'type'        => 'ajax',
                        'name'        => get_phrase('Decline'),
                        'action_link' => $declineRoute,
                        'title'       => get_phrase('Decline payment'),
                    ];
                }
                if (empty($contextMenu)) {
                    $contextMenu = [
                        'NoActions' => [
                            'type'  => 'info',
                            'name'  => get_phrase('No actions available'),
                            'action_link' => 'javascript:void(0)',
                            'title' => get_phrase('No actions are permitted for this project'),
                        ],
                    ];
                }
                // JSON encode with unescaped slashes for cleaner URLs
                return json_encode($contextMenu, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
            })
            ->rawColumns(['id', 'user_info', 'item_type', 'total_amount', 'date', 'download', 'status', 'options'])
            ->with('filter_count', count($filter_count))
            ->setRowClass(function () {
                return 'context-menu';
            })
            ->make(true);
    }
    public function payments_report_server_side($string, $start_date, $payment_method, $minPrice, $maxPrice)
    {
        $query = Payment_history::query();

        $query->where(function ($q) use ($string) {
            $q->where('project_code', 'like', "%{$string}%")
            ->orWhereHas('project', function ($userQuery) use ($string) {
                $userQuery->where('title', 'like', "%{$string}%");
            });
        });

        $filter_count = [];
        
        $maxPrice = str_replace('$','',$maxPrice);
        $minPrice = str_replace('$','',$minPrice);
        if ($minPrice > 0 && is_numeric($minPrice) && is_numeric($maxPrice)) {
            $filter_count[] = $minPrice ?? $maxPrice;
            $query->whereBetween('amount', [$minPrice, $maxPrice]);
        }

        // echo $payment_method;
        // die;

        if ($payment_method != 'all') {
            $filter_count[] = $payment_method;
            $query->where('payment_type', $payment_method);
        }

        
        if (!empty($start_date)) {
            $filter_count[] = $start_date;
            $start_date = date('Y-m-d', strtotime($start_date));
            $query->whereRaw("DATE(FROM_UNIXTIME(date_added)) = ?", [$start_date]);
        }


        return datatables()
            ->eloquent($query)
            ->addColumn('id', function ($payment_history) {
                static $key = 1;
                return '
                <div class="d-flex align-items-center">
                    <input type="checkbox" class="checkbox-item me-2 table-checkbox">
                    <p class="row-number fs-12px">' . $key++ . '</p>
                    <input type="hidden" class="datatable-row-id" value="' . $payment_history->id . '">
                </div>
            ';
            })
            ->addColumn('payment_type', function ($payment_history) {
                return $payment_history?->payment_type;
            })
            ->addColumn('invoice_id', function ($payment_history) {
                return Invoice::where('id', $payment_history->invoice_id)->first()->title;
            })
            ->addColumn('amount', function ($payment_history) {
                return currency($payment_history->amount);
            })
            ->addColumn('transaction_id', function ($payment_history) {
                $decodedTransactionId = json_decode($payment_history->transaction_id, true);
                return $decodedTransactionId['reference'] ?? 'No transaction ID';
            })

            ->addColumn('payment_purpose', function ($payment_history) {
                return Payment_purpose::where('id', $payment_history->payment_purpose)->first()->title;
            })
            // return User::where('id', $file->user_id)->first()->name;
            ->addColumn('created_at', function ($payment_history) {
                return date('d-M-y h:i A', strtotime($payment_history->created_at));
            })


            
            ->rawColumns(["id", "payment_type", "invoice_id", "amount", "transaction_id", "payment_purpose", "created_at"])
            ->with('filter_count', count($filter_count))
          
            ->make(true);
    }
}
