<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Agenda;
use Exception;

class UserAgendaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try{
            $startDate = Carbon::now()->subMonth(2)->startOfMonth();
            $endDate = Carbon::now()->addMonth(2)->endOfMonth();

            $data['startDate'] = $startDate->format('Y-m-d');
            $data['endDate'] = $endDate->format('Y-m-d');
            $data['agendas'] = Agenda::whereBetween('date', [$startDate, $endDate])->get();

            return view('user.agenda', $data);
        } catch(Exception $error) {
            dd($error);
        }
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
