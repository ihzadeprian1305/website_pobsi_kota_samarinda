<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Agenda;
use App\Models\Athlete;
use App\Models\PoolHouse;
use App\Models\Structure;
use Carbon\Carbon;
use Exception;

class DashboardController extends Controller
{
    public function index() {
        try {
            $data['athlete_counts'] = Athlete::count();
            $data['structure_counts'] = Structure::count();
            $data['pool_house_counts'] = PoolHouse::count();
            $data['today_agenda_counts'] = Agenda::whereDate('created_at', Carbon::now())->count();

            return view('admin.dashboard.index', $data);
        } catch (Exception $error) {
            return redirect()->back()->with('status', $error->getMessage());
        }
    }
}
