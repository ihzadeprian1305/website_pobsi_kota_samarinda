<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ImageGallery;
use App\Models\ImageGalleryImage;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class ImageGalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (request()->ajax()) {
            $users = ImageGallery::query();
            return DataTables::of($users)
            ->addIndexColumn()
            ->addColumn('action', function($row){
                $showBtn = '<a href="/admin/image-galleries/'.$row->id.'" id="btn_show_image-galleries" class="show btn btn-info btn-sm me-1">Lihat</a>';
                $editBtn = '<a href="/admin/image-galleries/'.$row->id.'/edit" id="btn_update_image-galleries" class="edit btn btn-primary btn-sm me-1">Ubah</a>';
                $deleteBtn = '<form action="/admin/image-galleries/'.$row->id.'" method="POST">' .
                            '<input type="hidden" name="_method" value="DELETE">' .
                            csrf_field() .
                            '<button type="submit" class="delete btn btn-danger btn-sm">Hapus</button>' .
                            '</form>';
                return $showBtn . $editBtn . $deleteBtn;
            })
            ->rawColumns(['action'])
            ->make();
        }
        return view('admin.image_galleries.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.image_galleries.create');
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
                'title' => ['required'],
                'caption' => ['required'],
            ]);

            if($validator->fails()){
                return redirect()->back()->withErrors($validator)->withInput();
            }

            DB::transaction(function() use($request) {
                $image_gallery = ImageGallery::create([
                    'title' => $request->title,
                    'caption' => $request->caption,
                ]);

                $image_gallery_id = $image_gallery->id;

                foreach ($request->file('image') as $image) {
                    $originalName = $image->getClientOriginalName();

                    $uniqueName =  time() . '_' . $originalName;

                    $imagePath = $image->storeAs('image-gallery-images', $uniqueName);

                    ImageGalleryImage::create([
                        'image_gallery_id' => $image_gallery_id,
                        'image' => $imagePath,
                        'image_name' => $originalName,
                    ]);
                }
            });

            return redirect('/admin/image-galleries')->with('status', 'Data Galeri Foto Berhasil Ditambahkan');
        } catch (Exception $error) {
            return redirect()->back()->with('status', $error->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(ImageGallery $imageGallery)
    {
        try {
            return view('admin.image_galleries.show', ['imageGallery' => $imageGallery]);
        } catch (Exception $error) {
            return redirect()->back()->with('status', $error->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ImageGallery $imageGallery)
    {
        try {
            return view('admin.image_galleries.edit', ['imageGallery' => $imageGallery]);
        } catch (Exception $error) {
            return redirect()->back()->with('status', $error->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ImageGallery $imageGallery)
    {
        try {
            if(count($imageGallery->image_gallery_images) > 0){
                $validator = Validator::make($request->all(), [
                    'image' => ['array'],
                    'image.*' => ['file', 'mimes:jpeg,png,jpg', 'max:2048'],
                    'title' => ['required'],
                    'caption' => ['required'],
                ]);
            } else {
                $validator = Validator::make($request->all(), [
                    'image' => ['required', 'array'],
                    'image.*' => ['file', 'mimes:jpeg,png,jpg', 'max:2048'],
                    'title' => ['required'],
                    'caption' => ['required'],
                ]);
            }

            if($validator->fails()){
                return redirect()->back()->withErrors($validator)->withInput();
            }

            DB::transaction(function() use($request, $imageGallery) {
                if($request->image){
                    $imageGallery->update([
                        'title' => $request->title,
                        'caption' => $request->caption,
                    ]);

                    foreach ($request->file('image') as $image) {
                        $originalName = $image->getClientOriginalName();

                        $uniqueName =  time() . '_' . $originalName;

                        $imagePath = $image->storeAs('image-gallery-images', $uniqueName);

                        ImageGalleryImage::create([
                            'image_gallery_id' => $imageGallery->id,
                            'image' => $imagePath,
                            'image_name' => $originalName,
                        ]);
                    }
                } else{
                    $imageGallery->update([
                        'title' => $request->title,
                        'caption' => $request->caption,
                    ]);
                }
            });

            return redirect('/admin/image-galleries')->with('status', 'Data Galeri Foto Berhasil Diubah');
        } catch (Exception $error) {
            return redirect()->back()->with('status', $error->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ImageGallery $imageGallery)
    {
        try {
            DB::transaction(function() use($imageGallery) {
                $image_gallery_image = $imageGallery->image_gallery_images;
                foreach ($image_gallery_image as $igi) {
                    if(File::exists('storage/'. $igi->image)){
                        File::delete('storage/'. $igi->image);
                    }

                }

                $imageGallery->image_gallery_images()->delete();
                $imageGallery->delete();
            });

            return redirect('/admin/image-galleries')->with('status', 'Data Galeri Foto Berhasil Dihapus');
        } catch (Exception $error) {
            return redirect()->back()->with('status', $error->getMessage());
        }
    }

    public function destroyImage($id){
        $imageGalleryImage = ImageGalleryImage::where('id', $id)->firstOrFail();

        if(File::exists('storage/'. $imageGalleryImage->image)){
            File::delete('storage/'. $imageGalleryImage->image);
        }

        $imageGalleryImage->delete();

        return redirect()->back()->with('success', 'Data Foto Galeri Foto Berhasil Dihapus');
    }
}
