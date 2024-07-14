<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\User; // Add this line
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB; // Add this line

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $sortField = $request->get('sort', 'start_date'); // Default sort by start date
        $sortOrder = $request->get('order', 'asc'); // Default sort order asc
        $search = $request->get('search', '');

        $eventsQuery = Event::query();

        if ($search) {
            $eventsQuery->where('name', 'like', '%' . $search . '%')
                        ->orWhere('start_date', 'like', '%' . $search . '%')
                        ->orWhere('end_date', 'like', '%' . $search . '%');
        }

        $events = $eventsQuery->orderBy($sortField, $sortOrder)->paginate(10);

        return view('home', compact('events', 'sortField', 'sortOrder', 'search'));
    }

    public function myEvents(Request $request)
    {
        $sortField = $request->get('sort', 'start_date');
        $sortOrder = $request->get('order', 'asc');
        $search = $request->get('search', '');

        $userEventsQuery = Event::where('user_id', Auth::id());

        if ($search) {
            $userEventsQuery->where(function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%')
                      ->orWhere('start_date', 'like', '%' . $search . '%')
                      ->orWhere('end_date', 'like', '%' . $search . '%');
            });
        }

        $userEvents = $userEventsQuery->orderBy($sortField, $sortOrder)->paginate(10);

        return view('my_events', compact('userEvents', 'sortField', 'sortOrder', 'search'));
    }

    public function statistics()
    {
        // Get total event count and user count
        $totalEventCount = Event::count();
        $userCount = User::count();

        // Calculate the average events count per user
        $averageEventsPerUser = $userCount ? $totalEventCount / $userCount : 0;

        // Get the average number of events created by each user
        $usersWithEventCounts = User::select(DB::raw('CONCAT(users.first_name, " ", users.last_name) as full_name'), DB::raw('COUNT(events.id) as event_count'))
            ->leftJoin('events', 'events.user_id', '=', 'users.id')
            ->groupBy('users.id', 'users.first_name', 'users.last_name')
            ->get();

        return view('statistics', compact('averageEventsPerUser', 'usersWithEventCounts'));
    }
}
