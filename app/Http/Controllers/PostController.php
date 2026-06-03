<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Category;
use App\Models\Post;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::withCount('posts')->get();
        $selectedCategoryId = $request->query('category_id');
        
        $posts = Post::with(['category', 'user'])
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

    // Dashboard management listing
    public function dashboard()
    {
        $categories = Category::withCount('posts')->get();
        
        // Admins can see all posts, authors see only their own
        if (auth()->user()->isAdmin()) {
            $posts = Post::with(['category', 'user'])->latest()->get();
        } else {
            $posts = Post::with(['category', 'user'])
                ->where('user_id', auth()->id())
                ->latest()
                ->get();
        }

        return view('dashboard.posts.index', compact('posts', 'categories'));
    }

    // Show create form
    public function create()
    {
        Gate::authorize('create', Post::class);

        $categories = Category::all();
        return view('dashboard.posts.create', compact('categories'));
    }

    // Store new post
    public function store(Request $request)
    {
        Gate::authorize('create', Post::class);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'excerpt' => 'required|string',
            'body' => 'required|string',
        ]);

        // Generate unique slug
        $slug = Str::slug($validated['title']);
        $originalSlug = $slug;
        $count = 1;
        while (Post::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $count++;
        }

        Post::create([
            'user_id' => auth()->id(),
            'category_id' => $validated['category_id'],
            'title' => $validated['title'],
            'slug' => $slug,
            'excerpt' => $validated['excerpt'],
            'body' => $validated['body'],
        ]);

        return redirect()->route('dashboard.posts.index')->with('success', 'Post created successfully!');
    }

    // Show edit form
    public function edit(Post $post)
    {
        Gate::authorize('update', $post);

        $categories = Category::all();
        return view('dashboard.posts.edit', compact('post', 'categories'));
    }

    // Update post
    public function update(Request $request, Post $post)
    {
        Gate::authorize('update', $post);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'excerpt' => 'required|string',
            'body' => 'required|string',
        ]);

        // Generate unique slug ignoring current post
        $slug = Str::slug($validated['title']);
        $originalSlug = $slug;
        $count = 1;
        while (Post::where('slug', $slug)->where('id', '!=', $post->id)->exists()) {
            $slug = $originalSlug . '-' . $count++;
        }

        $post->update([
            'category_id' => $validated['category_id'],
            'title' => $validated['title'],
            'slug' => $slug,
            'excerpt' => $validated['excerpt'],
            'body' => $validated['body'],
        ]);

        return redirect()->route('dashboard.posts.index')->with('success', 'Post updated successfully!');
    }

    // Delete post
    public function destroy(Post $post)
    {
        Gate::authorize('delete', $post);

        $post->delete();

        return redirect()->route('dashboard.posts.index')->with('success', 'Post deleted successfully!');
    }
}
