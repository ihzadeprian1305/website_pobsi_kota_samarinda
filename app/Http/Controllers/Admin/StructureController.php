<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Structure;
use App\Models\StructureImage;
use App\Models\StructurePosition;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class StructureController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (request()->ajax()) {
            $users = Structure::query();
            return DataTables::of($users)
            ->addIndexColumn()
            ->addColumn('position', function ($users) {
                return $users->structure_positions->name;
            })
            ->addColumn('action', function($row){
                $showBtn = '<a href="/admin/structures/'.$row->id.'" id="btn_show_structures" class="show btn btn-info btn-sm me-1">Lihat</a>';
                $editBtn = '<a href="/admin/structures/'.$row->id.'/edit" id="btn_update_structures" class="edit btn btn-primary btn-sm me-1">Ubah</a>';
                $deleteBtn = '<form action="/admin/structures/'.$row->id.'" method="POST">' .
                            '<input type="hidden" name="_method" value="DELETE">' .
                            csrf_field() .
                            '<button type="submit" class="delete btn btn-danger btn-sm">Hapus</button>' .
                            '</form>';
                return $showBtn . $editBtn . $deleteBtn;
            })
            ->rawColumns(['action'])
            ->make();
        }
        return view('admin.structures.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $allPositions = StructurePosition::all();

        $availablePositions = $allPositions->filter(function ($position) {
            $currentCount = Structure::where('structure_position_id', $position->id)->count();
            return $currentCount < $position->maximum_position;
        });

        $data['availablePositions'] = $availablePositions->pluck('id')->toArray();

        return view('admin.structures.create', $data);
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
                'description' => ['required'],
                'structure_position_id' => ['required']
            ]);

            if($validator->fails()){
                return redirect()->back()->withErrors($validator)->withInput();
            }

            DB::transaction(function() use($request) {
                $structure = Structure::create([
                    'name' => $request->name,
                    'born_date' => $request->born_date,
                    'sex' => $request->sex,
                    'description' => $request->description,
                    'structure_position_id' => $request->structure_position_id,
                ]);

                $structure_id = $structure->id;

                $originalName = $request->file('image')->getClientOriginalName();

                $uniqueName =  time() . '_' . $originalName;

                $imagePath = $request->file('image')->storeAs('structure-images', $uniqueName);

                StructureImage::create([
                    'image' => $imagePath,
                    'image_name' => $originalName,
                    'structure_id' => $structure_id
                ]);
            });

            return redirect('/admin/structures')->with('status', 'Data Atlet Berhasil Ditambahkan');
        }
        catch (Exception $error) {
            return redirect()->back()->with('status', $error->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Structure $structure)
    {
        try {
            return view('admin.structures.show', ['structure' => $structure]);
        } catch (Exception $error) {
            return redirect()->back()->with('status', $error->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Structure $structure)
    {
        try {
            $allPositions = StructurePosition::all();

            $currentPositionId = $structure->structure_position_id;

            $availablePositions = $allPositions->filter(function ($position) use ($currentPositionId) {
                $currentCount = Structure::where('structure_position_id', $position->id)->count();
                return $position->id === $currentPositionId || $currentCount < $position->maximum_position;
            });

            $availablePositionsFinal = $availablePositions->pluck('id')->toArray();

            return view('admin.structures.edit', ['structure' => $structure, 'availablePositions' => $availablePositionsFinal]);
        } catch (Exception $error) {
            return redirect()->back()->with('status', $error->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Structure $structure)
    {
        try {
            $validator = Validator::make($request->all(), [
                'image' => ['file', 'mimes:jpeg,png,jpg', 'max:2048'],
                'name' => ['required'],
                'born_date' => ['required'],
                'sex' => ['required'],
                'description' => ['required'],
                'structure_position_id' => ['required']
            ]);

            if($validator->fails()){
                return redirect()->back()->withErrors($validator)->withInput();
            }

            DB::transaction(function() use($request, $structure) {
                if($request->file('image')){
                    $structure_image = $structure->structure_images->image;
                    if(File::exists('storage/'. $structure_image)){
                        File::delete('storage/'. $structure_image);
                    }

                    $structure->update([
                        'name' => $request->name,
                        'born_date' => $request->born_date,
                        'sex' => $request->sex,
                        'description' => $request->description,
                        'structure_position_id' => $request->structure_position_id,
                    ]);

                    $originalName = $request->file('image')->getClientOriginalName();

                    $uniqueName =  time() . '_' . $originalName;

                    $imagePath = $request->file('image')->storeAs('structure-images', $uniqueName);

                    $structure->structure_images->update([
                        'image' => $imagePath,
                        'image_name' => $originalName,
                    ]);
                } else{
                    $structure->update([
                        'name' => $request->name,
                        'born_date' => $request->born_date,
                        'sex' => $request->sex,
                        'description' => $request->description,
                        'structure_position_id' => $request->structure_position_id,
                    ]);
                }
            });

            return redirect('/admin/structures')->with('status', 'Data Atlet Berhasil Diubah');
        } catch (Exception $error) {
            return redirect()->back()->with('status', $error->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Structure $structure)
    {
        try {
            DB::transaction(function() use($structure) {
                $structure_image = $structure->image;
                if(File::exists('storage/'. $structure_image)){
                    File::delete('storage/'. $structure_image);
                }

                $structure->structure_images->delete();
                $structure->delete();
            });

            return redirect('/admin/structures')->with('status', 'Data Atlet Berhasil Dihapus');
        } catch (Exception $error) {
            return redirect()->back()->with('status', $error->getMessage());
        }
    }
}
