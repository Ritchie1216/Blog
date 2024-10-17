<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;

// 首页视图
Route::get('/', function () {
    return view('layouts.app');
});

// 显示创建文章表单
Route::get('/posts/create', [PostController::class, 'create'])->name('posts.create');

// 存储新文章
Route::post('/posts', [PostController::class, 'store'])->name('posts.store');

// 显示所有文章
Route::get('/posts', [PostController::class, 'index'])->name('posts.index');

// 显示编辑文章表单
Route::get('/posts/{post}/edit', [PostController::class, 'edit'])->name('posts.edit');

// 更新文章
Route::put('/posts/{post}', [PostController::class, 'update'])->name('posts.update');

// 删除文章
Route::delete('/posts/{post}', [PostController::class, 'destroy'])->name('posts.destroy');

Route::get('/posts/{post}', [PostController::class, 'show'])->name('posts.show');
