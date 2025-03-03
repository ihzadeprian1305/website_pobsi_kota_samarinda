<?php

use App\Http\Controllers\Admin\AuthenticationController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\GetValueController;
use App\Http\Controllers\Admin\NewsCategoryController;
use App\Http\Controllers\Admin\NewsController;
use App\Http\Controllers\Admin\NewsTagController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\AgendaController;
use App\Http\Controllers\Admin\AthleteController;
use App\Http\Controllers\Admin\DocumentCategoryController;
use App\Http\Controllers\Admin\DocumentController;
use App\Http\Controllers\Admin\HomeSliderController;
use App\Http\Controllers\Admin\ImageGalleryController;
use App\Http\Controllers\Admin\PoolHouseController;
use App\Http\Controllers\Admin\StandingController;
use App\Http\Controllers\Admin\StructureController;
use App\Http\Controllers\Admin\VideoGalleryController;
use App\Http\Controllers\User\UserAthleteInformationController;
use App\Http\Controllers\User\UserDocumentController;
use App\Http\Controllers\User\UserHomeController;
use App\Http\Controllers\User\UserNewsController;
use App\Http\Controllers\User\UserPoolHouseController;
use App\Http\Controllers\User\UserStructureController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/', [UserHomeController::class, 'index']);
Route::get('/structures', [UserStructureController::class, 'index']);
// Route::get('/structures/member-field-structures/{structure_field}', [UserStructureController::class, 'memberFieldStructures']);
Route::get('/structures/field-structures/{structure_field:name}', [UserStructureController::class, 'memberFieldStructures']);
Route::get('/news', [UserNewsController::class, 'index']);
Route::get('/news/news-categories', [UserNewsController::class, 'newsCategories']);
// Route::get('/news/news-categories/{news_category}', [UserNewsController::class, 'newsCategoriesDetail']);
Route::get('/news/news-tags', [UserNewsController::class, 'newsTags']);
Route::get('/news/news-details/{news:slug}', [UserNewsController::class, 'show']);
// Route::get('/news/news-tags/{news_tag}', [UserNewsController::class, 'newsTagsDetail']);
// Route::get('/news/news-authors/{user}', [UserNewsController::class, 'newsAuthorsDetail']);
Route::get('/documents', [UserDocumentController::class, 'index']);
Route::get('/documents/{document_category:name}', [UserDocumentController::class, 'documentCategoryDetail']);
Route::get('/documents/{document_category:name}/{document:slug}', [UserDocumentController::class, 'show']);
// Route::get('/documents/document-categories', [UserDocumentController::class, 'documentCategories']);
// Route::get('/documents/document-categories/{document_category}', [UserDocumentController::class, 'documentCategoriesDetail']);
// Route::get('/documents/document-authors/{user}', [UserDocumentController::class, 'documentAuthorsDetail']);
Route::get('/athlete-informations', [UserAthleteInformationController::class, 'index']);
Route::get('/pool-houses', [UserPoolHouseController::class, 'index']);
Route::get('/pool-houses/{pool_house:name}', [UserPoolHouseController::class, 'show']);
Route::get('/athlete-informations/athletes', [UserAthleteInformationController::class, 'athlete']);
Route::get('/athlete-informations/athletes/{athlete:name}', [UserAthleteInformationController::class, 'athleteDetail']);

Route::get('/123', function () {
    return view('user.news_details');
});

// Admin // Login
Route::get('/admin/login', [AuthenticationController::class, 'login'])->name('admin.login');
Route::post('/admin/login/check-login', [AuthenticationController::class, 'checkLogin']);

// Admin // Logout
Route::post('/admin/logout', [AuthenticationController::class, 'logout']);

// Auth Middleware
Route::middleware('auth')->group(function(){

    // Admin // Get Values
    Route::get('/admin/get-values/get-news-category-dropdown-values', [GetValueController::class, 'getNewsCategoriesDropdownValues']);
    Route::get('/admin/get-values/get-news-tag-dropdown-values', [GetValueController::class, 'getNewsTagsDropdownValues']);
    Route::get('/admin/get-values/get-news-user-created-by-dropdown-values', [GetValueController::class, 'getNewsUserCreatedByDropdownValues']);
    Route::get('/admin/get-values/get-user-level-dropdown-values', [GetValueController::class, 'getUserLevelDropdownValues']);
    Route::get('/admin/get-values/get-athlete-dropdown-values', [GetValueController::class, 'getAthletesDropdownValues']);
    Route::get('/admin/get-values/get-handicap-dropdown-values', [GetValueController::class, 'getHandicapsDropdownValues']);
    Route::get('/admin/get-values/get-document-category-dropdown-values', [GetValueController::class, 'getDocumentCategoriesDropdownValues']);
    Route::get('/admin/get-values/get-structure-position-dropdown-values', [GetValueController::class, 'getStructurePositionsDropdownValues']);
    Route::get('/admin/get-values/get-pool-house-dropdown-values', [GetValueController::class, 'getPoolHousesDropdownValues']);

    // Admin // Dashboard
    Route::get('/admin/dashboard', [DashboardController::class, 'index']);

    // Admin // Berita
    Route::get('/admin/news/check-slug', [NewsController::class, 'checkSlug']);
    Route::delete('/admin/news/{id}/delete-image', [NewsController::class, 'destroyImage']);
    Route::resource('/admin/news', NewsController::class);

    // Admin // Dokumen
    Route::get('/admin/documents/check-slug', [DocumentController::class, 'checkSlug']);
    Route::delete('/admin/documents/{id}/delete-image', [DocumentController::class, 'destroyImage']);
    Route::delete('/admin/documents/{id}/delete-file', [DocumentController::class, 'destroyFile']);
    Route::resource('/admin/documents', DocumentController::class);

    // Admin // Agenda
    Route::resource('/admin/agendas', AgendaController::class);

    // Admin //Info Atlet // Atlet
    Route::resource('/admin/athletes', AthleteController::class);

    // Admin // Struktur
    Route::resource('/admin/structures', StructureController::class);

    // Admin //Info Atlet // Klasemen
    Route::resource('/admin/standings', StandingController::class);

    // Admin //Info Atlet // Klasemen
    Route::delete('/admin/pool-houses/{id}/delete-image', [PoolHouseController::class, 'destroyImage']);
    Route::resource('/admin/pool-houses', PoolHouseController::class);

    // Admin //Galeri // Galeri Foto
    Route::delete('/admin/image-galleries/{id}/delete-image', [ImageGalleryController::class, 'destroyImage']);
    Route::resource('/admin/image-galleries', ImageGalleryController::class);

    // Admin //Galeri // Galeri Video
    Route::delete('/admin/video-galleries/{id}/delete-video', [VideoGalleryController::class, 'destroyVideo']);
    Route::resource('/admin/video-galleries', VideoGalleryController::class);

    // Admin // Data Master // Slider Beranda
    Route::resource('/admin/home-sliders', HomeSliderController::class);

    // Admin // Data Master // Kategori Berita
    Route::resource('/admin/news-categories', NewsCategoryController::class);

    // Admin // Data Master // Tag Berita
    Route::resource('/admin/news-tags', NewsTagController::class);

    // Admin // Data Master // Kategori Dokumen
    Route::resource('/admin/document-categories', DocumentCategoryController::class);

    // Admin // Pengguna
    Route::delete('/admin/users/{id}/delete-image', [UserController::class, 'destroyImage']);
    Route::resource('/admin/users', UserController::class);
});

