<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

        $data['project_id'] = $request->project_id;
        $data['user_id']    = Auth::user()->id;
        $data['title']      = $request->title;
        $data['payment']    = $request->payment;

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

    public function update(Request $request, $id)
    {
        $data['title']   = $request->title;
        $data['payment'] = $request->payment;

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
        // dd('payout');
        $invoice = Invoice::where('id', $id)->first();
        $items[] = [
            'id'    => $invoice->id,
            'title' => $invoice->title,
            'price' => $invoice->payment,
        ];

        $payment_details = [
            'items'          => $items,

            'custom_field'   => [
                'item_type'  => 'invoice',
                'pay_for'    => 'invoice payment',
                'user_id'    => Auth::user()->id,
                'user_photo' => Auth::user()->photo,
            ],

            'success_method' => [
                'model_name'    => 'Invoice',
                'function_name' => 'payment_invoice',
            ],

            'payable_amount' => $invoice->payment,
            'cancel_url'     => route('admin.invoice'),
            'success_url'    => route('payment.success', ''),
        ];

        Session::put(['payment_details' => $payment_details]);
        return redirect()->route('payment');
    }

}
