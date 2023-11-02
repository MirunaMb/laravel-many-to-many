<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\Admin\PageController as AdminPageController;
use App\Http\Controllers\Guest\PageController as GuestPageController;

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

Route::get('/', [GuestPageController::class, 'index'])->name('guest.home');


Route::middleware(['auth', 'verified'])
  ->prefix('admin')
  ->name('admin.')
  ->group(function () {

    Route::get('/', [AdminPageController::class, 'index'])->name('home');

    Route::resource('projects', ProjectController::class);
    Route::delete('/projects/{project}/delete-image',[ProjectController::class, 'deleteImage'])->name('projects.delete-image');
    //5.che tipo di routa ? delete
    //6.deve portare alla cartella projects
    //7.quale project?serve l/id {project}
    //8.Chi gestisce la routa ?Il ProjectController
    //9.Con quale metodo? deleteImage che dovremmo creare nel controller
    //10.Il name deve corrispondere con quello messo nella action del form di edit
    Route::patch('/projects/{project}/publish', [ProjectController::class,'publish'])->name('projects.publish');
  });

require __DIR__ . '/auth.php';