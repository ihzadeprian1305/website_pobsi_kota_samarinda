<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Document;
use App\Models\DocumentCategory;
use App\Models\DocumentView;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserDocumentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                    'search' => ['string'],
            ]);

            if($validator->fails()){
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $document_categories = DocumentCategory::withCount('documents')->latest()->filter(request(['search']))->paginate(10);

            $data['document_categories'] = $document_categories;

            return view('user.documents', $data);
        } catch (Exception $error) {
            dd($error);
        }
    }
    // public function index()
    // {
    //     try {
    //         if(request('category')){
    //             $data['title_category'] = DocumentCategory::firstWhere('id', request('category'));
    //         }

    //         if(request('author')){
    //             $data['title_author'] = User::firstWhere('id', request('author'));
    //         }

    //         $document = Document::with(['user_posted_by'])->latest()->filter(request(['search', 'category', 'author']))->paginate(1);

    //         $data['documents'] = $document;
    //         $data['document_categories'] = DocumentCategory::withCount('documents')->orderBy('documents_count', 'desc')->limit(5)->get();

    //         return view('user.documents', $data);
    //     } catch (Exception $error) {
    //         dd($error);
    //     }
    // }

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
    public function show(DocumentCategory $documentCategory, Document $document)
    {
        try {
            $ipAddress = request()->ip();
            $today = Carbon::today();

            $alreadyViewedToday = DocumentView::where('document_id', $document->id)
                ->where('ip_address', $ipAddress)
                ->whereDate('viewed_at', $today)
                ->exists();

            if (!$alreadyViewedToday) {
                DocumentView::create([
                    'document_id' => $document->id,
                    'ip_address' => $ipAddress,
                    'viewed_at' => now(),
                ]);
            }

            $data['document'] = $document;
            $data['document_category'] = $documentCategory;
            $data['document_categories'] = DocumentCategory::withCount('documents')->orderBy('documents_count', 'desc')->limit(5)->get();
            $data['all_announcement_documents'] = Document::with(['document_cover_images', 'document_files', 'document_categories', 'user_posted_by'])
                                                    ->latest()
                                                    ->where('is_announcement', 1)->take(5)->get();

            return view('user.document_category_details', $data);
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

    public function documentCategoryDetail(DocumentCategory $documentCategory)
    {
        try {
            $data['documents'] = Document::with(['document_cover_images', 'document_files', 'document_categories', 'user_posted_by'])
                                            ->latest()
                                            ->filter(request(['search']))
                                            ->where('document_category_id', $documentCategory->id)->paginate(20);
            $data['document_category'] = $documentCategory;
            $data['document_categories'] = DocumentCategory::withCount('documents')->orderBy('documents_count', 'desc')->limit(5)->get();

            return view('user.document_details', $data);
        } catch (Exception $error) {
            dd($error);
        }
    }

    public function documentAuthorsDetail(User $user)
    {
        try {
            $data['user'] = $user;
            $data['document'] = $user->document_posted_by;

            return view('user.document_authors_detail', $data);
        } catch (Exception $error) {
            dd($error);
        }
    }
}
