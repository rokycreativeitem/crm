<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Payment_gateway;
use App\Models\Payment_history;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;

class ReportController extends Controller
{

    public function project_report(Request $request)
    {

        if ($request->ajax()) {
            return app(ServerSideDataController::class)->project_report_server_side($request->customSearch, $request->payment_method, $request->start_date, $request->minPrice, $request->maxPrice);
        }

        
        $payments = Project::distinct('title')->pluck('title')->toArray();
        
        // $data = [];
        // foreach ($payments as $payment) {
        //     $data[] = [
        //         'project' => $payment->project->title ?? '-',
        //         // 'amount'  => Payment::where('user_id', $payment)->sum('payment'),
        //     ];
        // }
        
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
            return app(ServerSideDataController::class)->client_report_server_side($request->customSearch, $request->payment_method, $request->start_date, $request->minPrice, $request->maxPrice);
        }

        $payments = Payment_history::with('project')
        ->orderBy('id', 'DESC')
        ->get()
        ->groupBy('user_id')
        ->map(function ($group) {
            return [
                'client' => $group->first()->user->name ?? '-',
                'amount'  => $group->sum('amount'),
            ];
        })->values();

        $page_data['payments']         = $payments;
        $page_data['payment_history'] = Payment_history::get();
        $page_data['payment_gateways'] = Payment_gateway::get();

