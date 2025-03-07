<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Athlete;
use App\Models\Handicap;
use App\Models\Standing;

class UserAthleteInformationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('user.athlete_information');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function athlete()
    {
        $data['athletes'] = Athlete::paginate(10);

        return view('user.athletes', $data);
    }

    public function athleteDetail(Athlete $athlete)
    {
        $data['athlete'] = $athlete;

        return view('user.athlete_details', $data);
    }

    public function standingIndex()
    {
        $handicaps_name = ['4', '3', '3B', '2'];

        $data['handicaps'] = Handicap::whereIn('name', $handicaps_name)->get();

        return view('user.athletes_standing_informations', $data);
    }

    public function standing(Handicap $handicap)
    {
        $data['standings'] = Standing::where('handicap_id', $handicap->id)->orderBy('total_points', 'desc')->paginate(10);

        return view('user.standings', $data);
    }
}
