<?php

namespace App\Addons\Support\Controllers;

use App\Addons\Support\Controllers\AddonServerSideDataController;
use App\Addons\Support\Models\Faq;
use App\Addons\Support\Models\Support;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ServerSideDataController;
use App\Models\Addon;
use App\Models\Category;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FaqController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return app(AddonServerSideDataController::class)->faq_server_side($request->customSearch);
        }
        // if ($request->ajax()) {
        //     return app(ServerSideDataController::class)->faq_server_side($request->customSearch);
        // }
        $page_data['faqs'] = Faq::get();
        return view('Support::faq.index', $page_data)->render();
    }

    public function create()
    {
        return view('Support::faq.create')->render();
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'question' => 'required|string',
            'answer'   => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ], 422);
        }

        $page_data['question'] = $request->question;
        $page_data['answer']   = $request->answer;

        Faq::insert($page_data);
        return redirect()->back();
    }

    public function delete($id)
    {
        Faq::where('id', $id)->delete();
        return response()->json([
            'success' => 'FAQ has been deleted.',
        ]);
    }

    public function edit($id)
    {
        $page_data['faq'] = Faq::where('id', $id)->first();
        return view('support::faq.edit', $page_data);
    }

    public function update(Request $request, $id)
    {
        $page_data['question'] = $request->question;
        $page_data['answer']   = $request->answer;

        Faq::where('id', $id)->update($page_data);

        return redirect()->back();
        // return response()->json([
        //     'success' => 'FAQ has been updated.',
        // ]);
    }
}
