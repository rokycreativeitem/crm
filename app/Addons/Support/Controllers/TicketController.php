<?php

namespace App\Addons\Support\Controllers;

use App\Addons\Support\Controllers\AddonServerSideDataController;
use App\Addons\Support\Models\Support;
use App\Addons\Support\Models\Ticket;
use App\Addons\Support\Models\Ticket_category;
use App\Addons\Support\Models\Ticket_message;
use App\Addons\Support\Models\Ticket_priority;
use App\Http\Controllers\Controller;
use App\Models\FileUploader;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class TicketController extends Controller
{
    public function menu_item()
    {
        return view('Support::ticket.menu')->render();
    }

    // public function multiDelete()
    // {
    //     return view('Support::components.modal')->render();
    // }

    // TICKETS FUNCTIONS ARE HERE
    // public function index(Request $request)
    // {
    //     // if ($request->ajax()) {
    //     //     return app(ServerSideDataController::class)->addon_server_side($request->customSearch);
    //     // }
    //     // $page_data['cruds'] = Ticket::get();
    //     // return view('addon.index', $page_data);
    //     $page_data['cruds'] = Ticket::get();
    //     return view('Support::ticket.index', $page_data)->render();
    // }
    public function index(Request $request)
    {

        if ($request->ajax()) {
            return app(AddonServerSideDataController::class)->ticket_server_side($request->customSearch, $request->category, $request->priority, $request->status, $request->client, $request->staff);
        }

        $page_data['tickets']    = Ticket::get();
        $page_data['clients']    = User::where('role_id', 2)->get();
        $page_data['staffs']     = User::where('role_id', 3)->get();
        $page_data['categories'] = Ticket_category::where('status', '=', 1)->get();
        $page_data['priorities'] = Ticket_priority::where('status', '=', 1)->get();
        return view('Support::ticket.index', $page_data)->render();
    }

    public function create()
    {
        // $page_data['categories'] = Ticket_category::get();
        $page_data['categories'] = Ticket_category::where('status', '=', 1)->get();
        $page_data['priorities'] = Ticket_priority::where('status', '=', 1)->get();
        $client                  = Role::where('title', 'client')->first();
        $page_data['clients']    = User::where('role_id', $client->id)->get();
        $staff                   = Role::where('title', 'staff')->first();
        $page_data['staffs']     = User::where('role_id', $staff->id)->get();
        return view('Support::ticket.create', $page_data)->render();
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'subject'     => 'required|string|max:255',
            // 'client_id' => get_user('role') == 'client' ? 'nullable|integer':'required|interger',
            'client_id'   => get_current_user_role() == 'client' ? 'nullable|integer' : 'required|interger',
            'staff_id'    => get_current_user_role() == 'client' ? 'nullable|integer' : 'required|interger',
            // 'client_id'   => 'required|integer',
            // 'staff_id'    => 'required|integer',
            'status'      => 'required|string|max:255',
            'priority_id' => 'required|integer',
            'category_id' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ], 422);
        }

        $ticket['subject']     = $request->subject;
        $ticket['code']        = random_int(1000, 9999);
        $ticket['client_id']   = $request->client_id ?? auth()->user()->id;
        $ticket['staff_id']    = $request->staff_id;
        $ticket['status']      = $request->status;
        $ticket['priority_id'] = $request->priority_id;
        $ticket['category_id'] = $request->category_id;

        Ticket::insert($ticket);
        return redirect()->back();

        // return response()->json([
        //     'success' => 'Ticket created successfully.',
        // ]);

        // Support::insert(['title' => $request->title]);
    }

    public function delete($id)
    {
        Ticket::where('id', $id)->delete();
        return response()->json([
            'success' => 'Product has been deleted.',
        ]);
    }

    public function edit($id)
    {
        $ticket['ticket']     = Ticket::where('id', $id)->first();
        $ticket['categories'] = Ticket_category::where('status', '=', 1)->get();
        $ticket['priorities'] = Ticket_priority::where('status', '=', 1)->get();
        $client               = Role::where('title', 'client')->first();
        $ticket['clients']    = User::where('role_id', $client->id)->get();

        $staffs           = Role::where('title', 'staff')->first();
        $ticket['staffs'] = User::where('role_id', $staffs->id)->get();

        return view('Support::ticket.edit', $ticket)->render();
    }

    public function update(Request $request, $id)
    {
        $ticket['subject']     = $request->subject;
        $ticket['client_id']   = $request->client_id ?? auth()->user()->id;
        $ticket['staff_id']    = $request->staff_id;
        $ticket['status']      = $request->status;
        $ticket['priority_id'] = $request->priority_id;
        $ticket['category_id'] = $request->category_id;

        Ticket::where('id', $id)->update($ticket);
        return redirect()->back();
        // return response()->json([
        //     'success' => 'Product has been updated.',
        // ]);
    }

    public function show()
    {
        return view('Support::ticket.details')->render();
    }

    public function multiDelete(Request $request)
    {
        $ids   = $request->ids;
        $model = 'App\\Addons\\Support\\Models\\' . ucwords($request->type);
        if (is_array($ids)) {
            foreach ($ids as $id) {
                $model::where('id', $id)->delete();
            }
            return response()->json(['success' => get_phrase(ucwords($request->type) . ' ' . "deleted successfully!")]);
        }
        return response()->json(['error' => get_phrase('No users selected for deletion.')], 400);
    }

    // public function delete($id)
    // {
    //     Support::where('id', $id)->delete();
    //     return redirect()->back();
    // }

    // TICKET MESSAGE FUNCTIONS

    // public function ticket_message($ticket_thread_code = '')
    // {
    //     $page_data['ticket_thread_code'] = $ticket_thread_code;
    //     $page_data['ticket_details']     = Ticket::where('code', $ticket_thread_code)->first();

    //     if ($ticket_thread_code != '') {
    //         $page_data['ticket_message'] = Ticket_message::where('ticket_thread_code', $ticket_thread_code)->first();
    //     }
    //     return view('Support::ticket.details', $page_data)->render();
    // }

    public function ticket_message($ticket_thread_code = '')
    {
        $page_data['ticket_thread_code'] = $ticket_thread_code;
        $page_data['ticket_details']     = Ticket::where('code', $ticket_thread_code)->first();
        $page_data['messages']           = Ticket_message::where('ticket_thread_code', $ticket_thread_code)->get();

        // if (! $page_data['ticket_details']) {
        //     return response()->json(['error' => 'Ticket not found'], 404);
        // }

        return view('Support::ticket.details', $page_data)->render();
    }

    public function ticket_message_store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'message'            => $request->file('ticket_file') ? 'nullable|string' : 'required|string',
            'sender_id'          => 'required|integer|exists:App\Models\User,id',
            'receiver_id'        => 'required|integer|exists:App\Models\User,id',
            'ticket_thread_code' => 'required|integer',
            'ticket_file.*'      => 'file|mimes:jpg,jpeg,png,pdf,doc,docx|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ], 422);
        }

        // $file                       = $request->file('ticket_file');
        // $data['message']            = $request->message;
        // $data['sender_id']          = $request->sender_id;
        // $data['receiver_id']        = $request->receiver_id;
        // $data['ticket_thread_code'] = $request->ticket_thread_code;
        // $data['created_at']         = date('Y-m-d H:i:s');
        // $data['file']               = FileUploader::upload($file, 'ticket_files');

        $data = [
            'message'            => $request->message,
            'sender_id'          => $request->sender_id,
            'receiver_id'        => $request->receiver_id,
            'ticket_thread_code' => $request->ticket_thread_code,
            'created_at'         => date('Y-m-d H:i:s'),
        ];

        if ($request->hasFile('ticket_file')) {
            $uploadedFiles = [];

            foreach ($request->file('ticket_file') as $file) {
                $uploadedFiles[] = FileUploader::upload($file, 'ticket_files');
            }

            $data['file'] = json_encode($uploadedFiles);
        }

        Ticket_message::insert($data);

        // $message_thread = Ticket::find($request->ticket_thread_code)->code;

        Session::flash('success', get_phrase('Your message successfully has been sent'));
        // return redirect(route('admin.message', ['message_thread' => $message_thread]));
        return redirect()->back();
    }

    // TICKET CATEGORY FUNCTIONS
    public function ticket_category(Request $request)
    {
        if ($request->ajax()) {
            return app(AddonServerSideDataController::class)->ticket_category_server_side($request->customSearch);
        }
        $page_data['categories'] = Ticket_category::get();
        return view('Support::category.index', $page_data)->render();
    }

    public function ticket_category_create()
    {
        return view('Support::category.create')->render();
    }

    public function ticket_category_store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title'  => 'required|string|max:255',
            'status' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ], 422);
        }

        $category['title']  = $request->title;
        $category['status'] = $request->status;

        Ticket_category::insert($category);
        return redirect()->back();
    }

    public function ticket_category_delete($id)
    {
        Ticket_category::where('id', $id)->delete();
        return response()->json([
            'success' => 'Category has been deleted.',
        ]);
    }
    public function ticket_category_edit($id)
    {
        $category['category'] = Ticket_category::where('id', $id)->first();
        return view('Support::category.edit', $category)->render();
    }
    public function ticket_category_update(Request $request, $id)
    {
        $category['title']  = $request->title;
        $category['status'] = $request->status;

        Ticket_category::where('id', $id)->update($category);
        return redirect()->back();
        // return response()->json([
        //     'success' => 'Product has been updated.',
        // ]);
    }

    public function ticket_priority(Request $request)
    {
        if ($request->ajax()) {
            return app(AddonServerSideDataController::class)->ticket_priority_server_side($request->customSearch);
        }
        $page_data['priorities'] = Ticket_priority::get();
        return view('Support::priority.index', $page_data)->render();
    }

    public function ticket_priority_create()
    {
        return view('Support::priority.create')->render();
    }

    public function ticket_priority_store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title'  => 'required|string|max:255',
            'status' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ], 422);
        }

        $priority['title']  = $request->title;
        $priority['status'] = $request->status;

        Ticket_priority::insert($priority);
        return redirect()->back();
    }

    public function ticket_priority_delete($id)
    {
        Ticket_priority::where('id', $id)->delete();
        return response()->json([
            'success' => 'priority has been deleted.',
        ]);
    }
    public function ticket_priority_edit($id)
    {
        $priority['priority'] = Ticket_priority::where('id', $id)->first();
        return view('Support::priority.edit', $priority)->render();
    }
    public function ticket_priority_update(Request $request, $id)
    {
        $priority['title']  = $request->title;
        $priority['status'] = $request->status;

        Ticket_priority::where('id', $id)->update($priority);
        return redirect()->back();
        // return response()->json([
        //     'success' => 'Product has been updated.',
        // ]);
    }
}
