<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Agenda;
use App\Models\Document;
use App\Models\HomeSlider;
use App\Models\News;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;

class UserHomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $data['home_sliders'] = HomeSlider::with('home_slider_images')->limit(3)->get();
            $data['news'] = News::with(['news_categories'])->whereHas('news_categories', function ($query) {
                $query->where('name', 'Berita');
            })->orderBy('created_at', 'desc')->limit(3)->get();
            $data['documents'] = Document::with(['document_categories', 'document_files', 'user_posted_by'])->limit(3)->get();
            $data['agendas'] = Agenda::where('date', Carbon::now()->format('Y-m-d'))->get();

            return view('user.index', $data);
        } catch (Exception $error) {
            dd($error);
        }
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
}
