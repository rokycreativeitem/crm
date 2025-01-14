<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class InvoiceController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return app(ServerSideDataController::class)->invoice_server_side($request->project_id, $request->customSearch, $request->start_date);
        }
        $page_data['invoices'] = Invoice::get();
        return view('projects.invoice.index', $page_data);
    }

    public function create()
    {
        $page_data['project_id'] = Project::where('code', request()->query('code'))->value('id');
        return view('projects.invoice.create', $page_data);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'validationError' => $validator->getMessageBag()->toArray(),
            ]);
        }
        $user_id = Auth::user()->id;
        if (DB::table('offline_payments')->where('user_id', $user_id)->exists()) {
            $payment_status = 'processing';
        } elseif (DB::table('payment_histories')->where('invoice_id', $request->id)->exists()) {
            $payment_status = 'paid';
        } else {
            $payment_status = 'unpaid';
        }

        $data['project_id']     = $request->project_id;
        $data['user_id']        = $user_id;
        $data['due_date']        = $request->due_date;
        $data['title']          = $request->title;
        $data['payment']        = $request->payment;
        $data['payment_status'] = $payment_status;

        Invoice::insert($data);
        return response()->json([
            'success' => 'Invoice has been stored.',
        ]);
    }

    public function delete($id)
    {
        Invoice::where('id', $id)->delete();
        return response()->json([
            'success' => 'Invoice has been deleted.',
        ]);
    }

    public function edit(Request $request, $id)
    {
        $data['invoice'] = Invoice::where('id', $id)->first();
        return view('projects.invoice.edit', $data);
    }

    public function view($id)
    {
        $data['invoice'] = Invoice::where('id', $id)->first();
        return view('projects.invoice.view', $data);
    }

    public function update(Request $request, $id)
    {
        $data['title']   = $request->title;
        $data['payment'] = $request->payment;
        $data['due_date'] = $request->due_date;

        Invoice::where('id', $id)->update($data);

        return response()->json([
            'success' => 'Invoice has been updated.',
        ]);
    }

    public function multiDelete(Request $request)
    {
        $ids = $request->input('data');

        if (!empty($ids)) {
            Invoice::whereIn('id', $ids)->delete();
            return response()->json(['success' => 'Invoices deleted successfully!']);
        }

        return response()->json(['error' => 'No invoices selected for deletion.'], 400);
    }

    public function payout($id)
    {
        $invoice         = Invoice::where('id', $id)->first();
        $payment_purpose = DB::table('payment_purposes')->where('title', 'invoice')->first();
        $project_code    = Project::where('id', $invoice->project_id)->value('code');
        $items[]         = [
            'id'           => $invoice->id,
            'title'        => $invoice->title,
            'price'        => $invoice->payment,
            'project_code' => $project_code,
        ];

        $payment_details = [
            'items'           => $items,

            'custom_field'    => [
                'item_type'  => $payment_purpose->title,
                'pay_for'    => $payment_purpose->pay_for,
                'user_id'    => Auth::user()->id,
                'user_photo' => Auth::user()->photo,
            ],

            'success_method'  => [
                'model_name'    => $payment_purpose->model,
                'function_name' => $payment_purpose->function_name,
            ],

            'payable_amount'  => $invoice->payment,
            'payment_purpose' => $payment_purpose->id,
            'cancel_url'      => route(get_current_user_role() . '.project.details', [$project_code, 'invoice']),
            'success_url'     => route('payment.success', ''),
        ];

        Session::put(['payment_details' => $payment_details]);
        return redirect()->route('payment');
    }

}
