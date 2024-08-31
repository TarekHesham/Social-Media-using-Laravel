<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use App\Models\User;

Auth::routes();
Route::get('/', [HomeController::class, 'index'])->name('home');


Route::get("posts/trash", [PostController::class, "showDeletedPosts"])->name("posts.trash");
Route::post("posts/restore-all", [PostController::class, "restoreAll"])->name("posts.restoreAll");
Route::post("posts/{id}/restore", [PostController::class, "restore"])->name("posts.restore")->where("id", "[0-9]+");
Route::delete("posts/{id}/hard-destroy", [PostController::class, "hardDestroy"])->name("posts.hardDestroy")->where("id", "[0-9]+");

Route::resource("posts", PostController::class)->middleware("auth");
Route::resource("comments", CommentController::class)->middleware("auth");

// Login with GitHub
use Laravel\Socialite\Facades\Socialite;

Route::get('/auth/redirect', function () {
  return Socialite::driver('github')->redirect();
})->name('github-login');

Route::get('/auth/callback/github', function () {
  $user = Socialite::driver('github')->stateless()->user();

  $user = User::updateOrCreate([
    'github_id' => $user->id,
  ], [
    'name' => $user->name,
    'email' => $user->email,
    'image' => $user->avatar,
    'password' => $user->token,
    'github_token' => $user->token,
    'github_refresh_token' => $user->refreshToken,
  ]);

  Auth::login($user);

  return redirect('/');
});
