<?php

namespace App\Http\Controllers;
use Auth;
use App\Scan;
use DateTime;
use App\Event;
use App\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Validate;
use Hash;

class AdminController extends Controller
{
	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		// $this->middleware('auth');
	}

	/**
	 * API Functions
	 */

	public function members_api()
	{
		if(isset($_GET['term']))
		{
			$search = rtrim(ltrim($_GET['term']));
			return Member::select('barcode_id','first_name', 'last_name')
				->where('first_name', 'like', '%'.$search.'%')
				->orWhere('last_name', 'like', '%'.$search.'%')
				->orWhereRaw("concat(first_name, ' ', last_name) like '%".$search."%' ")
				->orderBy('first_name')
				->get();	
		} else {
			return Member::select('barcode_id','first_name', 'last_name')
				->orderBy('first_name')
				->get();	
		}
	}

	public function mobile_members_api() {
			$members = Member::select('barcode_id','first_name', 'last_name')
				->orderBy('first_name')
				->get();

			$formatted_array = [];
			foreach ($members as $member) {
				array_push($formatted_array, array('key' => $member->barcode_id, 'label' => $member->first_name . ' ' . $member->last_name));
			}

			return response()->json($formatted_array);
	}

	public function events_api()
	{
		if(isset($_GET['term']))
		{
			$search = rtrim(ltrim($_GET['term']));
			return Event::select('id','name')
				->where('name', 'like', '%'.$search.'%')
				->orderBy('date')
				->get();	
		} else {
			return Event::select('id','name')
				->orderBy('date')
				->get();	
		}
	}

	public function mobile_events_api() {
		$events = Event::select('id','name')
				->orderBy('date')
				->get();

		$formatted_array = [];
		foreach ($events as $event) {
			array_push($formatted_array, array('key' => $event->id, 'label' => $event->name, 'description' => $event->description, 'date' => $event->date ));
		}

		return response()->json($formatted_array);
	}

	public function mobile_get_event($event_id) {
		$event = Event::where('id', $event_id)->first();

		return response()->json(['id' => $event->id, 'eventName' => $event->name, 'date' => $event->date, 'description' => $event->description]);
	}

	/**
	 * Event Related Functions.
	 */
	public function events()
	{
		$events = Event::all()
			->sortBy('date');
		return view('events.all', ['events' => $events]);
	}

	public function view_event($id)
	{
		$event = Event::where('id', $id)
			->get()->first();
		$scans = Scan::where('event_id', $id)
		->join('members','members.barcode_id', '=', 'scans.member_barcode_id')
			->orderBy('date')
			->orderBy('time')
			->get();
		return view('events.view',['event' => $event, 'scans' => $scans]);
	}

	public function edit_event($id)
	{
		$event = Event::where('id', $id)
			->get()->first();
		return view('events.edit', ['event' => $event]);
	}

	public function update_event(Request $request, $id)
	{
		$this->validate($request, [
			'name' => 'required|max:150',
			'date' => 'required|date',
			'description' => 'string'
		]);
		$event = Event::find($id);
		$event->name = $request->name;
		$event->date = $request->date;
		$event->description = $request->description;
		$event->save();
		return redirect('admin/events/view/'.$event->id);
	}

	public function new_event()
	{
		return view('events.new');
	}

	public function create_event(Request $request)
	{
		$this->validate($request, [
			'name' => 'required|max:150',
			'date' => 'required|date',
			'description' => 'string'
		]);
		$event = new Event;
		$event->name = $request->name;
		$event->date = $request->date;
		$event->description = $request->description;
		$event->save();
		return redirect('admin/events/view/'.$event->id);
	}

	/**
	 * Member Related Functions.
	 */
	public function members()
	{
		$members = Member::all()
		->sortBy('printed');
		return view('members.all', ['members' => $members]);
	}

	public function view_member($id)
	{
		$member = Member::where('id', $id)
			->get()->first();
		return view('members.view',['member' => $member]);
	}

	public function edit_member($id)
	{
		$member = Member::where('id', $id)
			->get()->first();
		return view('members.edit', ['member' => $member]);
	}

	public function update_member(Request $request, $id)
	{
		$this->validate($request, [
			'first_name' => 'string|required|max:150',
			'last_name' => 'string|required|max:150',
			'optional_1' => 'string|max:190',
			'optional_2' => 'string|max:190',
			'optional_3' => 'string|max:190',
			'optional_4' => 'string|max:190'
		]);
		$member = Member::find($id);
		// Check to see if any changes have been made
		if (!(($member->first_name == $request->first_name) && ($member->last_name == $request->last_name) && ($member->optional_1 == $request->optional_1) && ($member->optional_2 == $request->optional_2) && ($member->optional_3 == $request->optional_3) && ($member->optional_4 == $request->optional_4)))
		{
			$member->printed = 0;
		}
		$member->first_name = $request->first_name;
		$member->last_name = $request->last_name;
		$member->optional_1 = $request->optional_1;
		$member->optional_2 = $request->optional_2;
		$member->optional_3 = $request->optional_3;
		$member->optional_4 = $request->optional_4;
		$member->save();
		return redirect('admin/members/view/'.$member->id);
	}

	public function export_not_printed()
	{
		$members = Member::where('printed', 0)
			->select('id', 'first_name', 'last_name', 'barcode_id', 'optional_1', 'optional_2', 'optional_3', 'optional_4', 'printed')
			->get();
		$file_name = 'members_not_printed.csv';
		$file = fopen($file_name, 'w');

		fputcsv($file, ['Full Name', 'Barcode', 'Optional 1', 'Optional 2', 'Optional 3', 'Optional 4', 'Printed']);
		foreach ($members as $member)
		{
			$member_new = Member::where('id', $member->id)
				->get()->first();
			$member_new->printed = 1;
			$member_new->save();
			fputcsv($file, [$member_new->first_name . ' ' . $member_new->last_name, $member_new->barcode_id, $member_new->optional_1, $member_new->optional_2, $member_new->optional_3, $member_new->optional_4, $member_new->printed]);
		}
		fclose($file);

		return response()->download(public_path().'/'.$file_name);
	}

	public function export_all()
	{
		$members = Member::select('id', 'first_name', 'last_name', 'barcode_id', 'optional_1', 'optional_2', 'optional_3', 'optional_4', 'printed')
			->get();
		$file_name = 'members_all.csv';
		$file = fopen($file_name, 'w');

		fputcsv($file, ['Full Name', 'Barcode', 'Optional 1', 'Optional 2', 'Optional 3', 'Optional 4', 'Printed']);
		foreach ($members as $member)
		{
			$member_new = Member::where('id', $member->id)
				->get()->first();
			$member_new->printed = 1;
			$member_new->save();
			fputcsv($file, [$member_new->first_name . ' ' . $member_new->last_name, $member_new->barcode_id, $member_new->optional_1, $member_new->optional_2, $member_new->optional_3, $member_new->optional_4, $member_new->printed]);
		}
		fclose($file);

		return response()->download(public_path().'/'.$file_name);
	}

	public function import_list(Request $request)
	{
		$this->validate($request, [
			'list' => 'file|required|mimes:csv,txt',
		]);

		$header = $request->file_headers;
		$path = $request->file('list')->getRealPath();
		$data = array_map('str_getcsv', file($path));

		foreach($data as $row)
		{
			if($header == 1)
			{
				$header = 0;
			}
			else
			{
				$member = Member::where('barcode_id', '=', $row[2])->first();
				if ($member === null) {
					echo $row[0]. " " . $row[1] . " does not exist.";
					$new_member = new Member;
					$new_member->first_name = $row[0];
					$new_member->last_name = $row[1];
					$new_member->barcode_id = $row[2];
					$new_member->optional_1 = array_key_exists(3, $row) ? $row[3] : '';
					$new_member->optional_2 = array_key_exists(4, $row) ? $row[4] : '';
					$new_member->optional_3 = array_key_exists(5, $row) ? $row[5] : '';
					$new_member->optional_4 = array_key_exists(6, $row) ? $row[6] : '';
					$new_member->printed = 0;
					$new_member->save();
				}
			}
		}

		return redirect('/admin/members');
	}

	/**
	 * Report Related Functions.
	 */

	public function reports()
	{
		$events = Event::all()
			->sortBy('date');
		$members = Member::all()
			->sortBy('first_name');
		return view('reports.all', compact('events'), compact('members'));
	}

	public function membersday(Request $request)
	{
		$this->validate($request, [
			'date' => 'date|required',
		]);

		$scans = Scan::with(['member'])
				->where('date', $request->date)
				->get()
				->sortBy('time')
				->groupBy('member_barcode_id');
		$scans_new = [];
		foreach($scans as $scan) {
			$scans_new[$scan[0]['member_barcode_id']][0] = $scan[0];
			$scans_new[$scan[0]['member_barcode_id']][1] = $scan[sizeOf($scan) - 1];
			
			$datetime1 = new DateTime($scan[0]['date'] . " " . $scan[0]['time']);
			$datetime2 = new DateTime($scan[sizeOf($scan) - 1]['date'] . " " . $scan[sizeOf($scan) - 1]['time']);
			$interval = $datetime1->diff($datetime2);
			$scans_new[$scan[0]['member_barcode_id']][2] = $interval->format("%H:%I:%S");
		}
		return view('reports.membersday', ['scans' => $scans_new, 'scan_date' => $request->date]);
	}
	
	public function mobile_membersday(Request $request)///////dfgsdfsdgfsdg
	{
		$rules = [
			'date' => 'required',
	
        ];

        $input = $request->only('date');
       
        $validator = Validator::make($input, $rules);

        if($validator->fails()) {
            return response()->json(['success'=> false, 'error'=> $validator->messages()]);
        }

		$scans = Scan::with(['member'])
				->where('date', $request->date)
				->where('event_id', null)
				->get()
				->sortBy('time')
				->groupBy('member_barcode_id');
		$scans_new = [];
		$tableData = [];
		foreach($scans as $scan) {
			$tableData[0] = $scan[0]['member']['first_name'] . ' ' . $scan[0]['member']['last_name'];
			$tableData[1] = $scan[0]['time'];
			$tableData[2] = $scan[sizeof($scan) - 1]['time'];

			$datetime1 = new DateTime($scan[0]['date'] . " " . $scan[0]['time']);
			$datetime2 = new DateTime($scan[sizeOf($scan) - 1]['date'] . " " . $scan[sizeOf($scan) - 1]['time']);
			$interval = $datetime1->diff($datetime2);
			$tableData[3] = $interval->format("%H:%I:%S");
			array_push($scans_new, $tableData);
		}
		return response()->json(['scans' => $scans_new, 'scan_date' => $request->date]);
	}
