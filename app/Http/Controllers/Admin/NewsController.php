<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\News;
use App\Http\Requests\StoreNewsRequest;
use App\Http\Requests\UpdateNewsRequest;
use App\Models\NewsCoverImage;
use App\Models\NewsImage;
use App\Models\NewsNewsTag;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (request()->ajax()) {
            $users = News::query();
            return DataTables::of($users)
            ->addIndexColumn()
            ->addColumn('action', function($row){
                $showBtn = '<a href="/admin/news/'.$row->id.'" id="btn_show_news" class="show btn btn-info btn-sm me-1">Lihat</a>';
                $editBtn = '<a href="/admin/news/'.$row->id.'/edit" id="btn_update_news" class="edit btn btn-primary btn-sm me-1">Ubah</a>';
                $deleteBtn = '<form action="/admin/news/'.$row->id.'" method="POST">' .
                            '<input type="hidden" name="_method" value="DELETE">' .
                            csrf_field() .
                            '<button type="submit" class="delete btn btn-danger btn-sm">Hapus</button>' .
                            '</form>';
                return $showBtn . $editBtn . $deleteBtn;
            })
            ->rawColumns(['action'])
            ->make();
        }
        return view('admin.news.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.news.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'cover_image' => ['required', 'file', 'mimes:jpeg,png,jpg', 'max:2048'],
                'title' => ['required'],
                'slug' => ['required'],
                'content' => ['required'],
                'news_category_id' => ['required', 'not_in:null'],
                'news_tag_id' => ['required', 'array', 'not_in:null'],
                'created_by' => ['required', 'not_in:null'],
                'is_active' => ['required', 'not_in:null'],
                'image' => ['array'],
                'image.*' => ['image', 'mimes:jpeg,png,jpg', 'max:2048'],
            ]);

            if($validator->fails()){
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $dom = new \DomDocument();
            $dom->loadHtml($request->content, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
            $text = $dom->getElementsByTagName('p');

            if ($text->length > 0) {
                $summary = $text->item(0)->nodeValue;
            } else {
                return response()->json([
                    'status' => 406,
                    'success' => false,
                    'message' => 'Ringkasan Kosong Karena Isi Berita Kosong',
                ], 406);
            }

            $title_summary = Str::limit($request->title, 64, '...');
            $excerpt = Str::limit($summary, 200, '...');

            DB::transaction(function() use($request, $title_summary, $excerpt) {
                $news = News::create([
                    'title' => $request->title,
                    'title_summary' => $title_summary,
                    'slug' => $request->slug,
                    'content' => $request->content,
                    'excerpt' => $excerpt,
                    'news_category_id' => $request->news_category_id,
                    'created_by' => $request->created_by,
                    'posted_by' => auth()->user()->id,
                    'is_active' => $request->is_active,
                ]);

                $news_id = $news->id;

                $originalCoverImageName = $request->file('cover_image')->getClientOriginalName();

                $uniqueCoverImageName =  time() . '_' . $originalCoverImageName;

                $imageCoverImagePath = $request->file('cover_image')->storeAs('news-cover-images', $uniqueCoverImageName);

                NewsCoverImage::create([
                    'image' => $imageCoverImagePath,
                    'image_name' => $originalCoverImageName,
                    'news_id' => $news_id
                ]);

                if($request->file('image')){
                    foreach ($request->file('image') as $image) {
                        $originalImageName = $image->getClientOriginalName();

                        $uniqueImageName =  time() . '_' . $originalImageName;

                        $imageImagePath = $image->storeAs('news-images', $uniqueImageName);

                        NewsImage::create([
                            'image' => $imageImagePath,
                            'image_name' => $originalImageName,
                            'news_id' => $news_id
                        ]);
                    }
                }

                $news->news_tags()->attach($request->news_tag_id);
            });

            return redirect('/admin/news')->with('status', 'Berita Berhasil Ditambahkan');
        } catch (Exception $error) {
            return redirect()->back()->with('status', $error->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(News $news)
    {
        try {
            $news->load(['news_categories', 'user_created_by', 'user_posted_by']);

            return view('admin.news.show', ['news' => $news]);
        } catch (Exception $error) {
            return redirect()->back()->with('status', $error->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(News $news)
    {
        // dd($news->news_tags->pluck('id')->toArray());
        try {
            return view('admin.news.edit', ['news' => $news]);
        } catch (Exception $error) {
            return redirect()->back()->with('status', $error->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, News $news)
    {
        try {
            $validator = Validator::make($request->all(), [
                'cover_image' => ['file', 'mimes:jpeg,png,jpg', 'max:2048'],
                'title' => ['required'],
                'slug' => ['required'],
                'content' => ['required'],
                'news_category_id' => ['required', 'not_in:null'],
                'news_tag_id' => ['required', 'array', 'not_in:null'],
                'created_by' => ['required', 'not_in:null'],
                'is_active' => ['required', 'not_in:null'],
                'image' => ['array'],
                'image.*' => ['file', 'mimes:jpeg,png,jpg', 'max:2048'],
            ]);

            if($validator->fails()){
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $dom = new \DomDocument();
            $dom->loadHtml($request->content, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
            $text = $dom->getElementsByTagName('p');

            if ($text->length > 0) {
                $summary = $text->item(0)->nodeValue;
            } else {
                return response()->json([
                    'status' => 406,
                    'success' => false,
                    'message' => 'Ringkasan Kosong Karena Isi Berita Kosong',
                ], 406);
            }

            $title_summary = Str::limit($request->title, 64, '...');
            $excerpt = Str::limit($summary, 200, '...');

            DB::transaction(function() use($request, $news, $title_summary, $excerpt) {
                if($request->file('cover_image') && $request->file('image')){
                    $news_cover_image = $news->news_cover_images->image;
                    if(File::exists('storage/'. $news_cover_image)){
                        File::delete('storage/'. $news_cover_image);
                    }

                    $news->update([
                        'title' => $request->title,
                        'title_summary' => $title_summary,
                        'slug' => $request->slug,
                        'content' => $request->content,
                        'excerpt' => $excerpt,
                        'news_category_id' => $request->news_category_id,
                        'created_by' => $request->created_by,
                        'is_active' => $request->is_active,
                    ]);

                    $news->news_tags()->sync($request->news_tag_id);

                    $originalCoverImageName = $request->file('cover_image')->getClientOriginalName();

                    $uniqueCoverImageName =  time() . '_' . $originalCoverImageName;

                    $imageCoverImagePath = $request->file('cover_image')->storeAs('news-cover-images', $uniqueCoverImageName);

                    $news->news_cover_images->update([
                        'image' => $imageCoverImagePath,
                        'image_name' => $originalCoverImageName,
                    ]);

                    foreach ($request->file('image') as $image) {
                        $originalImageName = $image->getClientOriginalName();

                        $uniqueImageName =  time() . '_' . $originalImageName;

                        $imageImagePath = $image->storeAs('news-images', $uniqueImageName);

                        NewsImage::create([
                            'news_id' => $news->id,
                            'image' => $imageImagePath,
                            'image_name' => $originalImageName,
                        ]);
                    }
                } else if ($request->file('cover_image')) {
                    $news_cover_image = $news->news_cover_images->image;
                    if(File::exists('storage/'. $news_cover_image)){
                        File::delete('storage/'. $news_cover_image);
                    }

                    $news->update([
                        'title' => $request->title,
                        'title_summary' => $title_summary,
                        'slug' => $request->slug,
                        'content' => $request->content,
                        'excerpt' => $excerpt,
                        'news_category_id' => $request->news_category_id,
                        'created_by' => $request->created_by,
                        'is_active' => $request->is_active,
                    ]);

                    $news->news_tags()->sync($request->news_tag_id);

                    $originalCoverImageName = $request->file('cover_image')->getClientOriginalName();

                    $uniqueCoverImageName =  time() . '_' . $originalCoverImageName;

                    $imageCoverImagePath = $request->file('cover_image')->storeAs('news-cover-images', $uniqueCoverImageName);

                    $news->news_cover_images->update([
                        'image' => $imageCoverImagePath,
                        'image_name' => $originalCoverImageName,
                    ]);
                } else if ($request->file('image')){
                    $news->update([
                        'title' => $request->title,
                        'title_summary' => $title_summary,
                        'slug' => $request->slug,
                        'content' => $request->content,
                        'excerpt' => $excerpt,
                        'news_category_id' => $request->news_category_id,
                        'created_by' => $request->created_by,
                        'is_active' => $request->is_active,
                    ]);

                    $news->news_tags()->sync($request->news_tag_id);

                    foreach ($request->file('image') as $image) {
                        $originalImageName = $image->getClientOriginalName();

                        $uniqueImageName =  time() . '_' . $originalImageName;

                        $imageImagePath = $image->storeAs('news-images', $uniqueImageName);

                        NewsImage::create([
                            'news_id' => $news->id,
                            'image' => $imageImagePath,
                            'image_name' => $originalImageName,
                        ]);
                    }
                } else {
                    $news->update([
                        'tile' => $request->tile,
                        'title_summary' => $title_summary,
                        'slug' => $request->slug,
                        'content' => $request->content,
                        'excerpt' => $excerpt,
                        'news_category_id' => $request->news_category_id,
                        'created_by' => $request->created_by,
                        'is_active' => $request->is_active,
                    ]);

                    $news->news_tags()->sync($request->news_tag_id);
                }
            });

            return redirect('/admin/news')->with('status', 'Data Berita Berhasil Diubah');
        } catch (Exception $error) {
            return redirect()->back()->with('status', $error->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(News $news)
    {
        try {
            DB::transaction(function() use($news) {
                $news_cover_image = $news->news_cover_images;
                if(File::exists('storage/'. $news_cover_image)){
                    File::delete('storage/'. $news_cover_image);
                }

                if($news->news_images){
                    $news_image = $news->news_images;
                    foreach ($news_image as $ni) {
                        if(File::exists('storage/'. $ni->image)){
                            File::delete('storage/'. $ni->image);
                        }

                    }
                }

                $news->news_cover_images->delete();
                $news->news_images()->delete();
                $news->news_tags()->detach();
                $news->delete();
            });

            return redirect('/admin/news')->with('status', 'Berita Berhasil Dihapus');
        } catch (Exception $error) {
            return redirect()->back()->with('status', $error->getMessage());
        }
    }

    public function checkSlug(Request $request){
        $slug = SlugService::createSlug(News::class, 'slug', $request->title);
        return response()->json(['slug' => $slug]);
    }

    public function destroyImage($id){
        $newsImage = NewsImage::where('id', $id)->firstOrFail();

        if(File::exists('storage/'. $newsImage->image)){
            File::delete('storage/'. $newsImage->image);
        }

        $newsImage->delete();

        return redirect()->back()->with('success', 'Data Foto Berita Berhasil Dihapus');
    }

    // public function store(Request $request)
    // {
    //     try {
    //         $validator = Validator::make($request->all(), [
    //             'news_image' => ['required', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
    //             'title' => ['required'],
    //             'slug' => ['required'],
    //             'content' => ['required'],
    //             'news_category_id' => ['required', 'not_in:null'],
    //             'news_tag_id' => ['required', 'not_in:null'],
    //             'created_by' => ['required', 'not_in:null'],
    //             'is_active' => ['required', 'not_in:null'],
    //         ]);

    //         if($validator->fails()){
    //             return redirect()->back()->withErrors($validator)->withInput();
    //         }

    //         $dom = new \DomDocument();
    //         $dom->loadHtml($request->content, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
    //         $text = $dom->getElementsByTagName('p');
    //         $image_file = $dom->getElementsByTagName('img');

    //         if (!File::exists(public_path('news-images'))) {
    //             File::makeDirectory(public_path('news-images'));
    //         }

    //         if ($text->length > 0) {
    //             $summary = $text->item(0)->nodeValue;
    //         } else {
    //             return response()->json([
    //                 'status' => 406,
    //                 'success' => false,
    //                 'message' => 'Ringkasan Kosong Karena Isi Berita Kosong',
    //             ], 406);
    //         }

    //         foreach($image_file as $key => $image) {
    //             $data = $image->getAttribute('src');

    //             list($type, $data) = explode(';', $data);
    //             list(, $data) = explode(',', $data);

    //             $img_data = base64_decode($data);
    //             $image_name = "/news/" . time().$key.'.png';
    //             $path = public_path() . $image_name;
    //             file_put_contents($path, $img_data);

    //             $image->removeAttribute('src');
    //             $image->setAttribute('src', $image_name);
    //             // $image->setAttribute('data-fslightbox', '');
    //         }

    //         $content = $dom->saveHTML();
    //         $excerpt = Str::limit($summary, 200, '...');

    //         DB::transaction(function() use($request, $content, $excerpt) {
    //             $news = News::create([
    //                 'news_image' => $request->file('news_image')->store('news-image'),
    //                 'title' => $request->title,
    //                 'slug' => $request->slug,
    //                 'content' => $content,
    //                 'excerpt' => $excerpt,
    //                 'news_category_id' => $request->news_category_id,
    //                 'created_by' => $request->created_by,
    //                 'posted_by' => auth()->user()->id,
    //                 'is_active' => $request->is_active,
    //             ]);

    //             $news->news_tags()->attach($request->news_tag_id);
    //         });

    //         return redirect('/admin/news')->with('status', 'Berita Berhasil Ditambahkan');
    //     } catch (Exception $error) {
    //         return redirect()->back()->with('status', $error->getMessage());
    //     }
    // }
}
