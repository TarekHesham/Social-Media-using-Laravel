<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;

Auth::routes();
Route::get('/', [HomeController::class, 'index'])->name('home');


Route::get("posts/trash", [PostController::class, "showDeletedPosts"])->name("posts.trash");
Route::post("posts/restore-all", [PostController::class, "restoreAll"])->name("posts.restoreAll");
Route::post("posts/{id}/restore", [PostController::class, "restore"])->name("posts.restore")->where("id", "[0-9]+");
Route::delete("posts/{id}/hard-destroy", [PostController::class, "hardDestroy"])->name("posts.hardDestroy")->where("id", "[0-9]+");

Route::resource("posts", PostController::class)->middleware("auth");
Route::resource("comments", CommentController::class)->middleware("auth");
