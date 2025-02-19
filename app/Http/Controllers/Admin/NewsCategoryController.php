<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NewsCategory;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class NewsCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (request()->ajax()) {
            $users = NewsCategory::query();
            return DataTables::of($users)
            ->addIndexColumn()
            ->addColumn('action', function($row){
                $editBtn = '<a href="/admin/news-categories/'.$row->id.'/edit" id="btn_show_users" class="edit btn btn-primary btn-sm me-1">Ubah</a>';
                $deleteBtn = '<form action="/admin/news-categories/'.$row->id.'" method="POST">' .
                            '<input type="hidden" name="_method" value="DELETE">' .
                            csrf_field() .
                            '<button type="submit" class="delete btn btn-danger btn-sm">Hapus</button>' .
                            '</form>';
                return $editBtn . $deleteBtn;
            })
            ->rawColumns(['action'])
            ->make();
        }
        return view('admin.news_categories.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.news_categories.create');
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
                NewsCategory::create([
                    'name' => $request->name,
                ]);
            });

            return redirect('/admin/news-categories')->with('status', 'Data Kategori Berita Berhasil Ditambahkan');
        }
        catch (Exception $error) {
            return redirect()->back()->with('status', $error->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(NewsCategory $newsCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(NewsCategory $newsCategory)
    {
        try {
            return view('admin.news_categories.edit', ['news_category' => $newsCategory]);
        } catch (Exception $error) {
            return redirect()->back()->with('status', $error->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, NewsCategory $newsCategory)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => ['required'],
            ]);

            if($validator->fails()){
                return redirect()->back()->withErrors($validator)->withInput();
            }

            DB::transaction(function() use($request, $newsCategory) {
                $newsCategory->update([
                    'name' => $request->name,
                ]);
            });

            return redirect('/admin/news-categories')->with('status', 'Data Kategori Berita Berhasil Diubah');
        } catch (Exception $error) {
            return redirect()->back()->with('status', $error->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(NewsCategory $newsCategory)
    {
        try {
            DB::transaction(function() use($newsCategory) {
                $newsCategory->delete();
            });

            return redirect('/admin/news-categories')->with('status', 'Data Kategori Berita Berhasil Dihapus');
        } catch (Exception $error) {
            return redirect()->back()->with('status', $error->getMessage());
        }
    }
}
