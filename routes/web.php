<?php

use App\Http\Controllers\CommentController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;




Route::get("posts/trash", [PostController::class, "showDeletedPosts"])
  ->name("posts.trash");

Route::post("posts/restore-all", [PostController::class, "restoreAll"])
  ->name("posts.restoreAll");

Route::post("posts/{id}/restore", [PostController::class, "restore"])
  ->name("posts.restore")->where("id", "[0-9]+");

Route::delete("posts/{id}/hard-destroy", [PostController::class, "hardDestroy"])
  ->name("posts.hardDestroy")->where("id", "[0-9]+");

Route::resource("posts", PostController::class);
Route::resource("comments", CommentController::class);

// Route::get("/", [PostController::class, "index"])->name("posts.index");
// Route::get("/post/{id}", [PostController::class, "show"])->name("posts.show")->where("id", "[0-9]+");
// Route::get("/post/{id}/edit", [PostController::class, "edit"])->name("posts.edit")->where("id", "[0-9]+");
// Route::get("/post/create", [PostController::class, "create"])->name("posts.create");

// Route::delete("/post/{id}/delete", [PostController::class, "destroy"])->name("posts.delete");
// Route::post("/post/store", [PostController::class, "store"])->name("posts.store");
// Route::put("/post/update", [PostController::class, "update"])->name("posts.update");
