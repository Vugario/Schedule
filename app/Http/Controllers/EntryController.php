<?php namespace App\Http\Controllers;

use App\Entry;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Library\Karbon;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;

class EntryController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$dates = $this->getDates();
		$times = $this->getTimes();

		return view('entry.create', compact('dates', 'times'));
	}

	protected function getDates()
	{
		$timestamp = Karbon::now()->subDay();
		$dates = ['Wanneer?'];

		for ($i = 0; $i < 150; $i++)
		{
			$timestamp = $timestamp->addDay();

			$dates[$timestamp->format('U')] = $timestamp->format('l j F');
		}

		return $dates;
	}

	protected function getTimes()
	{
		$timestamp = Karbon::create(date('Y'), date('m'), date('d'), 6, 0);
		$times = ['Vanaf hoelaat?'];

		for ($i = 0; $i < 68; $i++)
		{
			$timestamp = $timestamp->addMinutes(15);

			$times[$timestamp->format('U')] = $timestamp->format('H:i');
		}

		return $times;
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(Request $request)
	{
		$this->validate($request, [
			'description'		=> 'required',
			'date'				=> 'required|min:2',
			'time'				=>	'required|min:2'
		]);

        $time = Carbon::createFromFormat('U', Input::get('time'));
        $visitAt = Carbon::createFromFormat('U', Input::get('date'));
        $visitAt = $visitAt->setTime($time->format('H'), $time->format('i'));

		$entry = [
			'user_id'		=> Auth::user()->id,
			'description'	=> Input::get('description'),
			'visit_at'		=> $visitAt
		];

		$entry = Entry::create($entry);

		return redirect('/')->with('message', 'Je afspraak is toegevoegd!');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}
