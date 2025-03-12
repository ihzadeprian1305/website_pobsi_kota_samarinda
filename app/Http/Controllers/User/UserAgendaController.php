<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Agenda;

class UserAgendaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $data['agendas'] = Agenda::whereMonth('created_at', Carbon::now()->month)->get();

        return view('user.agenda', );
    //     if($request->ajax()) {

    //         $data['agendas'] = Agenda::whereDate('start', '>=', Carbon::ncreateFromFormat('Y-m-d', '2025-01-01'))
    //                   ->whereDate('end',   '<=', createFromFormat('Y-m-d', '2016-03-31'))
    //                   ->get(['id', 'activity', 'start', 'end']);

    //         return response()->json($data);
    //    }
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
}
