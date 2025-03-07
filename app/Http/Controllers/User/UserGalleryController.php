<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ImageGallery;
use App\Models\ImageGalleryImage;
use App\Models\VideoGallery;
use App\Models\VideoGalleryVideo;

class UserGalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('user.galleries');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function imageGallery()
    {
        $data['images'] = ImageGallery::paginate(20);

        return view('user.image_galleries', $data);
    }

    public function imageGalleryDetail(ImageGallery $imageGallery)
    {
        $data['image_gallery'] = $imageGallery;
        $data['image_gallery_images'] = ImageGalleryImage::with('image_galleries')->where('image_gallery_id', $imageGallery->id)->paginate(20);

        return view('user.image_gallery_details', $data);
    }

    public function videoGallery()
    {
        $data['videos'] = VideoGallery::with('video_gallery_videos')->paginate(20);

        return view('user.video_galleries', $data);
    }

    public function videoGalleryDetail(VideoGallery $videoGallery)
    {
        $data['video_gallery'] = $videoGallery;
        $data['video_gallery_videos'] = VideoGalleryVideo::with('video_galleries')->where('video_gallery_id', $videoGallery->id)->paginate(20);

        return view('user.video_gallery_details', $data);
    }
}
