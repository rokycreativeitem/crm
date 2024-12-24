<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;

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
        // $project_status = ['completed', 'in_progress', 'not_started'];
        // $status         = collect($project_status)->map(function ($status) {
        //     return [
        //         'title'  => $status,
        //         'amount' => Project::where('status', $status)->count(),
        //     ];
        // });
        // $page_data['project_status'] = $status;

        // $page_data['users']  = User::get();
        // $page_data['staffs'] = User::where('role_id', 3)->get();
        // $page_data['team']   = Project::where('id', $this->project->id)->first();

        return view('dashboard.admin_dashboard');
    }
    public function client_dashboard()
    {
        return view('dashboard.client_dashboard');
    }
    public function staff_dashboard()
    {
        return view('dashboard.staff_dashboard');
    }
}
