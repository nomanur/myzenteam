<?php

use App\Http\Controllers\AdminController;
use App\Models\Link;
use App\Models\Pdf;
use App\Models\Snippet;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    $pdf = Pdf::all();
    $snippets = Snippet::all();
    $links = Link::all();

    return view('welcome', compact('pdf', 'snippets', 'links'));
});

Route::get('/admin', [AdminController::class, 'index']);
