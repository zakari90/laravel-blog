<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Category;
use App\Models\Post;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::withCount('posts')->get();
        $selectedCategoryId = $request->query('category_id');
        
        $posts = Post::with('category')
            ->latest()
            ->when($selectedCategoryId, function ($query, $selectedCategoryId) {
                return $query->where('category_id', $selectedCategoryId);
            })
            ->get();

        $selectedCategory = $selectedCategoryId ? Category::find($selectedCategoryId) : null;

        return view('posts.index', compact('posts', 'categories', 'selectedCategory'));
    }

    public function show(Post $post)
    {
        $categories = Category::withCount('posts')->get();
        return view('posts.show', compact('post', 'categories'));
    }
}
