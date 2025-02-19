<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Handicap;
use App\Models\Standing;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class StandingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (request()->ajax()) {
            $users = Standing::query()
            ->with('handicaps')
            ->orderBy(Handicap::select('name')->whereColumn('handicaps.id', 'standings.handicap_id'), 'desc')
            ->get();
            return DataTables::of($users)
            ->addIndexColumn()
            ->addColumn('name', function ($users) {
                return $users->athletes->name;
            })
            ->addColumn('handicap', function ($users) {
                return $users->handicaps->name;
            })
            ->addColumn('action', function($row){
                $showBtn = '<a href="/admin/standings/'.$row->id.'" id="btn_show_standings" class="show btn btn-info btn-sm me-1">Lihat</a>';
                $editBtn = '<a href="/admin/standings/'.$row->id.'/edit" id="btn_update_standings" class="edit btn btn-primary btn-sm me-1">Ubah</a>';
                $deleteBtn = '<form action="/admin/standings/'.$row->id.'" method="POST">' .
                            '<input type="hidden" name="_method" value="DELETE">' .
                            csrf_field() .
                            '<button type="submit" class="delete btn btn-danger btn-sm">Hapus</button>' .
                            '</form>';
                return
                $showBtn . $editBtn . $deleteBtn;
            })
            ->rawColumns(['action'])
            ->make();
        }
        return view('admin.standings.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data['existingAthleteIds'] = Standing::pluck('athlete_id')->toArray();

        return view('admin.standings.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'athlete_id' => ['required'],
                'handicap_id' => ['required'],
                'total_points' => ['required'],
                'description' => ['max:4096'],
            ]);

            if($validator->fails()){
                return redirect()->back()->withErrors($validator)->withInput();
            }

            DB::transaction(function() use($request) {
                Standing::create([
                    'athlete_id' => $request->athlete_id,
                    'handicap_id' => $request->handicap_id,
                    'total_points' => $request->total_points,
                    'description' => $request->description,
                ]);
            });

            return redirect('/admin/standings')->with('status', 'Data Klasemen Berhasil Ditambahkan');
        }
        catch (Exception $error) {
            return redirect()->back()->with('status', $error->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Standing $standing)
    {
        try {
            return view('admin.standings.show', ['standing' => $standing]);
        } catch (Exception $error) {
            return redirect()->back()->with('status', $error->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Standing $standing)
    {
        try {
            return view('admin.standings.edit', ['standing' => $standing]);
        } catch (Exception $error) {
            return redirect()->back()->with('status', $error->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Standing $standing)
    {
        try {
            $validator = Validator::make($request->all(), [
                'athlete_id' => ['required'],
                'handicap_id' => ['required'],
                'total_points' => ['required'],
                'description' => ['max:4096'],
            ]);

            if($validator->fails()){
                return redirect()->back()->withErrors($validator)->withInput();
            }

            DB::transaction(function() use($request, $standing) {
                $standing->update([
                    'athlete_id' => $request->athlete_id,
                    'handicap_id' => $request->handicap_id,
                    'total_points' => $request->total_points,
                    'description' => $request->description,
                ]);
            });

            return redirect('/admin/standings')->with('status', 'Data Klasemen Berhasil Diubah');
        } catch (Exception $error) {
            return redirect()->back()->with('status', $error->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Standing $standing)
    {
        try {
            DB::transaction(function() use($standing) {
                $standing->delete();
            });

            return redirect('/admin/standings')->with('status', 'Data Klasemen Berhasil Dihapus');
        } catch (Exception $error) {
            return redirect()->back()->with('status', $error->getMessage());
        }
    }
}
