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

Route::get('/auth/redirect/github', function () {
  return Socialite::driver('github')->redirect();
})->name('github-login');

Route::get('/auth/callback/github', function () {
  $githubUser = Socialite::driver('github')->user();
  $user = User::where('email', $githubUser->email)->first();

  if (!$user) {
    $user = User::updateOrCreate([
      'github_id' => $githubUser->id,
    ], [
      'name' => $githubUser->name,
      'email' => $githubUser->email,
      'image' => $githubUser->avatar,
      'password' => $githubUser->token,
      'github_token' => $githubUser->token,
      'github_refresh_token' => $githubUser->refreshToken,
      'github_expires_at' => $githubUser->expiresIn,
    ]);
  }

  Auth::login($user);

  return redirect('/');
});

// Login with Google
Route::get('/auth/redirect/google', function () {
  return Socialite::driver('google')->redirect();
})->name('google-login');

Route::get('/auth/callback/google', function () {
  $googleUser = Socialite::driver('google')->user();
  $user = User::where('email', $googleUser->email)->first();

  if (!$user) {
    $user = User::updateOrCreate([
      'google_id' => $googleUser->id,
    ], [
      'name' => $googleUser->name,
      'email' => $googleUser->email,
      'image' => $googleUser->avatar,
      'password' => $googleUser->token,
      'google_token' => $googleUser->token,
      'google_refresh_token' => $googleUser->refreshToken,
      'google_token_expires_in' => $googleUser->expiresIn,
    ]);
  }

  Auth::login($user);

  return redirect('/');
});
