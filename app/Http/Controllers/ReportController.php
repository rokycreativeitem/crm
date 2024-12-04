<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Project;
use Illuminate\Http\Request;

class ReportController extends Controller
{

    public function project_report(Request $request)
    {

        if ($request->ajax()) {
            return app(ServerSideDataController::class)->project_report_server_side(
                $request->custom_search_box,
                $request->project,
                $request->payment_method,
                $request->status,
                $request->min_payment,
                $request->max_payment
            );
        }

        $query = Payment::query();

        if (request()->has('start_date') && request()->has('end_date')) {
            $start_date = request()->query('start_date');
            $end_date   = request()->query('end_date');

            $query = $query->whereBetween('timestamp_start', [$start_date, $end_date]);
        }

        $payments = Project::distinct('title')->pluck('title')->toArray();
        dd($payments);
        $data = [];
        foreach ($payments as $payment) {
            $data[] = [
                'project' => $payment->project->title ?? '-',
                // 'amount'  => Payment::where('user_id', $payment)->sum('payment'),
            ];
        }

        $payments = $query->get()->map(function ($payment) {
            return [
                'project' => $payment->project->title ?? '-',
                'amount'  => $payment->payment,
            ];
        });

        $page_data['payments'] = $payments;

        return view('reports.project_report', $page_data);
    }

    public function client_report(Request $request)
    {
        if ($request->ajax()) {
            return app(ServerSideDataController::class)->client_report_server_side(
                $request->custom_search_box,
                $request->client,
                $request->payment_method,
                $request->status,
                $request->min_payment,
                $request->max_payment
            );
        }

        $query = Payment::query();

        if (request()->has('start_date') && request()->has('end_date')) {
            $start_date = request()->query('start_date');
            $end_date   = request()->query('end_date');

            $query = $query->whereBetween('timestamp_start', [$start_date, $end_date]);
        }

        $users = Project::distinct('user_id')->pluck('client_id')->toArray();
        $data  = [];
        foreach ($users as $user) {
            $data[] = [
                'client' => get_user($user)->name,
                'amount' => Payment::where('user_id', $user)->sum('payment'),
            ];
        }

        $page_data['payments'] = $data;

        return view('reports.client_report', $page_data);
    }

}
