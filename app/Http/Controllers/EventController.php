<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Invitation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::paginate(10);
        return view('events.index', compact('events'));
    }

    public function create()
    {
        return view('events.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $event = Event::create([
            'name' => $request->name,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'user_id' => Auth::id(),
        ]);

        // Handle email invitations if provided
        if ($request->has('invite_emails')) {
            $emails = array_map('trim', explode(',', $request->input('invite_emails')));
            foreach ($emails as $email) {
                if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $event->invitations()->create(['email' => $email]);
                }
            }
        }

        return redirect()->route('events.edit', $event->id);
    }

    public function edit(Event $event)
    {
        return view('events.edit', compact('event'));
    }

    public function update(Request $request, Event $event)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $event->update($request->only(['name', 'start_date', 'end_date']));

        return redirect('/');
    }

    public function publicIndex(Request $request)
    {
        $query = Event::query();

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('start_date', [$request->start_date, $request->end_date]);
        }

        $events = $query->paginate(10);

        return view('events.public_index', compact('events'));
    }

    public function invite(Request $request, Event $event)
    {
        $request->validate(['email' => 'required|email']);

        $invitation = $event->invitations()->create(['email' => $request->email]);

        return response()->json(['status' => 'Invitation sent!', 'invitation_id' => $invitation->id]);
    }

    public function removeInvite(Event $event, Invitation $invitation)
    {
        $invitation->delete();

        return response()->json(['status' => 'Invitation removed!']);
    }

    public function myEvents(Request $request)
    {
        $user = Auth::user();
        $search = $request->input('search');
        $query = Event::where('user_id', $user->id);

        if ($search) {
            $query->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('start_date', 'LIKE', "%{$search}%")
                  ->orWhere('end_date', 'LIKE', "%{$search}%");
        }

        $userEvents = $query->paginate(10);

        return view('my_events', compact('userEvents', 'search'));
    }

    public function destroy(Event $event)
    {
        $event->delete();
        return redirect()->route('myEvents')->with('success', 'Event deleted successfully.');
    }
}