        return view('reports.client_report', $page_data);
    }

    public function payment_history(Request $request)
    {

        if ($request->ajax()) {
            return app(ServerSideDataController::class)->payments_report_server_side($request->customSearch, $request->start_date, $request->payment_method, $request->minPrice, $request->maxPrice);
        }
        $page_data['payment_history']  = Payment_history::get();
        $page_data['payment_gateways'] = Payment_gateway::get();

        return view('reports.payment_history', $page_data);
    }

    public function UserReportExportFile(Request $request, $file) {

        $query = Payment_history::query();

        $query = $query->select(
            'project_code',
            DB::raw('MAX(date_added) as date_added'),
            DB::raw('SUM(amount) as total_amount'),
            DB::raw('GROUP_CONCAT(DISTINCT payment_type SEPARATOR ", ") as payment_types')
        )->groupBy('project_code');

        $all_query = $query->select(
            'project_code',
            DB::raw('MAX(date_added) as date_added'),
            DB::raw('SUM(amount) as total_amount'),
            DB::raw('GROUP_CONCAT(DISTINCT payment_type SEPARATOR ", ") as payment_types')
        )->groupBy('project_code');

        if (isset($request->customSearch)) {
            $string = $request->customSearch;
            $query->where(function ($q) use ($string) {
                $q->where('project_code', 'like', "%{$string}%")
                ->orWhereHas('project', function ($userQuery) use ($string) {
                    $userQuery->where('title', 'like', "%{$string}%");
                });
            });
        }

        $maxPrice = (int) str_replace('$', '', $request->maxPrice);
        $minPrice = (int) str_replace('$', '', $request->minPrice);
        if ($minPrice > 0 || $maxPrice > 0) {
            $query = $query->havingRaw('SUM(amount) BETWEEN ? AND ?', [$minPrice, $maxPrice]);
        }

        if (isset($request->payment_method) && $request->payment_method != 'all') {
            $query->where('payment_type', $request->payment_method);
        }

        
        if (isset($request->start_date) && !empty($start_date)) {
            $start_date = date('Y-m-d', strtotime($request->start_date));
            $query->whereRaw("DATE(FROM_UNIXTIME(date_added)) = ?", [$request->start_date]);
        }
    
        if ($file == 'pdf') {
            $page_data['reports'] = count($request->all()) > 0 ? $query->get() : $all_query->get();
            $pdf = FacadePdf::loadView('reports.project_pdf', $page_data);
            return $pdf->download('project_reports.pdf');
        }

        if ($file == 'print') {
            $page_data['reports'] =count($request->all()) > 0 || $request->customSearch ? $query->get() : $all_query->get();
            $pdf = FacadePdf::loadView('reports.project_pdf', $page_data);
            return $pdf->stream('project_reports.pdf');
        }
    
        if ($file == 'csv') {
            $fileName = 'project_reports.csv';
            $headers = [
                "Content-type"        => "text/csv",
                "Content-Disposition" => "attachment; filename=$fileName",
                "Pragma"              => "no-cache",
                "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
                "Expires"             => "0"
            ];
    
            // Use the filtered query to get the projects for CSV
            $reports = count($request->all()) > 0 ? $query->get() : $all_query->get();
            $columns = ['#', 'project_code', 'payment_types', 'amount', 'date_added'];
            $callback = function() use ($columns, $reports) {
                $file = fopen('php://output', 'w');
                fputcsv($file, $columns);
    
                $count = 1;
                foreach ($reports as $item) {    
                    fputcsv($file, [
                        $count,
                        $item->project_code,
                        $item->payment_types,
                        currency($item->total_amount),
                        date('d-M-y h:i A', $item->date_added)
                    ]);
                    $count++;
                }
    
                fclose($file);
            };
    
            return response()->stream($callback, 200, $headers);
        }
    
        // If no valid file type was provided
        return response()->json(['error' => 'Invalid file type'], 400);
    }

    public function ClientReportExportFile(Request $request, $file) {

        $query = Payment_history::query();

        $query = $query->select(
            'user_id',
            DB::raw('MAX(date_added) as date_added'),
            DB::raw('SUM(amount) as total_amount'),
            DB::raw('GROUP_CONCAT(DISTINCT payment_type SEPARATOR ", ") as payment_types')
        )->groupBy('user_id');

        $all_query = $query->select(
            'user_id',
            DB::raw('MAX(date_added) as date_added'),
            DB::raw('SUM(amount) as total_amount'),
            DB::raw('GROUP_CONCAT(DISTINCT payment_type SEPARATOR ", ") as payment_types')
        )->groupBy('user_id');

        if (isset($request->customSearch)) {
            $string = $request->customSearch;
            $query->where(function ($q) use ($string) {
                $q->where('project_code', 'like', "%{$string}%")
                ->orWhereHas('user', function ($userQuery) use ($string) {
                    $userQuery->where('name', 'like', "%{$string}%");
                });
            });
        }

        $maxPrice = (int) str_replace('$', '', $request->maxPrice);
        $minPrice = (int) str_replace('$', '', $request->minPrice);
        if ($minPrice > 0 || $maxPrice > 0) {
            $query = $query->havingRaw('SUM(amount) BETWEEN ? AND ?', [$minPrice, $maxPrice]);
        }

        if (isset($request->payment_method) && $request->payment_method != 'all') {
            $query->where('payment_type', $request->payment_method);
        }

        
        if (isset($request->start_date) && !empty($start_date)) {
            $start_date = date('Y-m-d', strtotime($request->start_date));
            $query->whereRaw("DATE(FROM_UNIXTIME(date_added)) = ?", [$request->start_date]);
        }
    
        if ($file == 'pdf') {
            $page_data['reports'] = count($request->all()) > 0 ? $query->get() : $all_query->get();
            $pdf = FacadePdf::loadView('reports.client_pdf', $page_data);
            return $pdf->download('client_reports.pdf');
        }

        if ($file == 'print') {
            $page_data['reports'] =count($request->all()) > 0 || $request->customSearch ? $query->get() : $all_query->get();
            $pdf = FacadePdf::loadView('reports.client_pdf', $page_data);
            return $pdf->stream('client_reports.pdf');
        }
    
        if ($file == 'csv') {
            $fileName = 'client_reports.csv';
            $headers = [
                "Content-type"        => "text/csv",
                "Content-Disposition" => "attachment; filename=$fileName",
                "Pragma"              => "no-cache",
                "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
                "Expires"             => "0"
            ];
    
            // Use the filtered query to get the projects for CSV
            $reports = count($request->all()) > 0 ? $query->get() : $all_query->get();
            $columns = ['#', 'project_code', 'payment_types', 'amount', 'date_added'];
            $callback = function() use ($columns, $reports) {
                $file = fopen('php://output', 'w');
                fputcsv($file, $columns);
    
                $count = 1;
                foreach ($reports as $item) {    
                    fputcsv($file, [
                        $count,
                        $item->user->name,
                        $item->payment_types,
                        currency($item->total_amount),
                        date('d-M-y h:i A', $item->date_added)
                    ]);
                    $count++;
                }
    
                fclose($file);
            };
    
            return response()->stream($callback, 200, $headers);
        }
    
        // If no valid file type was provided
        return response()->json(['error' => 'Invalid file type'], 400);
    }

    public function paymentReportExportFile(Request $request, $file) {

        $query = Payment_history::query();

        if (isset($request->customSearch)) {
            $string = $request->customSearch;
            $query->where('project_code', 'like', "%{$string}%")
            ->orWhereHas('project', function ($userQuery) use ($string) {
                $userQuery->where('title', 'like', "%{$string}%");
            });
        }

        $maxPrice = (int) str_replace('$', '', $request->maxPrice);
        $minPrice = (int) str_replace('$', '', $request->minPrice);
        if ($minPrice > 0 || $maxPrice > 0) {
            $query->whereBetween('amount', [$minPrice, $maxPrice]);
        }

        if (isset($request->payment_method) && $request->payment_method != 'all') {
            $query->where('payment_type', $request->payment_method);
        }

        
        if (isset($request->start_date) && !empty($start_date)) {
            $start_date = date('Y-m-d', strtotime($start_date));
            $query->whereRaw("DATE(FROM_UNIXTIME(date_added)) = ?", [$start_date]);
        }
    
        if ($file == 'pdf') {
            $page_data['payments'] = count($request->all()) > 0 ? $query->get() : Payment_history::get();
            $pdf = FacadePdf::loadView('reports.payment_pdf', $page_data);
            return $pdf->download('payment_history.pdf');
        }

        if ($file == 'print') {
            $page_data['payments'] =count($request->all()) > 0 || $request->customSearch ? $query->get() : Payment_history::get();
            $pdf = FacadePdf::loadView('reports.payment_pdf', $page_data);
            return $pdf->stream('payment_history.pdf');
        }
    
        if ($file == 'csv') {
            $fileName = 'payment_history.csv';
            $headers = [
                "Content-type"        => "text/csv",
                "Content-Disposition" => "attachment; filename=$fileName",
                "Pragma"              => "no-cache",
                "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
                "Expires"             => "0"
            ];
    
            // Use the filtered query to get the projects for CSV
            $reports = count($request->all()) > 0 ? $query->get() : Payment_history::get();
            $columns = ['#', 'project_code', 'name', 'payment_type', 'amount','invoice', 'date_added'];
            $callback = function() use ($columns, $reports) {
                $file = fopen('php://output', 'w');
                fputcsv($file, $columns);
    
                $count = 1;
                foreach ($reports as $item) {    
                    fputcsv($file, [
                        $count,
                        $item->project_code,
                        $item->user->name,
                        $item->payment_type,
                        currency($item->amount),
                        Invoice::where('id', $item->invoice_id)->value('title'),
                        date('d-M-y h:i A', $item->date_added)
                    ]);
                    $count++;
                }
    
                fclose($file);
            };
    
            return response()->stream($callback, 200, $headers);
        }
    
        // If no valid file type was provided
        return response()->json(['error' => 'Invalid file type'], 400);
    }  
}
