<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PaymentController extends Controller
{
    public function index()
    {
        $page_data['payments'] = Payment::get();
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

        Payment::insert($data);
        return response()->json([
            'success' => 'Invoice has been stored.',
        ]);
    }

    public function delete($id)
    {
        Payment::where('id', $id)->delete();
        return response()->json([
            'success' => 'Invoice has been deleted.',
        ]);
    }

    public function edit(Request $request, $id)
    {
        $data['payment'] = Payment::where('id', $id)->first();
        return view('projects.invoice.edit', $data);
    }

    public function update(Request $request, $id)
    {
        $data['title']   = $request->title;
        $data['payment'] = $request->payment;

        Payment::where('id', $request->id)->update($data);

        return response()->json([
            'success' => 'Invoice has been updated.',
        ]);
    }

    public function multiDelete(Request $request)
    {
        $ids = $request->input('data');

        if (!empty($ids)) {
            Payment::whereIn('id', $ids)->delete();
            return response()->json(['success' => 'Invoices deleted successfully!']);
        }

        return response()->json(['error' => 'No invoices selected for deletion.'], 400);
    }

}
