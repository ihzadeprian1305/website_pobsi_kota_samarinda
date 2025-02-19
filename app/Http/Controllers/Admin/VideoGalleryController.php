<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\VideoGallery;
use App\Models\VideoGalleryVideo;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class VideoGalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (request()->ajax()) {
            $users = VideoGallery::query();
            return DataTables::of($users)
            ->addIndexColumn()
            ->addColumn('action', function($row){
                $showBtn = '<a href="/admin/video-galleries/'.$row->id.'" id="btn_show_video-galleries" class="show btn btn-info btn-sm me-1">Lihat</a>';
                $editBtn = '<a href="/admin/video-galleries/'.$row->id.'/edit" id="btn_update_video-galleries" class="edit btn btn-primary btn-sm me-1">Ubah</a>';
                $deleteBtn = '<form action="/admin/video-galleries/'.$row->id.'" method="POST">' .
                            '<input type="hidden" name="_method" value="DELETE">' .
                            csrf_field() .
                            '<button type="submit" class="delete btn btn-danger btn-sm">Hapus</button>' .
                            '</form>';
                return $showBtn . $editBtn . $deleteBtn;
            })
            ->rawColumns(['action'])
            ->make();
        }
        return view('admin.video_galleries.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.video_galleries.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'video' => ['required', 'array'],
                'video.*' => ['file', 'mimes:mp4,mkv', 'max:131072'],
                'title' => ['required'],
                'caption' => ['required'],
            ]);

            if($validator->fails()){
                return redirect()->back()->withErrors($validator)->withInput();
            }

            DB::transaction(function() use($request) {
                $video_gallery = VideoGallery::create([
                    'title' => $request->title,
                    'caption' => $request->caption,
                ]);

                $video_gallery_id = $video_gallery->id;

                foreach ($request->file('video') as $video) {
                    $originalName = $video->getClientOriginalName();

                    $uniqueName =  time() . '_' . $originalName;

                    $videoPath = $video->storeAs('video-gallery-videos', $uniqueName);

                    VideoGalleryVideo::create([
                        'video_gallery_id' => $video_gallery_id,
                        'video' => $videoPath,
                        'video_name' => $originalName,
                    ]);
                }
            });

            return redirect('/admin/video-galleries')->with('status', 'Data Galeri Video Berhasil Ditambahkan');
        } catch (Exception $error) {
            return redirect()->back()->with('status', $error->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(VideoGallery $videoGallery)
    {
        try {
            return view('admin.video_galleries.show', ['videoGallery' => $videoGallery]);
        } catch (Exception $error) {
            return redirect()->back()->with('status', $error->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(VideoGallery $videoGallery)
    {
        try {
            return view('admin.video_galleries.edit', ['videoGallery' => $videoGallery]);
        } catch (Exception $error) {
            return redirect()->back()->with('status', $error->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, VideoGallery $videoGallery)
    {
        try {
            if(count($videoGallery->video_gallery_videos) > 0){
                $validator = Validator::make($request->all(), [
                    'video' => ['array'],
                    'video.*' => ['file', 'mimes:mp4,mkv', 'max:131072'],
                    'title' => ['required'],
                    'caption' => ['required'],
                ]);
            } else {
                $validator = Validator::make($request->all(), [
                    'video' => ['required', 'array'],
                    'video.*' => ['file', 'mimes:mp4,mkv', 'max:131072'],
                    'title' => ['required'],
                    'caption' => ['required'],
                ]);
            }

            if($validator->fails()){
                return redirect()->back()->withErrors($validator)->withInput();
            }

            DB::transaction(function() use($request, $videoGallery) {
                if($request->video){
                    $videoGallery->update([
                        'title' => $request->title,
                        'caption' => $request->caption,
                    ]);

                    foreach ($request->file('video') as $video) {
                        $originalName = $video->getClientOriginalName();

                        $uniqueName =  time() . '_' . $originalName;

                        $videoPath = $video->storeAs('video-gallery-videos', $uniqueName);

                        VideoGalleryVideo::create([
                            'video_gallery_id' => $videoGallery->id,
                            'video' => $videoPath,
                            'video_name' => $originalName,
                        ]);
                    }
                } else{
                    $videoGallery->update([
                        'title' => $request->title,
                        'caption' => $request->caption,
                    ]);
                }
            });

            return redirect('/admin/video-galleries')->with('status', 'Data Galeri Video Berhasil Diubah');
        } catch (Exception $error) {
            return redirect()->back()->with('status', $error->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(VideoGallery $videoGallery)
    {
        try {
            DB::transaction(function() use($videoGallery) {
                $video_gallery_video = $videoGallery->video_gallery_videos;
                foreach ($video_gallery_video as $vgv) {
                    if(File::exists('storage/'. $vgv->video)){
                        File::delete('storage/'. $vgv->video);
                    }

                }

                $videoGallery->video_gallery_videos()->delete();
                $videoGallery->delete();
            });

            return redirect('/admin/video-galleries')->with('status', 'Data Galeri Video Berhasil Dihapus');
        } catch (Exception $error) {
            return redirect()->back()->with('status', $error->getMessage());
        }
    }

    public function destroyVideo($id){
        $videoGalleryVideo = VideoGalleryVideo::where('id', $id)->firstOrFail();

        if(File::exists('storage/'. $videoGalleryVideo->video)){
            File::delete('storage/'. $videoGalleryVideo->video);
        }

        $videoGalleryVideo->video_gallery_videos->delete();
        $videoGalleryVideo->delete();

        return redirect()->back()->with('success', 'Data Foto Galeri Foto Berhasil Dihapus');
    }
}
