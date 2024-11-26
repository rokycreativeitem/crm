<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Project;

class ReportController extends Controller
{

    public function project_report()
    {
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
