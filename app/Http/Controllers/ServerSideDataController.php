<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Project;
use Illuminate\Http\Request;

class ServerSideDataController extends Controller
{

    public function project_server_side($string, $category, $status, $client, $staff, $minPrice, $maxPrice) {
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
        if($category != 'all') {
            $filter_count[] = $category;
            $query->where(function ($q) use ($category) {
                $q->where('category_id', $category);
            });
        }
        if($status != 'all') {
            $filter_count[] = $status;
            $query->where(function ($q) use ($status) {
                $q->where('status', $status);
            });
        }
        if($client != 'all') {
            $filter_count[] = $client;
            $query->where(function ($q) use ($client) {
                $q->where('client_id', $client);
            });
        }
        if($staff != 'all') {
            $filter_count[] = $staff;
            $staff = json_encode($staff);
            $staff = str_replace('[','',$staff);
            $staff = str_replace(']','',$staff);
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
                    <input type="hidden" class="datatable-row-id" value="'.$project->id.'">
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
            $staffs = $project->staffs ? json_decode($project->staffs, true) : [];
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
            return $statusLabel;
        })
        ->addColumn('options', function ($project) {
            // Generate routes dynamically
            $editRoute = route(get_current_user_role() . '.project.edit', $project->code);
            $deleteRoute = route(get_current_user_role() . '.project.delete', $project->code);
            $viewRoute = route(get_current_user_role() . '.project.details', $project->code);
            
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
        ->rawColumns(['id','title','code','client','staff','budget','progress','status','options'])
        ->setRowClass(function () {
            return 'context-menu';
        })
        ->with('filter_count', count($filter_count))
        ->make(true); 
    }

    function category_server_side($string, $category, $status, $client, $staff, $minPrice, $maxPrice) {
        $query = Category::query();
        if (!empty($string)) {
            $query->where(function ($q) use ($string) {
                $q->where('name', 'like', "%{$string}%");
            });
        }
        $filter_count = [];

        return datatables()
        ->eloquent($query)
        ->addColumn('id', function ($category) {
            static $key = 1;
            return '
                <div class="d-flex align-items-center">
                    <input type="checkbox" class="checkbox-item me-2 table-checkbox">
                    <p class="row-number fs-12px">' . $key++ . '</p>
                    <input type="hidden" class="datatable-row-id" value="'.$category->id.'">
                </div>
            ';
        })
        ->addColumn('name', function ($category) {
            return $category?->name;
        })
        ->addColumn('parent', function ($category) {
            $category_parent = Category::find($category->id);
            return $category_parent->name;
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
            // Generate routes dynamically
            $editRoute = route(get_current_user_role() . '.project.edit', $category->id);
            $deleteRoute = route(get_current_user_role() . '.project.category.delete', $category->id);
            $viewRoute = route(get_current_user_role() . '.project.details', $category->id);
            
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
        ->rawColumns(["id","name","parent","status","options"])
        ->setRowClass(function () {
            return 'context-menu';
        })
        ->with('filter_count', count($filter_count))
        ->make(true); 
    }
}
