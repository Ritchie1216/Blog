<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Image;
use Illuminate\Http\Request;

class PostController extends Controller
{
    // 显示创建文章的表单
    public function create()
    {
        return view('posts.create'); // 返回用于创建文章的视图
    }

    // 存储文章和图片
    public function store(Request $request)
    {
        // 验证输入
        $request->validate([
            'title' => 'required',
            'content' => 'required',
            'image.*' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
    
        // 创建新文章
        $post = Post::create([
            'title' => $request->title,
            'content' => $request->content,
        ]);
    
        // 存储上传的图片
        if ($request->hasFile('image')) {
            foreach ($request->file('image') as $image) {
                // 将图片存储在 public/images 目录
                $path = $image->move(public_path('images'), $image->getClientOriginalName());
                
                Image::create([
                    'post_id' => $post->id, // 关联文章ID
                    'image' => 'images/' . $image->getClientOriginalName(), // 存储相对路径
                ]);
                
                // 输出路径以供调试
                \Log::info('Uploaded image path: ' . $path);
            }
        }
    
        return redirect()->route('posts.index')->with('success', 'Post created successfully!'); // 重定向到文章列表页面
    }

    // 显示文章列表
    public function index()
    {
        $posts = Post::with('images')->get(); // 获取所有文章和相关的图片
        return view('posts.index', compact('posts')); // 返回文章列表视图
    }

    public function edit(Post $post)
    {
        return view('posts.edit', compact('post')); // 返回编辑视图
    }

    public function update(Request $request, Post $post)
    {
        // 验证输入
        $request->validate([
            'title' => 'required',
            'content' => 'required',
            'image.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048', // 可选的新图片
        ]);

        // 更新文章的标题和内容
        $post->update([
            'title' => $request->title,
            'content' => $request->content,
        ]);

        // 如果有新图片上传，删除旧图片并保存新图片
        if ($request->hasFile('image')) {
            // 删除旧图片
            foreach ($post->images as $image) {
                // 删除存储的图片文件
                if (file_exists(public_path($image->image))) {
                    unlink(public_path($image->image));
                }
                // 删除数据库中的记录
                $image->delete();
            }

            // 保存新图片
            foreach ($request->file('image') as $newImage) {
                // 将新图片存储在 public/images 目录
                $path = $newImage->move(public_path('images'), $newImage->getClientOriginalName());
                Image::create([
                    'post_id' => $post->id, // 关联文章ID
                    'image' => 'images/' . $newImage->getClientOriginalName(), // 存储相对路径
                ]);
            }
        }

        return redirect()->route('posts.index')->with('success', 'Post updated successfully!');
    }

    public function destroy(Post $post)
    {
        // 删除文章及其相关图片
        $post->images()->delete(); // 删除相关图片
        $post->delete(); // 删除文章

        return redirect()->route('posts.index')->with('success', 'Post deleted successfully!'); // 重定向到文章列表页面
    }

    public function show(Post $post)
    {
        \Log::info('Post retrieved: ', [$post->toArray()]); // 记录到日志中
        return view('posts.show', compact('post'));
    }
    

    
}