/*  */
public function daysmember(Request $request)
{
	$this->validate($request, [
		'start_date' => 'date|required',
		'end_date' => 'date|required',
		'member' => 'required',
	]);

	$member = Member::where('barcode_id', $request->member)
			->get()->first();

	$scans = Scan::with(['member'])
		->where([
		['date', '>=', $request->start_date],
		['date', '<=', $request->end_date],
		])
		->where('member_barcode_id', $request->member)
		->where('event_id', NULL)
		->get()
		->groupBy('date');

	$scans_new = [];
	foreach($scans as $scan) {
		$scans_new[$scan[0]['date']][0] = $scan[0];
		$scans_new[$scan[0]['date']][1] = $scan[sizeOf($scan) - 1];
		
		$datetime1 = new DateTime($scan[0]['date'] . " " . $scan[0]['time']);
		$datetime2 = new DateTime($scan[sizeOf($scan) - 1]['date'] . " " . $scan[sizeOf($scan) - 1]['time']);
		$interval = $datetime1->diff($datetime2);
		$scans_new[$scan[0]['date']][2] = $interval->format("%H:%I:%S");
	}

	return view('reports.daysmember', ['scans' => $scans_new, 'scan_date' => $request->date, 'member' => $member, 'start_date' => $request->start_date, 'end_date' => $request->end_date]);
}
/*  */
	public function mobile_daysmember(Request $request)////////this onedfgdfgdfg
	{
		$rules = [
			'start_date' => 'date|required',
			'end_date' => 'date|required',
			'member' => 'required',
        ];

        $input = $request->only(['start_date','end_date','member']);
        $validator = Validator::make($input, $rules);

        if($validator->fails()) {
            return response()->json(['success'=> false, 'error'=> $validator->messages()]);
        }

		

		$member = Member::where('barcode_id', $request->member)
				->get()->first();

		$scans = Scan::with(['member'])
			->where([
		    ['date', '>=', $request->start_date],
		    ['date', '<=', $request->end_date],
			])
			->where('member_barcode_id', $request->member)
			->where('event_id', NULL)
			->get()
			->sortBy('time')
			->groupBy('date');;

		$scans_new = [];
		$i = 0;
		foreach($scans as $scan) {
			/* $scans_new[$scan[0]['date']][0] = $scan[0];
			$scans_new[$scan[0]['date']][1] = $scan[sizeOf($scan) - 1]; */
			
			$datetime1 = new DateTime($scan[0]['date'] . " " . $scan[0]['time']);
			$datetime2 = new DateTime($scan[sizeOf($scan) - 1]['date'] . " " . $scan[sizeOf($scan) - 1]['time']);
			$interval = $datetime1->diff($datetime2);
			/* $scans_new[$scan[0]['date']][2] = $interval->format("%H:%I:%S"); */

			$scans_new[$i][0] = $scan[0]['date'];
			$scans_new[$i][1] = $scan[0]['time'];
			$scans_new[$i][2] = $scan[sizeOf($scan) - 1]['time'];
			$scans_new[$i][3] = $interval->format("%H:%I:%S");
			$i++;
		}

		return response()->json(['scans' => $scans_new, 'scan_date' => $request->date, 'member' => $member, 'start_date' => $request->start_date, 'end_date' => $request->end_date]);
	}
