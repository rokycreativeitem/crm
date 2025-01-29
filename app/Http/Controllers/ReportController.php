<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Payment_gateway;
use App\Models\Payment_history;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{

    public function project_report(Request $request)
    {

        if ($request->ajax()) {
            return app(ServerSideDataController::class)->project_report_server_side($request->customSearch, $request->payment_method, $request->start_date, $request->end_date);
        }

        
        $payments = Project::distinct('title')->pluck('title')->toArray();
        
        $data = [];
        foreach ($payments as $payment) {
            $data[] = [
                'project' => $payment->project->title ?? '-',
                // 'amount'  => Payment::where('user_id', $payment)->sum('payment'),
            ];
        }
        
        $payments = Payment_history::with('project')
        ->orderBy('id', 'DESC')
        ->get()
        ->groupBy('project_code')
        ->map(function ($group) {
            return [
                'project' => $group->first()->project->title ?? '-',
                'amount'  => $group->sum('amount'),
            ];
        })->values();

        $page_data['payments']         = $payments;
        $page_data['payment_gateways'] = Payment_gateway::get();

        return view('reports.project_report', $page_data);
    }

    public function client_report(Request $request)
    {
        if ($request->ajax()) {
            return app(ServerSideDataController::class)->client_report_server_side($request->customSearch, $request->start_date, $request->end_date);
        }

        // $users = Project::distinct('user_id')->pluck('client_id')->toArray();
        // $data  = [];
        // foreach ($users as $user) {
        //     $data[] = [
        //         'client' => get_user($user)?->name,
        //         'amount' => Invoice::where('user_id', $user)->sum('payment'),
        //     ];
        // }

        $payments = Payment_history::with('project')
        ->orderBy('id', 'DESC')
        ->get()
        ->groupBy('user_id')
        ->map(function ($group) {
            return [
                'project' => $group->first()->project->title ?? '-',
                'amount'  => $group->sum('amount'),
            ];
        })->values();

        $page_data['payments']         = $payments;
        $page_data['payment_history'] = Payment_history::get();

        return view('reports.client_report', $page_data);
    }

    public function payment_history(Request $request)
    {

        if ($request->ajax()) {
            return app(ServerSideDataController::class)->payments_report_server_side(
                $request->custom_search_box,

            );
        }
        $page_data['payment_history']  = Payment_history::get();
        $page_data['payment_gateways'] = Payment_gateway::get();

        return view('reports.payment_history', $page_data);
    }

}
