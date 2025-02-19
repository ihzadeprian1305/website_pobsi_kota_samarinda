<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Agenda;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class AgendaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (request()->ajax()) {
            $users = Agenda::query();
            return DataTables::of($users)
            ->addIndexColumn()
            ->addColumn('action', function($row){
                $showBtn = '<a href="/admin/agendas/'.$row->id.'" id="btn_show_agendas" class="show btn btn-info btn-sm me-1">Lihat</a>';
                $editBtn = '<a href="/admin/agendas/'.$row->id.'/edit" id="btn_update_agendas" class="edit btn btn-primary btn-sm me-1">Ubah</a>';
                $deleteBtn = '<form action="/admin/agendas/'.$row->id.'" method="POST">' .
                            '<input type="hidden" name="_method" value="DELETE">' .
                            csrf_field() .
                            '<button type="submit" class="delete btn btn-danger btn-sm">Hapus</button>' .
                            '</form>';
                return $showBtn . $editBtn . $deleteBtn;
            })
            ->rawColumns(['action'])
            ->make();
        }
        return view('admin.agendas.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.agendas.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'date' => ['required'],
                'time' => ['required'],
                'activity' => ['required'],
                'description' => ['required'],
                'location' => ['required'],
                'attended_by' => ['required'],
            ]);

            if($validator->fails()){
                return redirect()->back()->withErrors($validator)->withInput();
            }

            DB::transaction(function() use($request) {
                Agenda::create([
                    'date' => $request->date,
                    'time' => $request->time,
                    'activity' => $request->activity,
                    'description' => $request->description,
                    'location' => $request->location,
                    'attended_by' => $request->attended_by,
                ]);
            });

            return redirect('/admin/agendas')->with('status', 'Data Agenda Berhasil Ditambahkan');
        }
        catch (Exception $error) {
            return redirect()->back()->with('status', $error->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Agenda $agenda)
    {
        try {
            return view('admin.agendas.show', ['agenda' => $agenda]);
        } catch (Exception $error) {
            return redirect()->back()->with('status', $error->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Agenda $agenda)
    {
        try {
            return view('admin.agendas.edit', ['agenda' => $agenda]);
        } catch (Exception $error) {
            return redirect()->back()->with('status', $error->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Agenda $agenda)
    {
        try {
            $validator = Validator::make($request->all(), [
                'date' => ['required'],
                'time' => ['required'],
                'activity' => ['required'],
                'description' => ['required'],
                'location' => ['required'],
                'attended_by' => ['required'],
            ]);

            if($validator->fails()){
                return redirect()->back()->withErrors($validator)->withInput();
            }

            DB::transaction(function() use($request, $agenda) {
                $agenda->update([
                    'date' => $request->date,
                    'time' => $request->time,
                    'activity' => $request->activity,
                    'description' => $request->description,
                    'location' => $request->location,
                    'attended_by' => $request->attended_by,
                ]);
            });

            return redirect('/admin/agendas')->with('status', 'Data Agenda Berhasil Diubah');
        } catch (Exception $error) {
            return redirect()->back()->with('status', $error->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Agenda $agenda)
    {
        try {
            DB::transaction(function() use($agenda) {
                $agenda->delete();
            });

            return redirect('/admin/agendas')->with('status', 'Data Agenda Berhasil Dihapus');
        } catch (Exception $error) {
            return redirect()->back()->with('status', $error->getMessage());
        }
    }
}
