<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NewsTag;
use App\Http\Requests\StoreNewsTagRequest;
use App\Http\Requests\UpdateNewsTagRequest;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class NewsTagController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (request()->ajax()) {
            $users = NewsTag::query();
            return DataTables::of($users)
            ->addIndexColumn()
            ->addColumn('action', function($row){
                $editBtn = '<a href="/admin/news-tags/'.$row->id.'/edit" id="btn_show_users" class="edit btn btn-primary btn-sm me-1">Ubah</a>';
                $deleteBtn = '<form action="/admin/news-tags/'.$row->id.'" method="POST">' .
                            '<input type="hidden" name="_method" value="DELETE">' .
                            csrf_field() .
                            '<button type="submit" class="delete btn btn-danger btn-sm">Hapus</button>' .
                            '</form>';
                return $editBtn . $deleteBtn;
            })
            ->rawColumns(['action'])
            ->make();
        }
        return view('admin.news_tags.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.news_tags.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => ['required'],
            ]);

            if($validator->fails()){
                return redirect()->back()->withErrors($validator)->withInput();
            }

            DB::transaction(function() use($request) {
                NewsTag::create([
                    'name' => $request->name,
                ]);
            });

            return redirect('/admin/news-tags')->with('status', 'Data Kategori Berita Berhasil Ditambahkan');
        }
        catch (Exception $error) {
            return redirect()->back()->with('status', $error->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(NewsTag $newsTag)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(NewsTag $newsTag)
    {
        try {
            return view('admin.news_tags.edit', ['news_tag' => $newsTag]);
        } catch (Exception $error) {
            return redirect()->back()->with('status', $error->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, NewsTag $newsTag)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => ['required'],
            ]);

            if($validator->fails()){
                return redirect()->back()->withErrors($validator)->withInput();
            }

            DB::transaction(function() use($request, $newsTag) {
                $newsTag->update([
                    'name' => $request->name,
                ]);
            });

            return redirect('/admin/news-tags')->with('status', 'Data Kategori Berita Berhasil Diubah');
        } catch (Exception $error) {
            return redirect()->back()->with('status', $error->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(NewsTag $newsTag)
    {
        try {
            DB::transaction(function() use($newsTag) {
                $newsTag->delete();
            });

            return redirect('/admin/news-tags')->with('status', 'Data Tag Berita Berhasil Dihapus');
        } catch (Exception $error) {
            return redirect()->back()->with('status', $error->getMessage());
        }
    }
}
