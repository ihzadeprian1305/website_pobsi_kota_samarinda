<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PoolHouse;
use App\Models\PoolHouseImage;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class PoolHouseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (request()->ajax()) {
            $users = PoolHouse::query();
            return DataTables::of($users)
            ->addIndexColumn()
            ->addColumn('action', function($row){
                $showBtn = '<a href="/admin/pool-houses/'.$row->id.'" id="btn_show_pool-houses" class="show btn btn-info btn-sm me-1">Lihat</a>';
                $editBtn = '<a href="/admin/pool-houses/'.$row->id.'/edit" id="btn_update_pool-houses" class="edit btn btn-primary btn-sm me-1">Ubah</a>';
                $deleteBtn = '<form action="/admin/pool-houses/'.$row->id.'" method="POST">' .
                            '<input type="hidden" name="_method" value="DELETE">' .
                            csrf_field() .
                            '<button type="submit" class="delete btn btn-danger btn-sm">Hapus</button>' .
                            '</form>';
                return $showBtn . $editBtn . $deleteBtn;
            })
            ->rawColumns(['action'])
            ->make();
        }
        return view('admin.pool_houses.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.pool_houses.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'image' => ['required', 'array'],
                'image.*' => ['file', 'mimes:jpeg,png,jpg', 'max:2048'],
                'name' => ['required'],
                'address' => ['required'],
                'link_address' => ['required'],
                'description' => ['required'],
                'owner_name' => ['required'],
                'phone_number' => ['required'],
                'open_time' => ['required'],
                'close_time' => ['required'],
            ]);

            if($validator->fails()){
                return redirect()->back()->withErrors($validator)->withInput();
            }

            DB::transaction(function() use($request) {
                    $pool_house = PoolHouse::create([
                        'name' => $request->name,
                        'address' => $request->address,
                        'link_address' => $request->link_address,
                        'description' => $request->description,
                        'owner_name' => $request->owner_name,
                        'phone_number' => $request->phone_number,
                        'open_time' => $request->open_time,
                        'close_time' => $request->close_time,
                    ]);

                    $pool_house_id = $pool_house->id;

                    foreach ($request->file('image') as $image) {
                        $originalName = $image->getClientOriginalName();

                        $uniqueName =  time() . '_' . $originalName;

                        $imagePath = $image->storeAs('pool-house-images', $uniqueName);

                        PoolHouseImage::create([
                            'pool_house_id' => $pool_house_id,
                            'image' => $imagePath,
                            'image_name' => $originalName,
                        ]);
                    }
            });

            return redirect('/admin/pool-houses')->with('status', 'Data Rumah Biliard Berhasil Ditambahkan');
        }
        catch (Exception $error) {
            return redirect()->back()->with('status', $error->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(PoolHouse $poolHouse)
    {
        try {
            return view('admin.pool_houses.show', ['poolHouse' => $poolHouse]);
        } catch (Exception $error) {
            return redirect()->back()->with('status', $error->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PoolHouse $poolHouse)
    {
        try {
            return view('admin.pool_houses.edit', ['poolHouse' => $poolHouse]);
        } catch (Exception $error) {
            return redirect()->back()->with('status', $error->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PoolHouse $poolHouse)
    {
        try {
            if(count($poolHouse->pool_house_images) > 0){
                $validator = Validator::make($request->all(), [
                    'image' => ['array'],
                    'image.*' => ['file', 'mimes:jpeg,png,jpg', 'max:2048'],
                    'name' => ['required'],
                    'address' => ['required'],
                    'link_address' => ['required'],
                    'description' => ['required'],
                    'owner_name' => ['required'],
                    'phone_number' => ['required'],
                    'open_time' => ['required'],
                    'close_time' => ['required'],
                ]);
            } else {
                $validator = Validator::make($request->all(), [
                    'image' => ['required', 'array'],
                    'image.*' => ['file', 'mimes:jpeg,png,jpg', 'max:2048'],
                    'name' => ['required'],
                    'address' => ['required'],
                    'link_address' => ['required'],
                    'description' => ['required'],
                    'owner_name' => ['required'],
                    'phone_number' => ['required'],
                    'open_time' => ['required'],
                    'close_time' => ['required'],
                ]);
            }

            if($validator->fails()){
                return redirect()->back()->withErrors($validator)->withInput();
            }

            DB::transaction(function() use($request, $poolHouse) {
                if($request->file('image')){
                    $poolHouse->update([
                        'name' => $request->name,
                        'address' => $request->address,
                        'link_address' => $request->link_address,
                        'description' => $request->description,
                        'owner_name' => $request->owner_name,
                        'phone_number' => $request->phone_number,
                        'open_time' => $request->open_time,
                        'close_time' => $request->close_time,
                    ]);

                    foreach ($request->file('image') as $image) {
                        $originalName = $image->getClientOriginalName();

                        $uniqueName =  time() . '_' . $originalName;

                        $imagePath = $image->storeAs('pool-house-images', $uniqueName);

                        PoolHouseImage::create([
                            'pool_house_id' => $poolHouse->id,
                            'image' => $imagePath,
                            'image_name' => $originalName,
                        ]);
                    }
                } else{
                    $poolHouse->update([
                        'name' => $request->name,
                        'address' => $request->address,
                        'link_address' => $request->link_address,
                        'description' => $request->description,
                        'owner_name' => $request->owner_name,
                        'phone_number' => $request->phone_number,
                        'open_time' => $request->open_time,
                        'close_time' => $request->close_time,
                    ]);
                }
            });

            return redirect('/admin/pool-houses')->with('status', 'Data Rumah Biliar Berhasil Diubah');
        } catch (Exception $error) {
            return redirect()->back()->with('status', $error->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PoolHouse $poolHouse)
    {
        try {
            DB::transaction(function() use($poolHouse) {
                $pool_house_image = $poolHouse->pool_house_images;
                foreach ($pool_house_image as $phi) {
                    if(File::exists('storage/'. $phi->image)){
                        File::delete('storage/'. $phi->image);
                    }

                }

                $poolHouse->pool_house_images()->delete();
                $poolHouse->delete();
            });

            return redirect('/admin/pool-houses')->with('status', 'Data Rumah Biliar Berhasil Dihapus');
        } catch (Exception $error) {
            return redirect()->back()->with('status', $error->getMessage());
        }
    }

    public function destroyImage($id){
        $poolHouseImage = PoolHouseImage::where('id', $id)->firstOrFail();

        if(File::exists('storage/'. $poolHouseImage->image)){
            File::delete('storage/'. $poolHouseImage->image);
        }

        $poolHouseImage->delete();

        return redirect()->back()->with('success', 'Data Foto Rumah Biliar Berhasil Dihapus');
    }
}
