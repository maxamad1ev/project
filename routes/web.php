<?php

use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\NotificationController;
use Illuminate\Support\Facades\Route;

Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('register', [RegisterController::class, 'register']);
Route::get('login', [RegisterController::class, 'showLoginForm'])->name('login');
Route::post('login', [RegisterController::class, 'login']);
Route::post('logout', [RegisterController::class, 'logout'])->name('logout');

Route::get('email/verify', [RegisterController::class, 'showVerificationNotice'])->name('verification.notice');
Route::get('email/verify/{id}/{hash}', [RegisterController::class, 'verify'])->name('verification.verify');
Route::post('email/resend', [RegisterController::class, 'resendVerificationEmail'])->name('verification.resend');

Route::get('/', [PostController::class, 'index'])->name('home');

Route::middleware('auth')->group(function () {
    Route::resource('posts', PostController::class)->except(['index', 'show']);
    Route::get('posts/followed', [PostController::class, 'followedPosts'])->name('posts.followed');

    Route::get('profiles/{user:username}', [ProfileController::class, 'show'])->name('profiles.show');
    Route::get('profiles/{user:username}/edit', [ProfileController::class, 'edit'])->name('profiles.edit');
    Route::put('profiles/{user:username}', [ProfileController::class, 'update'])->name('profiles.update');
    Route::post('profiles/{user:username}/follow', [ProfileController::class, 'follow'])->name('profiles.follow');
    Route::delete('profiles/{user:username}/unfollow', [ProfileController::class, 'unfollow'])->name('profiles.unfollow');

    Route::get('notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('notifications/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');

    Route::post('posts/{post}/comments', [CommentController::class, 'store'])->name('comments.store');
    Route::delete('comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');
});

Route::get('posts', [PostController::class, 'index'])->name('posts.index');
Route::get('posts/{post}', [PostController::class, 'show'])->name('posts.show');
Route::get('profiles/{user:username}', [ProfileController::class, 'show'])->name('profiles.show');

