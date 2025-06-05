<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Document;
use App\Models\DocumentCoverImage;
use App\Models\DocumentFile;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class DocumentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (request()->ajax()) {
            $users = Document::query();
            return DataTables::of($users)
            ->addIndexColumn()
            ->addColumn('action', function($row){
                $showBtn = '<a href="/admin/documents/'.$row->id.'" id="btn_show_documents" class="show btn btn-info btn-sm me-1">Lihat</a>';
                $editBtn = '<a href="/admin/documents/'.$row->id.'/edit" id="btn_show_users" class="edit btn btn-primary btn-sm me-1">Ubah</a>';
                $deleteBtn = '<form action="/admin/documents/'.$row->id.'" method="POST">' .
                            '<input type="hidden" name="_method" value="DELETE">' .
                            csrf_field() .
                            '<button type="submit" class="delete btn btn-danger btn-sm">Hapus</button>' .
                            '</form>';
                return $showBtn . $editBtn . $deleteBtn;
            })
            ->rawColumns(['action'])
            ->make();
        }
        return view('admin.documents.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.documents.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'cover_image' => ['file', 'mimes:jpeg,png,jpg', 'max:2048'],
                'file' => ['required', 'array'],
                'file.*' => ['file', 'mimes:jpeg,png,jpg,pdf,doc,docx,xlsx,xls,csv,ppt,pptx,mp3,mp4,mkv', 'max:131072'],
                'title' => ['required'],
                'slug' => ['required'],
                'description' => ['required'],
                'document_category_id' => ['required'],
            ]);

            if($validator->fails()){
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $dom = new \DomDocument();
            $dom->loadHtml($request->description, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
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
            $description_summary = Str::limit($summary, 160, '...');

            DB::transaction(function() use($request, $title_summary, $description_summary) {
                if($request->file('cover_image')){
                    $document = Document::create([
                        'title' => $request->title,
                        'title_summary' => $title_summary,
                        'slug' => $request->slug,
                        'description' => $request->description,
                        'description_summary' => $description_summary,
                        'document_category_id' => $request->document_category_id,
                        'is_announcement' => $request->is_announcement,
                        'is_active' => $request->is_active,
                        'posted_by' => auth()->user()->id,
                    ]);

                    $document_id = $document->id;

                    $originalCoverImageName = $request->file('cover_image')->getClientOriginalName();

                    $uniqueCoverImageName =  time() . '_' . $originalCoverImageName;

                    $imageCoverImagePath = $request->file('cover_image')->storeAs('document-cover-images', $uniqueCoverImageName);

                    DocumentCoverImage::create([
                        'image' => $imageCoverImagePath,
                        'image_name' => $originalCoverImageName,
                        'document_id' => $document_id
                    ]);

                    foreach ($request->file('file') as $file) {
                        $originalName = $file->getClientOriginalName();

                        $uniqueName =  time() . '_' . $originalName;

                        $filePath = $file->storeAs('document-files', $uniqueName);

                        DocumentFile::create([
                            'document_id' => $document_id,
                            'file' => $filePath,
                            'file_name' => $originalName,
                        ]);
                    }
                } else {
                    $document = Document::create([
                        'title' => $request->title,
                        'title_summary' => $title_summary,
                        'slug' => $request->slug,
                        'description' => $request->description,
                        'description_summary' => $description_summary,
                        'document_category_id' => $request->document_category_id,
                        'is_announcement' => $request->is_announcement,
                        'is_active' => $request->is_active,
                        'posted_by' => auth()->user()->id,
                    ]);

                    $document_id = $document->id;

                    foreach ($request->file('file') as $file) {
                        $originalName = $file->getClientOriginalName();

                        $uniqueName =  time() . '_' . $originalName;

                        $filePath = $file->storeAs('document-files', $uniqueName);

                        DocumentFile::create([
                            'document_id' => $document_id,
                            'file' => $filePath,
                            'file_name' => $originalName,
                        ]);
                    }
                }
            });

            return redirect('/admin/documents')->with('status', 'Data Dokumen Berhasil Ditambahkan');
        }
        catch (Exception $error) {
            return redirect()->back()->with('status', $error->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Document $document)
    {
        try {
            $document->load(['document_categories', 'user_posted_by']);

            return view('admin.documents.show', ['document' => $document]);
        } catch (Exception $error) {
            return redirect()->back()->with('status', $error->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Document $document)
    {
        try {
            return view('admin.documents.edit', ['document' => $document]);
        } catch (Exception $error) {
            return redirect()->back()->with('status', $error->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Document $document)
    {
        try {
            if(count($document->document_files) > 0){
                $validator = Validator::make($request->all(), [
                    'cover_image' => ['file', 'mimes:jpeg,png,jpg', 'max:2048'],
                    'file' => ['array'],
                    'file.*' => ['file', 'mimes:jpeg,png,jpg,pdf,doc,docx,xlsx,xls,csv,ppt,pptx,mp3,mp4,mkv', 'max:131072'],
                    'title' => ['required'],
                    'slug' => ['required'],
                    'description' => ['required'],
                    'document_category_id' => ['required'],
                ]);
            } else {
                $validator = Validator::make($request->all(), [
                    'cover_image' => ['file', 'mimes:jpeg,png,jpg', 'max:2048'],
                    'file' => ['required', 'array'],
                    'file.*' => ['file', 'mimes:jpeg,png,jpg,pdf,doc,docx,xlsx,xls,csv,ppt,pptx,mp3,mp4,mkv', 'max:131072'],
                    'title' => ['required'],
                    'slug' => ['required'],
                    'description' => ['required'],
                    'document_category_id' => ['required'],
                ]);

            }

            if($validator->fails()){
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $dom = new \DomDocument();
            $dom->loadHtml($request->description, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
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
            $description_summary = Str::limit($summary, 160, '...');

            DB::transaction(function() use($request, $document, $title_summary, $description_summary) {
                if(isset($document->document_cover_images->image)){
                    if($request->file('cover_image') && $request->file('file')){
                        $document_cover_image = $document->document_cover_images->image;
                        if(File::exists('storage/'. $document_cover_image)){
                            File::delete('storage/'. $document_cover_image);
                        }

                        $document->update([
                            'title' => $request->title,
                            'title_summary' => $title_summary,
                            'slug' => $request->slug,
                            'description' => $request->description,
                            'description_summary' => $description_summary,
                            'document_category_id' => $request->document_category_id,
                            'is_announcement' => $request->is_announcement,
                            'is_active' => $request->is_active,
                        ]);

                        $originalCoverImageName = $request->file('cover_image')->getClientOriginalName();

                        $uniqueCoverImageName =  time() . '_' . $originalCoverImageName;

                        $imageCoverImagePath = $request->file('cover_image')->storeAs('document-cover-images', $uniqueCoverImageName);

                        $document->document_cover_images->update([
                            'image' => $imageCoverImagePath,
                            'image_name' => $originalCoverImageName,
                        ]);

                        foreach ($request->file('file') as $file) {
                            $originalName = $file->getClientOriginalName();

                            $uniqueName =  time() . '_' . $originalName;

                            $filePath = $file->storeAs('document-files', $uniqueName);

                            DocumentFile::create([
                                'document_id' => $document->id,
                                'file' => $filePath,
                                'file_name' => $originalName,
                            ]);
                        }
                    }else if($request->file('cover_image')){
                        $document_cover_image = $document->document_cover_images->image;
                        if(File::exists('storage/'. $document_cover_image)){
                            File::delete('storage/'. $document_cover_image);
                        }

                        $document->update([
                            'title' => $request->title,
                            'title_summary' => $title_summary,
                            'slug' => $request->slug,
                            'description' => $request->description,
                            'description_summary' => $description_summary,
                            'document_category_id' => $request->document_category_id,
                            'is_announcement' => $request->is_announcement,
                            'is_active' => $request->is_active,
                        ]);

                        $originalCoverImageName = $request->file('cover_image')->getClientOriginalName();

                        $uniqueCoverImageName =  time() . '_' . $originalCoverImageName;

                        $imageCoverImagePath = $request->file('cover_image')->storeAs('document-cover-images', $uniqueCoverImageName);

                        $document->document_cover_images->update([
                            'image' => $imageCoverImagePath,
                            'image_name' => $originalCoverImageName,
                        ]);
                    }else if($request->file('file')){
                        $document->update([
                            'title' => $request->title,
                            'title_summary' => $title_summary,
                            'slug' => $request->slug,
                            'description' => $request->description,
                            'description_summary' => $description_summary,
                            'document_category_id' => $request->document_category_id,
                            'is_announcement' => $request->is_announcement,
                            'is_active' => $request->is_active,
                        ]);

                        foreach ($request->file('file') as $file) {
                            $originalName = $file->getClientOriginalName();

                            $uniqueName =  time() . '_' . $originalName;

                            $filePath = $file->storeAs('document-files', $uniqueName);

                            DocumentFile::create([
                                'document_id' => $document->id,
                                'file' => $filePath,
                                'file_name' => $originalName,
                            ]);
                        }
                    } else{
                        $document->update([
                            'title' => $request->title,
                            'title_summary' => $title_summary,
                            'slug' => $request->slug,
                            'description' => $request->description,
                            'description_summary' => $description_summary,
                            'document_category_id' => $request->document_category_id,
                            'is_announcement' => $request->is_announcement,
                            'is_active' => $request->is_active,
                        ]);
                    }
                } else {
                    if($request->file('cover_image') && $request->file('file')){
                        $document->update([
                            'title' => $request->title,
                            'title_summary' => $title_summary,
                            'slug' => $request->slug,
                            'description' => $request->description,
                            'description_summary' => $description_summary,
                            'document_category_id' => $request->document_category_id,
                            'is_announcement' => $request->is_announcement,
                            'is_active' => $request->is_active,
                        ]);

                        $originalCoverImageName = $request->file('cover_image')->getClientOriginalName();

                        $uniqueCoverImageName =  time() . '_' . $originalCoverImageName;

                        $imageCoverImagePath = $request->file('cover_image')->storeAs('document-cover-images', $uniqueCoverImageName);

                        DocumentCoverImage::create([
                            'image' => $imageCoverImagePath,
                            'image_name' => $originalCoverImageName,
                            'document_id' => $document->id
                        ]);

                        foreach ($request->file('file') as $file) {
                            $originalName = $file->getClientOriginalName();

                            $uniqueName =  time() . '_' . $originalName;

                            $filePath = $file->storeAs('document-files', $uniqueName);

                            DocumentFile::create([
                                'document_id' => $document->id,
                                'file' => $filePath,
                                'file_name' => $originalName,
                            ]);
                        }}else if($request->file('cover_image')){
                            $document->update([
                                'title' => $request->title,
                                'title_summary' => $title_summary,
                                'slug' => $request->slug,
                                'description' => $request->description,
                                'description_summary' => $description_summary,
                                'document_category_id' => $request->document_category_id,
                                'is_announcement' => $request->is_announcement,
                                'is_active' => $request->is_active,
                            ]);

                            $originalCoverImageName = $request->file('cover_image')->getClientOriginalName();

                            $uniqueCoverImageName =  time() . '_' . $originalCoverImageName;

                            $imageCoverImagePath = $request->file('cover_image')->storeAs('document-cover-images', $uniqueCoverImageName);

                            DocumentCoverImage::create([
                                'image' => $imageCoverImagePath,
                                'image_name' => $originalCoverImageName,
                                'document_id' => $document->id
                            ]);
                        }else if($request->file('file')){
                            $document->update([
                                'title' => $request->title,
                                'title_summary' => $title_summary,
                                'slug' => $request->slug,
                                'description' => $request->description,
                                'description_summary' => $description_summary,
                                'document_category_id' => $request->document_category_id,
                                'is_announcement' => $request->is_announcement,
                                'is_active' => $request->is_active,
                            ]);

                            foreach ($request->file('file') as $file) {
                                $originalName = $file->getClientOriginalName();

                                $uniqueName =  time() . '_' . $originalName;

                                $filePath = $file->storeAs('document-files', $uniqueName);

                                DocumentFile::create([
                                    'document_id' => $document->id,
                                    'file' => $filePath,
                                    'file_name' => $originalName,
                                ]);
                            }
                        } else{
                            $document->update([
                                'title' => $request->title,
                                'title_summary' => $title_summary,
                                'slug' => $request->slug,
                                'description' => $request->description,
                                'description_summary' => $description_summary,
                                'document_category_id' => $request->document_category_id,
                                'is_announcement' => $request->is_announcement,
                                'is_active' => $request->is_active,
                            ]);
                        }
                }
            });

            return redirect('/admin/documents')->with('status', 'Data Atlet Berhasil Diubah');
        } catch (Exception $error) {
            return redirect()->back()->with('status', $error->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Document $document)
    {
        try {
            DB::transaction(function() use($document) {
                $document_file = $document->document_files;
                foreach ($document_file as $df) {
                    if(File::exists('storage/'. $df->file)){
                        File::delete('storage/'. $df->file);
                    }

                    $document->document_files->delete();
                }

                $document->delete();
            });

            return redirect('/admin/documents')->with('status', 'Data Dokumen Berhasil Dihapus');
        } catch (Exception $error) {
            return redirect()->back()->with('status', $error->getMessage());
        }
    }

    public function destroyImage($id){
        $documentCoverImage = DocumentCoverImage::where('id', $id)->firstOrFail();

        if(File::exists('storage/'. $documentCoverImage->image)){
            File::delete('storage/'. $documentCoverImage->image);
        }

        $documentCoverImage->delete();

        return redirect()->back()->with('success', 'Data Sampul Berita Berhasil Dihapus');
    }

    public function destroyFile($id){
        $documentFile = DocumentFile::where('id', $id)->firstOrFail();

        if(File::exists('storage/'. $documentFile->file)){
            File::delete('storage/'. $documentFile->file);
        }

        $documentFile->document_files->delete();
        $documentFile->delete();

        return redirect()->back()->with('success', 'Data File Dokumen Berhasil Dihapus');
    }

    public function checkSlug(Request $request){
        $slug = SlugService::createSlug(Document::class, 'slug', $request->title);
        return response()->json(['slug' => $slug]);
    }
}
