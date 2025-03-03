<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Athlete;
use App\Models\AthleteImage;
use App\Models\Standing;
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
            if($request->pool_house_id == '-'){
                $validator = Validator::make($request->all(), [
                    'image' => ['required', 'file', 'mimes:jpeg,png,jpg', 'max:2048'],
                    'name' => ['required'],
                    'born_date' => ['required'],
                    'pool_house_id' => ['required'],
                    'another_pool_house' => ['required'],
                    'handicap_id' => ['required'],
                    'sex' => ['required'],
                    'career_description' => ['required'],
                ]);
            } else {
                $validator = Validator::make($request->all(), [
                    'image' => ['required', 'file', 'mimes:jpeg,png,jpg', 'max:2048'],
                    'name' => ['required'],
                    'born_date' => ['required'],
                    'pool_house_id' => ['required'],
                    'handicap_id' => ['required'],
                    'sex' => ['required'],
                    'career_description' => ['required'],
                ]);
            }

            if($validator->fails()){
                return redirect()->back()->withErrors($validator)->withInput();
            }

            DB::transaction(function() use($request) {
                if($request->pool_house_id == '-' && $request->another_pool_house){
                    $athlete = Athlete::create([
                        'name' => $request->name,
                        'born_date' => $request->born_date,
                        'another_pool_house' => $request->another_pool_house,
                        'sex' => $request->sex,
                        'career_description' => $request->career_description,
                    ]);
                }else{
                    $athlete = Athlete::create([
                        'name' => $request->name,
                        'born_date' => $request->born_date,
                        'pool_house_id' => $request->pool_house_id,
                        'sex' => $request->sex,
                        'career_description' => $request->career_description,
                    ]);
                }

                $athlete_id = $athlete->id;

                $originalName = $request->file('image')->getClientOriginalName();

                $uniqueName =  time() . '_' . $originalName;

                $imagePath = $request->file('image')->storeAs('athlete-images', $uniqueName);

                AthleteImage::create([
                    'image' => $imagePath,
                    'image_name' => $originalName,
                    'athlete_id' => $athlete_id
                ]);

                Standing::create([
                    'athlete_id' => $athlete_id,
                    'handicap_id' => $request->handicap_id,
                    'total_points' => 0,
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
            if($request->pool_house_id == '-'){
                $validator = Validator::make($request->all(), [
                    'image' => ['file', 'mimes:jpeg,png,jpg', 'max:2048'],
                    'name' => ['required'],
                    'born_date' => ['required'],
                    'pool_house_id' => ['required'],
                    'another_pool_house' => ['required'],
                    'handicap_id' => ['required'],
                    'sex' => ['required'],
                    'career_description' => ['required'],
                ]);
            } else {
                $validator = Validator::make($request->all(), [
                    'image' => ['file', 'mimes:jpeg,png,jpg', 'max:2048'],
                    'name' => ['required'],
                    'born_date' => ['required'],
                    'pool_house_id' => ['required'],
                    'handicap_id' => ['required'],
                    'sex' => ['required'],
                    'career_description' => ['required'],
                ]);
            }

            if($validator->fails()){
                return redirect()->back()->withErrors($validator)->withInput();
            }

            DB::transaction(function() use($request, $athlete) {
                if($request->file('image')){
                    $athlete_image = $athlete->athlete_images->image;
                    if(File::exists('storage/'. $athlete_image)){
                        File::delete('storage/'. $athlete_image);
                    }

                    if($request->pool_house_id == '-' && $request->another_pool_house){
                        $athlete->update([
                            'name' => $request->name,
                            'born_date' => $request->born_date,
                            'pool_house_id' => null,
                            'another_pool_house' => $request->another_pool_house,
                            'sex' => $request->sex,
                            'career_description' => $request->career_description,
                        ]);
                    } else {
                        $athlete->update([
                            'name' => $request->name,
                            'born_date' => $request->born_date,
                            'pool_house_id' => $request->pool_house_id,
                            'another_pool_house' => null,
                            'sex' => $request->sex,
                            'career_description' => $request->career_description,
                        ]);
                    }

                    $originalName = $request->file('image')->getClientOriginalName();

                    $uniqueName =  time() . '_' . $originalName;

                    $imagePath = $request->file('image')->storeAs('athlete-images', $uniqueName);

                    $athlete->athlete_images->update([
                        'image' => $imagePath,
                        'image_name' => $originalName,
                    ]);

                    $athlete->standings->update([
                        'handicap_id' => $request->handicap_id,
                    ]);
                } else{
                    if($request->pool_house_id == '-' && $request->another_pool_house){
                        $athlete->update([
                            'name' => $request->name,
                            'born_date' => $request->born_date,
                            'pool_house_id' => null,
                            'another_pool_house' => $request->another_pool_house,
                            'sex' => $request->sex,
                            'career_description' => $request->career_description,
                        ]);
                    } else {
                        $athlete->update([
                            'name' => $request->name,
                            'born_date' => $request->born_date,
                            'pool_house_id' => $request->pool_house_id,
                            'another_pool_house' => null,
                            'sex' => $request->sex,
                            'career_description' => $request->career_description,
                        ]);
                    }

                    $athlete->standings->update([
                        'handicap_id' => $request->handicap_id,
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
