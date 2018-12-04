<?php

namespace App\Http\Controllers;

use App\Scan;
use App\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\webSwitch;
use App\Member;


class ScansController extends Controller
{
	/**
	 * Show the application dashboard.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(Request $request)
	{
		$events = Event::all()
			->sortBy('date');
			
			$data = [
				'events'=> $events,
			];
		return view('home', ['data' => $data]);
	}

	public function dailyIndex(Request $request)//working on this
	{
		return view('daily.scan');
	}

	public function eventIndex(Request $request, $id)
	{
		$event = Event::where('id', $id)
			->first();
		return view('events.scan', ['event' => $event]);
	}

	//
	// POST requests
	// 
	// 
	
	public function inputdailyscan(Request $request)///working on this
	{

			$validator = Validator::make($request->all(),[
				'member_barcode_id' => 'required|min:1|max:100'
			]);
			
			 if ($validator->fails()) 
			 {                      
			 /*	return response()->json('damn');*/
	                return redirect('/scans/daily')
	                           ->withErrors($validator)
	                   ->withInput();                      
	     }     

	     $barcode = Member::all();
	     $cC = 0;
	     $pC = 0;
	     $bcArray = array();
	     foreach ($barcode as $bc) {
	     		$cC = strlen($bc->barcode_id);
	     		if($cC > $pC){
	     			$pC = $cC;
	     				array_push($bcArray, $cC);
	     		}
	     		
	     }
	   /*  return response()->json($cC);*/
	     
			try
			{
			$scan = new Scan;
			$scan->member_barcode_id = substr($request->member_barcode_id,0,$cC);
			$scan->date = date('Y-m-d');
			$scan->time = date('H:i:s');
			$scan->save();
			return redirect('/scans/daily');
			}
		catch(\Illuminate\Database\QueryException $e)
		{ /*dd($e->getMessage(), $e->errorInfo);*/
			 return redirect('/scans/daily')->withErrors(array('message' => 'Please make sure you have the right barcode-id.'))->withInput();                    
	  }  
	
	}
	
	public function inputeventscan(Request $request, $id)
	{
		$this->validate($request, [
			'member_barcode_id' => 'required|max:100',
		]);
		$scan = new Scan;
		$scan->member_barcode_id = $request->member_barcode_id;
		$scan->date = date('Y-m-d');
		$scan->time = date('H:i:s');
		$scan->event_id = $id;
		$scan->save();
		return redirect('/scans/event/'.$id);
	}

	/*
		API FUNCTIONS
	*/
	public function mobiledailyscan(Request $request) {
        $rules = [
            'member_barcode_id' => 'required|max:100'
        ];

        $input = $request->only('member_barcode_id');
        $validator = Validator::make($input, $rules);

        if($validator->fails()) {
            return response()->json(['success'=> false, 'error'=> $validator->messages()]);
        }

		$scan = new Scan;
		$scan->member_barcode_id = $request->member_barcode_id;
		$scan->date = date('Y-m-d');
		$scan->time = date('H:i:s');
		$scan->save();

		return response()->json(['success' => true, 'message' => 'Scan successful']);
	}

	public function mobileeventscane(Request $request, $id)
	{
        $rules = [
            'member_barcode_id' => 'required|max:100'
        ];

        $input = $request->only('member_barcode_id');
        $validator = Validator::make($input, $rules);

        if($validator->fails()) {
            return response()->json(['success'=> false, 'error'=> $validator->messages()]);
        }

		$scan = new Scan;
		$scan->member_barcode_id = $request->member_barcode_id;
		$scan->date = date('Y-m-d');
		$scan->time = date('H:i:s');
		$scan->event_id = $id;
		$scan->save();

		return response()->json(['success' => true, 'message' => 'Scan successful']);
	}
	public function disable_site(Request $request){
		$rules = [
			'state' => 'required|boolean',
			
        ];

        $input = $request->only('state');
       
        $validator = Validator::make($input, $rules);

        if($validator->fails()) {
            return response()->json(['success'=> false, 'error'=> $validator->messages()]);
		}
		$Sid = 1;
		$webSwitch = webSwitch::where('id',$Sid)->first();
		if($input == $webSwitch)
		{
			return response()->json(['success'=>false,'error'=>$webSwitch.' is already saved as the state']);
		}
		   
		$webSwitch->disabled = $input['state'];
		$webSwitch->save();
		return response()->json(['success','Switch flipped']);
	}
	
	public function is_disabled() {
	    $webSwitch = webSwitch::where('id', 1)->first();
	    
	    return response()->json($webSwitch->disabled);
	}
}