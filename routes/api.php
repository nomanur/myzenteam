<?php

use App\Http\Controllers\Api\Admin\LinkController;
use App\Http\Controllers\Api\Admin\PdfController;
use App\Http\Controllers\Api\Admin\SnippetController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::get('/getpdf', [PdfController::class, 'index']);
Route::get('/getpdf/download/{id}', [PdfController::class, 'pdfdownload']);
Route::get('/getpdf/{id}', [PdfController::class, 'show']);
Route::post('/getpdf/{id}/update', [PdfController::class, 'update']);
Route::post('/pdfupload', [PdfController::class, 'store']);
Route::delete('/pdf/{id}/delete', [PdfController::class, 'delete']);

//snippet
Route::get('/snippet', [SnippetController::class, 'index']);
Route::get('/snippet/{id}', [SnippetController::class, 'show']);
Route::post('/snippet/{id}/update', [SnippetController::class, 'update']);
Route::post('/snippet/create', [SnippetController::class, 'store']);
Route::delete('/snippet/{id}/delete', [SnippetController::class, 'delete']);

//link
Route::get('/link', [LinkController::class, 'index']);
Route::get('/link/{id}', [LinkController::class, 'show']);
Route::post('/link/{id}/update', [LinkController::class, 'update']);
Route::post('/link/create', [LinkController::class, 'store']);
Route::delete('/link/{id}/delete', [LinkController::class, 'delete']);
