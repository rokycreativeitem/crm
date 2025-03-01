<?php

namespace App\Http\Controllers;

use App\Models\Payment_history;
use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    // private $code;
    // private $project;
    // public function __construct()
    // {
    //     $this->code    = request()->route()->parameter('code');
    //     $this->project = Project::where('code', $this->code)->first();
    // }
    public function admin_dashboard()
    {
        $project_status = ['completed', 'in_progress', 'not_started'];
        $status         = collect($project_status)->map(function ($status) {
            return [
                'title'  => ucwords(str_replace('_',' ',$status)),
                'amount' => Project::where('status', $status)->count(),
            ];
        });

        $revenue_status = collect(range(1, 12))->map(function ($month) {
            $monthName = Carbon::create()->month($month)->format('M');
            
            return [
                'title'  => $monthName,
                'amount' => Payment_history::whereYear(DB::raw("FROM_UNIXTIME(date_added)"), now()->year)
                ->whereMonth(DB::raw("FROM_UNIXTIME(date_added)"), $month)
                ->sum('amount'),
            ];
        });

        $page_data['project_status'] = $status;
        $page_data['revenue'] = $revenue_status;
        $page_data['resent_projects'] = Project::orderBy('id','DESC')->limit(5)->get();
        $page_data['active_projects'] = Project::where('status','in_progress')->limit(5)->get();
        $page_data['resent_tasks'] = Task::orderBy('id','DESC')->limit(5)->get();

        $page_data['clients'] = User::where('role_id', 2)->get();
        $page_data['staffs'] = User::where('role_id', 3)->get();
        // $page_data['team']   = Project::where('id', $this->project->id)->first();

        return view('dashboard.admin_dashboard', $page_data);
    }
    public function client_dashboard()
    {
        $user = Auth::user();

        // $project_status = ['completed', 'in_progress', 'not_started'];
        // $status         = collect($project_status)->map(function ($status) {
        //     $user = Auth::user();
        //     return [
        //         'title'  => ucwords(str_replace('_',' ',$status)),
        //         'amount' => Project::whereJsonContains('staffs', (string) $user->id)->where('status', $status)->count(),
        //     ];
        // });

        // $revenue_status = collect(range(1, 12))->map(function ($month) {
        //     $monthName = Carbon::create()->month($month)->format('M');
        //     $user = Auth::user();
        //     return [
        //         'title'  => $monthName,
        //         'amount' => Payment_history::whereYear(DB::raw("FROM_UNIXTIME(date_added)"), now()->year)
        //         ->whereMonth(DB::raw("FROM_UNIXTIME(date_added)"), $month)
        //         ->sum('amount'),
        //     ];
        // });

        $page_data['resent_projects'] = Project::where('client_id', $user->id)->orderBy('id','DESC')->limit(5)->get();
        $page_data['resent_tasks'] = Task::whereJsonContains('team', (string) $user->id)->orderBy('id','DESC')->limit(5)->get();
        // $page_data['project_status'] = $status;
        // $page_data['revenue'] = $revenue_status;
        $page_data['active_projects'] = Project::where('client_id', $user->id)->where('status','in_progress')->get();

        return view('dashboard.client_dashboard', $page_data);
    }
    public function staff_dashboard()
    {
        $user = Auth::user();

        $project_status = ['completed', 'in_progress', 'not_started'];
        $status         = collect($project_status)->map(function ($status) {
            $user = Auth::user();
            return [
                'title'  => ucwords(str_replace('_',' ',$status)),
                'amount' => Project::whereJsonContains('staffs', (string) $user->id)->where('status', $status)->count(),
            ];
        });

        $revenue_status = collect(range(1, 12))->map(function ($month) {
            $monthName = Carbon::create()->month($month)->format('M');
            $user = Auth::user();
            return [
                'title'  => $monthName,
                'amount' => Payment_history::whereYear(DB::raw("FROM_UNIXTIME(date_added)"), now()->year)
                ->whereMonth(DB::raw("FROM_UNIXTIME(date_added)"), $month)
                ->sum('amount'),
            ];
        });

        $page_data['resent_projects'] = Project::whereJsonContains('staffs', (string) $user->id)->orderBy('id','DESC')->limit(5)->get();
        $page_data['resent_tasks'] = Task::whereJsonContains('team', (string) $user->id)->orderBy('id','DESC')->limit(5)->get();
        $page_data['project_status'] = $status;
        $page_data['revenue'] = $revenue_status;
        $page_data['clients'] = User::where('role_id', 2)->get();
        $page_data['staffs'] = User::where('role_id', 3)->get();
        $page_data['active_projects'] = Project::where('status','in_progress')->get();

        return view('dashboard.staff_dashboard', $page_data);
    }

}