/*  */
public function membersevent(Request $request)
	{
		$this->validate($request, [
			'event' => 'required|numeric',
		]);

		$event = Event::where('id', $request->event)
			->get()->first();

		$scans = Scan::with(['member'])
			->where('event_id', $request->event)
			->get()
			->sortBy('time')
			->groupBy('member_barcode_id');

		return view('reports.membersevent', ['scans' => $scans, 'event' => $event]);
	}
/*  */
	public function mobile_membersevent(Request $request)/////////this one done
	{
		$rules = [
			'event' => 'required|numeric',
        ];

        $input = $request->only('event');
        $validator = Validator::make($input, $rules);

        if($validator->fails()) {
            return response()->json(['success'=> false, 'error'=> $validator->messages()]);
        }

		$event = Event::where('id', $request->event)
			->get()->first();

		$scans = Scan::with(['member'])
			->where('event_id', $request->event)
			->get()
			->sortBy('time')
			->groupBy('member_barcode_id');
		$scans_new = [];
		$i = 0;
		// returning just the name and time
		foreach($scans as $scan){
			$scans_new[$i][0] = ($scan[0]['member']['first_name'].' ' . $scan[0]['member']['last_name']);
			$scans_new[$i][1] = $scan[0]['time'];
			$i++;
			
		}
			return response()->json(['scans' => $scans_new, 'event' => $event]);
	}
