<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Athlete;
use App\Models\AthleteImage;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class AthleteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (request()->ajax()) {
            $users = Athlete::query();
            return DataTables::of($users)
            ->addIndexColumn()
            ->addColumn('action', function($row){
                $showBtn = '<a href="/admin/athletes/'.$row->id.'" id="btn_show_athletes" class="show btn btn-info btn-sm me-1">Lihat</a>';
                $editBtn = '<a href="/admin/athletes/'.$row->id.'/edit" id="btn_update_athletes" class="edit btn btn-primary btn-sm me-1">Ubah</a>';
                $deleteBtn = '<form action="/admin/athletes/'.$row->id.'" method="POST">' .
                            '<input type="hidden" name="_method" value="DELETE">' .
                            csrf_field() .
                            '<button type="submit" class="delete btn btn-danger btn-sm">Hapus</button>' .
                            '</form>';
                return $showBtn . $editBtn . $deleteBtn;
            })
            ->rawColumns(['action'])
            ->make();
        }
        return view('admin.athletes.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.athletes.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'image' => ['required', 'file', 'mimes:jpeg,png,jpg', 'max:2048'],
                'name' => ['required'],
                'born_date' => ['required'],
                'sex' => ['required'],
                'career_description' => ['required'],
            ]);

            if($validator->fails()){
                return redirect()->back()->withErrors($validator)->withInput();
            }

            DB::transaction(function() use($request) {
                $athlete = Athlete::create([
                    'name' => $request->name,
                    'born_date' => $request->born_date,
                    'sex' => $request->sex,
                    'career_description' => $request->career_description,
                ]);

                $athlete_id = $athlete->id;

                $originalName = $request->file('image')->getClientOriginalName();

                $uniqueName =  time() . '_' . $originalName;

                $imagePath = $request->file('image')->storeAs('athlete-images', $uniqueName);

                AthleteImage::create([
                    'image' => $imagePath,
                    'image_name' => $originalName,
                    'athlete_id' => $athlete_id
                ]);
            });

            return redirect('/admin/athletes')->with('status', 'Data Atlet Berhasil Ditambahkan');
        }
        catch (Exception $error) {
            return redirect()->back()->with('status', $error->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Athlete $athlete)
    {
        try {
            return view('admin.athletes.show', ['athlete' => $athlete]);
        } catch (Exception $error) {
            return redirect()->back()->with('status', $error->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Athlete $athlete)
    {
        try {
            return view('admin.athletes.edit', ['athlete' => $athlete]);
        } catch (Exception $error) {
            return redirect()->back()->with('status', $error->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Athlete $athlete)
    {
        try {
            $validator = Validator::make($request->all(), [
                'image' => ['file', 'mimes:jpeg,png,jpg', 'max:2048'],
                'name' => ['required'],
                'born_date' => ['required'],
                'sex' => ['required'],
                'career_description' => ['required'],
            ]);

            if($validator->fails()){
                return redirect()->back()->withErrors($validator)->withInput();
            }

            DB::transaction(function() use($request, $athlete) {
                if($request->file('image')){
                    $athlete_image = $athlete->athlete_images->image;
                    if(File::exists('storage/'. $athlete_image)){
                        File::delete('storage/'. $athlete_image);
                    }

                    $athlete->update([
                        'name' => $request->name,
                        'born_date' => $request->born_date,
                        'sex' => $request->sex,
                        'career_description' => $request->career_description,
                    ]);

                    $originalName = $request->file('image')->getClientOriginalName();

                    $uniqueName =  time() . '_' . $originalName;

                    $imagePath = $request->file('image')->storeAs('athlete-images', $uniqueName);

                    $athlete->athlete_images->update([
                        'image' => $imagePath,
                        'image_name' => $originalName,
                    ]);
                } else{
                    $athlete->update([
                        'name' => $request->name,
                        'born_date' => $request->born_date,
                        'sex' => $request->sex,
                        'career_description' => $request->career_description,
                    ]);
                }
            });

            return redirect('/admin/athletes')->with('status', 'Data Atlet Berhasil Diubah');
        } catch (Exception $error) {
            return redirect()->back()->with('status', $error->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Athlete $athlete)
    {
        try {
            DB::transaction(function() use($athlete) {
                $athlete_image = $athlete->image;
                if(File::exists('storage/'. $athlete_image)){
                    File::delete('storage/'. $athlete_image);
                }

                $athlete->athlete_images->delete();
                $athlete->standings->delete();
                $athlete->delete();
            });

            return redirect('/admin/athletes')->with('status', 'Data Atlet Berhasil Dihapus');
        } catch (Exception $error) {
            return redirect()->back()->with('status', $error->getMessage());
        }
    }
}
