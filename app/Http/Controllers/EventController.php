<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EventController extends Controller
{
    public function index()
    {
        $page_data['events'] = Event::select('id', 'title', 'start_date as start', 'end_date as end')->get();
        return view('event.index', $page_data);
    }

    public function create()
    {
        $page_data['date'] = request()->query('date');
        return view('event.create', $page_data);
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title'      => 'required|string|max:255',
            'start_date' => 'required',
            'end_date'   => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'validationError' => $validator->getMessageBag()->toArray(),
            ]);
        }
        $data['title']      = $request->title;
        $data['start_date'] = $request->start_date;
        $data['end_date']   = $request->end_date;

        Event::insert($data);
        return response()->json([
            'success' => 'Event has been stored.',
        ]);
    }

    public function delete($id)
    {
        Event::where('id', $id)->delete();
        return response()->json([
            'success' => 'Event has been deleted.',
        ]);
    }

    public function edit(Request $request)
    {
        $data['event'] = Event::where('id', $request->event_id)->first();
        return view('event.edit', $data);
    }
    public function update(Request $request, $id)
    {
        $data['title']      = $request->title;
        $data['start_date'] = $request->start_date;
        $data['end_date']   = $request->end_date;
        Event::where('id', $request->id)->update($data);

        return response()->json([
            'success' => 'Event has been updated.',
        ]);
    }

}