/*  */
public function eventsmember(Request $request)
	{
		$this->validate($request, [
			'member' => 'required',
		]);

		$member = Member::where('barcode_id', $request->member)
			->get()->first();

		$scans = Scan::with(['event'])
			->where('member_barcode_id', $request->member)
			->where('event_id', '>=', 0)
			->get()
			->sortBy('events.date')
			->groupBy('event_id');

		$scans_new = [];
		foreach($scans as $scan) {
			$scans_new[$scan[0]['event_id']][0] = $scan[sizeOf($scan) - 1];
		}

		return view('reports.eventsmember', ['scans' => $scans_new, 'member' => $member]);
	}
/*  */
	public function mobile_eventsmember(Request $request)////////this one
	{
		$rules = [
			'member' => 'required',
        ];

        $input = $request->only('member');
       
        $validator = Validator::make($input, $rules);

        if($validator->fails()) {
            return response()->json(['success'=> false, 'error'=> $validator->messages()]);
        }

		$member = Member::where('barcode_id', $request->member)
			->get()->first();

		$scans = Scan::with(['event'])
			->where('member_barcode_id', $request->member)
			->where('event_id', '>=', 0)
			->get()
			->sortBy('events.date')
			->groupBy('event_id');

		$scans_new = [];
		$i = 0;
		foreach($scans as $scan) {
			$scans_new[$i][0] = ($scan[0]['event']['name'].' - ' . $scan[0]['event']['date']);
			$scans_new[$i][1] = $scan[0]['time'];
			$i++;
		}

		return response()->json(['scans' => $scans_new, 'member' => $member]);
	}

	public function membersday_export(Request $request)
	{
		$this->validate($request, [
			'date' => 'date|required',
		]);

		$scans = Scan::with(['member'])
				->where('date', $request->date)
				->get()
				->sortBy('time')
				->groupBy('member_barcode_id');
		$scans_new = [];
		foreach($scans as $scan) {
			$scans_new[$scan[0]['member_barcode_id']][0] = $scan[0];
			$scans_new[$scan[0]['member_barcode_id']][1] = $scan[sizeOf($scan) - 1];
			
			$datetime1 = new DateTime($scan[0]['date'] . " " . $scan[0]['time']);
			$datetime2 = new DateTime($scan[sizeOf($scan) - 1]['date'] . " " . $scan[sizeOf($scan) - 1]['time']);
			$interval = $datetime1->diff($datetime2);
			$scans_new[$scan[0]['member_barcode_id']][2] = $interval->format("%H:%I:%S");
		}


		$file_name = 'membersday_export.csv';
		$file = fopen($file_name, 'w');

		fputcsv($file, ['Name', 'Time In', 'Time Out', 'Total']);
		foreach ($scans_new as $scan)
		{
			fputcsv($file, [$scan[0]['member']['first_name'] . ' ' . $scan[0]['member']['last_name'], $scan[0]['time'], $scan[1]['time'], $scan[2]]);
		}
		fclose($file);

		// For Mobile Downloading Purposes
		if ($request->has('download')) {
			return response()->json(url('/') . '/' . $file_name);
		}

		return response()->download(public_path().'/'.$file_name);
	}

	public function daysmember_export(Request $request)
	{
		$this->validate($request, [
			'start_date' => 'date|required',
			'end_date' => 'date|required',
			'member' => 'required',
		]);

		$member = Member::where('barcode_id', $request->member)
				->get()->first();

		$scans = Scan::with(['member'])
			->where([
		    ['date', '>=', $request->start_date],
		    ['date', '<=', $request->end_date],
			])
			->where('member_barcode_id', $request->member)
			->where('event_id', NULL)
			->get()
			->sortBy('time')
			->groupBy('date');;

		$scans_new = [];
		foreach($scans as $scan) {
			$scans_new[$scan[0]['date']][0] = $scan[0];
			$scans_new[$scan[0]['date']][1] = $scan[sizeOf($scan) - 1];
			
			$datetime1 = new DateTime($scan[0]['date'] . " " . $scan[0]['time']);
			$datetime2 = new DateTime($scan[sizeOf($scan) - 1]['date'] . " " . $scan[sizeOf($scan) - 1]['time']);
			$interval = $datetime1->diff($datetime2);
			$scans_new[$scan[0]['date']][2] = $interval->format("%H:%I:%S");
		}

		$file_name = 'daysmember_export.csv';
		$file = fopen($file_name, 'w');

		fputcsv($file, ['Date', 'Time In', 'Time Out', 'Total']);
		foreach ($scans_new as $scan)
		{
			fputcsv($file, [$scan[0]['date'], $scan[0]['time'], $scan[1]['time'], $scan[2]]);
		}
		fclose($file);

		// For Mobile Downloading Purposes
		if ($request->has('download')) {
			return response()->json(url('/') . '/' . $file_name);
		}

		return response()->download(public_path().'/'.$file_name);
	}

	public function membersevent_export(Request $request)
	{
		$this->validate($request, [
			'event' => 'numeric|required',
		]);

		$event = Event::where('id', $request->event)
			->get()->first();

		$scans = Scan::with(['member'])
			->where('event_id', $request->event)
			->get()
			->sortBy('time')
			->groupBy('member_barcode_id');

		$file_name = 'membersevent_export.csv';
		$file = fopen($file_name, 'w');

		fputcsv($file, ['Name', 'Time In']);
		foreach ($scans as $scan)
		{
			fputcsv($file, [$scan[0]['member']['first_name'] .' ' .$scan[0]['member']['last_name'], $scan[0]['time']]);
		}
		fclose($file);

		// For Mobile Downloading Purposes
		if ($request->has('download')) {
			return response()->json(url('/') . '/' . $file_name);
		}

		return response()->download(public_path().'/'.$file_name);
	}

	public function eventsmember_export(Request $request)
	{
		$this->validate($request, [
			'member' => 'required',
		]);

		$member = Member::where('barcode_id', $request->member)
			->get()->first();

		$scans = Scan::with(['event'])
			->where('member_barcode_id', $request->member)
			->where('event_id', '>=', 0)
			->get()
			->sortBy('events.date')
			->groupBy('event_id');

		$scans_new = [];
		foreach($scans as $scan) {
			$scans_new[$scan[0]['event_id']][0] = $scan[sizeOf($scan) - 1];
		}

		$file_name = 'eventsmember_export.csv';
		$file = fopen($file_name, 'w');

		fputcsv($file, ['Event', 'Time In']);
		foreach ($scans_new as $scan)
		{
			fputcsv($file, [$scan[0]['event']['name'] .' - ' .$scan[0]['event']['date'], $scan[0]['time']]);
		}
		fclose($file);

		// For Mobile Downloading Purposes
		if ($request->has('download')) {
			return response()->json(url('/') . '/' . $file_name);
		}

		return response()->download(public_path().'/'.$file_name);
	}

	public function settings()
	{
		return view('settings.index');
	}

	public function update_settings(Request $request)
	{
		if(Auth::user()){
			
			$this->validate($request, [
				'password' => 'required|confirmed|min:6',
				
			]);
			$user = Auth::user();
			$inPass = password_hash($request['password'],PASSWORD_DEFAULT);
			if(isset($inPass)){
					if(Hash::check($request['password'],$user->password)){
						/* return response()->json(['new password'=>$inPass,'storedPass'=>$user->password]); */
						
						return view('settings.index')->with('p',$passMatch=1);
					}
					else{
						/* return response()->json(['new password','derp']); */
						
						$user->password = $inPass;
						$user->save();
						return view('settings.index')->with('p',$passMatch=0);
					}
			}
			/* return view('settings.index')->with('error','Unauthorized Page');; */
			/* return response()->json(['data',$user->password]); */
		}
		
		/* return view('settings.index'); */
	}
}
