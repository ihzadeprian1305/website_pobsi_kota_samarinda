<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\News;
use App\Models\NewsCategory;
use App\Models\NewsTag;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;

class UserNewsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            if(request('category')){
                $data['title_category'] = NewsCategory::firstWhere('id', request('category'));
            }

            if(request('tag')){
                $data['title_tag'] = NewsTag::firstWhere('id', request('tag'));
            }

            if(request('author')){
                $data['title_author'] = User::firstWhere('id', request('author'));
            }

            $news = News::with(['user_created_by'])->whereHas('news_categories', function ($query) {
                $query->where('name', 'Berita');
            })->latest()->filter(request(['search', 'category', 'tag', 'author']))->paginate(1);

            $data['news'] = $news;
            $data['news_categories'] = NewsCategory::withCount('news')->orderBy('news_count', 'desc')->limit(5)->get();
            $data['news_tags'] = NewsTag::withCount('news')->orderBy('news_count', 'desc')->limit(5)->get();

            return view('user.news', $data);
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
    public function show(News $news)
    {
        try {
            $data['news'] = $news;
            $data['all_news'] = News::take(3)->latest()->get();
            $data['news_categories'] = NewsCategory::withCount('news')->orderBy('news_count', 'desc')->limit(5)->get();
            $data['news_tags'] = NewsTag::withCount('news')->orderBy('news_count', 'desc')->limit(5)->get();

            return view('user.news_details', $data);
        } catch (Exception $error) {
            dd($error);
        }
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

    public function newsCategories()
    {
        try {
            $data['news_categories'] = NewsCategory::withCount('news')->orderBy('news_count', 'desc')->filter(request(['search']))->paginate(10);

            return view('user.news_categories', $data);
        } catch (Exception $error) {
            dd($error);
        }
    }

    public function newsCategoriesDetail(NewsCategory $newsCategory)
    {
        try {
            $data['news_category'] = $newsCategory;
            $data['news'] = $newsCategory->news;

            return view('user.news_categories_detail', $data);
        } catch (Exception $error) {
            dd($error);
        }
    }

    public function newsTags()
    {
        try {
            $data['news_tags'] = NewsTag::withCount('news')->orderBy('news_count', 'desc')->filter(request(['search']))->paginate(10);

            return view('user.news_tags', $data);
        } catch (Exception $error) {
            dd($error);
        }
    }

    public function newsTagsDetail(NewsTag $newsTag)
    {
        try {
            $data['news_tag'] = $newsTag;
            $data['news'] = $newsTag->news;

            return view('user.news_tags_detail', $data);
        } catch (Exception $error) {
            dd($error);
        }
    }

    public function newsAuthorsDetail(User $user)
    {
        try {
            $data['user'] = $user;
            $data['news'] = $user->news_created_by;

            return view('user.news_authors_detail', $data);
        } catch (Exception $error) {
            dd($error);
        }
    }
}
