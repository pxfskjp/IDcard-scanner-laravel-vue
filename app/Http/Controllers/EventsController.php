<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Event;

class EventsController extends Controller
{
	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->middleware('auth');
	}

	/**
	 * Show the application dashboard.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(Request $request)
	{
		$events = Event::orderBy('event')->paginate(config('global.pagination'));
		$title = 'Events';
		if($request->ajax())
			return view('events.load', compact('events'));
		return view('events.index', compact('events', 'title'));
	}

	public function all(Request $request, $provider = null)
	{
		// If the search term is set
		if(isset($_GET['term'])) {
			// Trim the search term
			$search = rtrim(ltrim($_GET['term']));
			return Event::select('id','event')
				->where('event', 'like', '%'.$search.'%')
				->orderBy('event')
				->get();
		} else {
			return Event::select('id','event')
				->orderBy('event')
				->get();
		}	
	}

	public function createIndex()
	{
		$providers = Provider::all();
		$title = 'Create Event';
		return view('events.create', compact('providers', 'title'));
	}

	public function editIndex(Request $request, $id)
	{
		$event = Event::with('members')->find($id);
		$providers = Provider::all();
		$title = 'Edit Event';
		return view('events.edit', compact('event', 'providers', 'title'));
	}

	public function delete(Request $request, $id)
	{
		Event::find($id)->delete();
		return redirect('/events');
	}

	public function create(Request $request)
	{
		$this->validate($request, [
			'event' => config('global.in_std_r'),
			'provider_id' => config('global.in_int_r'),
			'address' => config('global.in_addr'),
			'city' => config('global.in_addr'),
			'postal' => config('global.in_postal'),
		]);
		$event = Event::create($request->input());
		return redirect('/events/edit/'.$event->id);
	}

	public function edit(Request $request, $id)
	{
		$this->validate($request, [
			'event' => config('global.in_std_r'),
			'provider_id' => config('global.in_int_r'),
			'address' => config('global.in_addr'),
			'city' => config('global.in_addr'),
			'postal' => config('global.in_postal'),
		]);
		Event::find($id)->update($request->input());
		return redirect('/events/edit/'.$id);
	}
}
