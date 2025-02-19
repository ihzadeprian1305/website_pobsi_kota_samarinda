<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HomeSlider;
use App\Models\HomeSliderImage;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class HomeSliderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (request()->ajax()) {
            $users = HomeSlider::query();
            return DataTables::of($users)
            ->addIndexColumn()
            ->addColumn('action', function($row){
                $showBtn = '<a href="/admin/home-sliders/'.$row->id.'" id="btn_show_home_sliders" class="show btn btn-info btn-sm me-1">Lihat</a>';
                $editBtn = '<a href="/admin/home-sliders/'.$row->id.'/edit" id="btn_update_home_sliders" class="edit btn btn-primary btn-sm me-1">Ubah</a>';
                $deleteBtn = '<form action="/admin/home-sliders/'.$row->id.'" method="POST">' .
                            '<input type="hidden" name="_method" value="DELETE">' .
                            csrf_field() .
                            '<button type="submit" class="delete btn btn-danger btn-sm">Hapus</button>' .
                            '</form>';
                return $showBtn . $editBtn . $deleteBtn;
            })
            ->rawColumns(['action'])
            ->make();
        }
        return view('admin.home_sliders.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.home_sliders.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'image' => ['required', 'file', 'mimes:jpeg,png,jpg', 'max:4096'],
                'title' => ['required'],
                'caption' => ['required'],
                'link' => ['required'],
            ]);

            if($validator->fails()){
                return redirect()->back()->withErrors($validator)->withInput();
            }

            DB::transaction(function() use($request) {
                $home_slider = HomeSlider::create([
                    'title' => $request->title,
                    'caption' => $request->caption,
                    'link' => $request->link,
                ]);

                $home_slider_id = $home_slider->id;

                $originalName = $request->file('image')->getClientOriginalName();

                $uniqueName =  time() . '_' . $originalName;

                $imagePath = $request->file('image')->storeAs('home-slider-images', $uniqueName);

                HomeSliderImage::create([
                    'image' => $imagePath,
                    'image_name' => $originalName,
                    'home_slider_id' => $home_slider_id
                ]);
            });

            return redirect('/admin/home-sliders')->with('status', 'Data Slider Beranda Berhasil Ditambahkan');
        }
        catch (Exception $error) {
            return redirect()->back()->with('status', $error->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(HomeSlider $homeSlider)
    {
        try {
            return view('admin.home_sliders.show', ['home_slider' => $homeSlider]);
        } catch (Exception $error) {
            return redirect()->back()->with('status', $error->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(HomeSlider $homeSlider)
    {
        try {
            return view('admin.home_sliders.edit', ['home_slider' => $homeSlider]);
        } catch (Exception $error) {
            return redirect()->back()->with('status', $error->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, HomeSlider $homeSlider)
    {
        try {
            $validator = Validator::make($request->all(), [
                'image' => ['file', 'mimes:jpeg,png,jpg', 'max:4096'],
                'title' => ['required'],
                'caption' => ['required'],
                'link' => ['required'],
            ]);

            if($validator->fails()){
                return redirect()->back()->withErrors($validator)->withInput();
            }

            DB::transaction(function() use($request, $homeSlider) {
                if($request->file('image')){
                    $home_slider_image = $homeSlider->home_slider_images->image;
                    if(File::exists('storage/'. $home_slider_image)){
                        File::delete('storage/'. $home_slider_image);
                    }

                    $homeSlider->update([
                        'title' => $request->title,
                        'caption' => $request->caption,
                        'link' => $request->link,
                    ]);

                    $originalName = $request->file('image')->getClientOriginalName();

                    $uniqueName =  time() . '_' . $originalName;

                    $imagePath = $request->file('image')->storeAs('home-slider-images', $uniqueName);

                    $homeSlider->home_slider_images->update([
                        'image' => $imagePath,
                        'image_name' => $originalName,
                    ]);
                } else{
                    $homeSlider->update([
                        'title' => $request->title,
                        'caption' => $request->caption,
                        'link' => $request->link,
                    ]);
                }
            });

            return redirect('/admin/home-sliders')->with('status', 'Data Slider Berandas Berhasil Diubah');
        } catch (Exception $error) {
            return redirect()->back()->with('status', $error->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(HomeSlider $homeSlider)
    {
        try {
            DB::transaction(function() use($homeSlider) {
                $home_slider_image = $homeSlider->image;
                if(File::exists('storage/'. $home_slider_image)){
                    File::delete('storage/'. $home_slider_image);
                }

                $homeSlider->home_slider_images->delete();
                $homeSlider->delete();
            });

            return redirect('/admin/home-sliders')->with('status', 'Data Slider Beranda Berhasil Dihapus');
        } catch (Exception $error) {
            return redirect()->back()->with('status', $error->getMessage());
        }
    }
}
