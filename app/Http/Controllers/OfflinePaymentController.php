<?php

namespace App\Http\Controllers;

use App\Models\FileUploader;
use App\Models\Invoice;
use App\Models\OfflinePayment;
use App\Models\Payment_history;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class OfflinePaymentController extends Controller
{
    public function store(Request $request)
    {
        // check amount
        $payment_details = Session::get('payment_details');

        $item_id_arr = [];
        foreach ($payment_details['items'] as $item) {
            $item_id_arr[] = $item['id'];
        }

        $rules = [
            'doc' => 'required|mimes:jpeg,jpg,pdf,txt,png,docx,doc|max:3072',
        ];
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $file = $request->file('doc');

        $offline_payment['user_id']         = Auth::user()->id;
        $offline_payment['item_type']       = $payment_details['custom_field']['item_type'];
        $offline_payment['items']           = json_encode($item_id_arr);
        $offline_payment['total_amount']    = $payment_details['payable_amount'];
        $offline_payment['doc']             = FileUploader::upload($file, 'offline_payment', null, null, 300);
        $offline_payment['payment_purpose'] = $payment_details['payment_purpose'];
        $offline_payment['phone_no']        = $request->phone_no;
        $offline_payment['bank_no']         = $request->bank_no;

        OfflinePayment::insert($offline_payment);

        // return to courses
        Session::flash('success', get_phrase('The payment will be completed once the admin reviews and approves it.'));
        return redirect()->route(get_current_user_role() . '.project.details', [$payment_details['items'][0]['project_code'], 'invoice']);
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            return app(ServerSideDataController::class)->offline_payments_server_side($request->customSearch, $request->user, $request->status, $request->date, str_replace('$', '', $request->minPrice), str_replace('$', '', $request->maxPrice));
        }

        $page_data['users']    = User::get();
        $page_data['payments'] = OfflinePayment::get();
        return view('offline_payments.index', $page_data);
    }

    public function download_doc($id)
    {
        // validate id
        if (empty($id)) {
            Session::flash('error', get_phrase('Data not found.'));
            return redirect()->back();
        }

        // payment details
        $payment_details = OfflinePayment::where('id', $id)->first();
        $file_path       = public_path($payment_details->doc);
        if (!file_exists($file_path)) {
            Session::flash('error', get_phrase('Data not found.'));
            return redirect()->back();
        }
        // download file
        return Response::download($file_path);
    }

    public function accept_payment($id)
    {
        $session_payment_details = session('payment_details');
        // validate id
        if (empty($id)) {
            Session::flash('error', get_phrase('Data not found.'));
            return redirect()->back();
        }

        // payment details
        $query = OfflinePayment::where('id', $id)->where('status', 0);
        if ($query->doesntExist()) {
            Session::flash('error', get_phrase('Data not found.'));
            return redirect()->back();
        }

        $payment_details = $query->first();

        $payment['user_id']         = $payment_details['user_id'];
        $payment['payment_type']    = 'offline';
        $payment['payment_purpose'] = $payment_details['payment_purpose'];
        $payment['project_code']    = $session_payment_details['items'][0]['project_code'];
        $payment['date_added']      = time();

        if ($payment_details->item_type == 'invoice') {
            $items = json_decode($payment_details->items);
            foreach ($items as $item) {
                if ($payment_details->item_type == 'invoice') {
                    $invoice               = Invoice::where('id', $item)->first();
                    $payment['invoice_id'] = $invoice->id;
                    $payment['amount']     = $invoice->payment;

                    Payment_history::insert($payment);
                }
            }
        }

        OfflinePayment::where('id', $id)->update(['status' => 1]);

        // go back
        Session::flash('success', 'Payment has been accepted.');
        return redirect()->route('admin.offline.payments');
    }

    public function decline_payment($id)
    {
        // remove items from offline payment
        OfflinePayment::where('id', $id)->update(['status' => 2]);

        Session::flash('success', 'Payment has been suspended');
        return redirect()->route('admin.offline.payments');
    }

    public function success_login()
    {
        return view('smtp.success_login');
    }
    public function payment()
    {
        return view('smtp.payment');
    }
    public function invoice()
    {
        return view('smtp.invoice');
    }
    public function confirm_email()
    {
        return view('smtp.confirm_email');
    }
    public function verify_email()
    {
        return view('smtp.verify_email');
    }
}
