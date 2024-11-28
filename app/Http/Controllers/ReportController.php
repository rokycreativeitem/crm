<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;

class ReportController extends Controller
{

    public function project_report(Request $request)
    {

        if ($request->ajax()) {
            // return $request->payment_method;
            return app(ServerSideDataController::class)->report_server_side(
                $request->custom_search_box,
                $request->payment_method,
                $request->status,
                $request->min_payment,
                $request->max_payment,
            );
        }

        $query = Payment::query();

        if (request()->has('start_date') && request()->has('end_date')) {
            $start_date = request()->query('start_date');
            $end_date   = request()->query('end_date');

            $query = $query->whereBetween('timestamp_start', [$start_date, $end_date]);
        }

        $page_data['payments'] = $query->get();

        return view('reports.project_report', $page_data);
    }

    public function client_report()
    {
        $query = Payment::query();
        if (request()->has('start_date') && request()->has('end_date')) {
            $start_date = request()->query('start_date');
            $end_date   = request()->query('end_date');

            $query = $query->whereBetween('timestamp_start', [$start_date, $end_date]);
        }

        $page_data['payments'] = $query->get();

        return view('reports.client_report', $page_data);
    }

}
