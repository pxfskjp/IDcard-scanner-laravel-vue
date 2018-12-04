<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Member;

class MembersController extends Controller
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
		$members = Member::orderBy('member')->paginate(config('global.pagination'));
		$title = 'Members';
		if($request->ajax())
			return view('members.load', compact('members'));
		return view('members.index', compact('members', 'title'));
	}

	public function all(Request $request)
	{
		// If the search term is set
		if(isset($_GET['term'])) {
			// Trim the search term
			$search = rtrim(ltrim($_GET['term']));
			if(strpos($search, ' ') > 0) {
				$search = explode(' ', $search);
				$members = Member::select('id','first_name', 'last_name')
					->where('first_name', 'like', '%'.$search[0].'%')
					->orWhere('last_name', 'like', '%'.$search[1].'%')
					->orderBy('first_name')
					->get();
			}
			$members = Member::select('id','first_name', 'last_name')
				->where('first_name', 'like', '%'.$search.'%')
				->orWhere('last_name', 'like', '%'.$search.'%')
				->orderBy('first_name')
				->get();
		} else {
			$members = Member::select('id','first_name', 'last_name')
				->orderBy('first_name')
				->get();
		}	
		return $members;
	}

	public function createIndex()
	{
		$title = 'Create Member';
		return view('members.create', compact('title'));
	}

	public function editIndex(Request $request, $id)
	{
		$member = Member::find($id);
		$title = 'Edit Member';
		return view('members.edit', compact('member', 'title'));
	}

	public function delete(Request $request, $id)
	{
		Member::find($id)->delete();
		return redirect('/members')->with('success', 'Member was deleted!');
	}

	public function create(Request $request)
	{
		$this->validate($request, [
			'first_name' => config('global.in_std_r'),
			'last_name' => config('global.in_std_r'),
			'provider_id' => config('global.in_int_r'),
			'address' => config('global.in_addr'),
			'city' => config('global.in_addr'),
			'postal' => config('global.in_postal'),
		]);
		$member = Member::create($request->input());
		return redirect('/members/edit/'.$member->id);
	}

	public function edit(Request $request, $id)
	{
		$this->validate($request, [
			'member' => config('global.in_std_r'),
			'provider_id' => config('global.in_int_r'),
			'address' => config('global.in_addr'),
			'city' => config('global.in_addr'),
			'postal' => config('global.in_postal'),
		]);
		Member::find($id)->update($request->input());
		return redirect('/members/edit/'.$id);
	}
}
