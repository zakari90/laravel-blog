@extends('layouts.app')

@section('title', 'Create New Post - Dashboard')

@section('content')
    <div class="space-y-6">
        <!-- Back Link -->
        <a href="{{ route('dashboard.posts.index') }}" class="inline-flex items-center gap-1 text-sm font-semibold text-slate-500 hover:text-indigo-600 transition-colors">
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            <span>Back to manage posts</span>
        </a>

        <!-- Form Card -->
        <div class="p-8 rounded-2xl bg-white border border-slate-200/60 shadow-[0_2px_8px_-3px_rgba(0,0,0,0.05)]">
            <div class="border-b border-slate-100 pb-4 mb-6">
                <h1 class="font-display font-extrabold text-2xl text-slate-800 tracking-tight">
                    Create New Post
                </h1>
                <p class="text-xs text-slate-400 mt-1">Publish a new article to the blog website.</p>
            </div>

            <!-- Form -->
            <form action="{{ route('dashboard.posts.store') }}" method="POST" class="space-y-6">
                @csrf

                <!-- Title -->
                <div>
                    <label for="title" class="block text-sm font-bold text-slate-700 mb-1.5">Post Title</label>
                    <input type="text" name="title" id="title" value="{{ old('title') }}" required placeholder="e.g. Exploring Modern PHP Features"
                           class="w-full px-4 py-2.5 rounded-lg border border-slate-200/80 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500/30 text-sm focus:outline-none transition @error('title') border-red-300 @enderror">
                    @error('title')
                        <p class="text-red-500 text-xs mt-1.5 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Category Selection -->
                <div>
                    <label for="category_id" class="block text-sm font-bold text-slate-700 mb-1.5">Category</label>
                    <select name="category_id" id="category_id" required
                            class="w-full px-4 py-2.5 rounded-lg border border-slate-200/80 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500/30 text-sm focus:outline-none bg-white transition @error('category_id') border-red-300 @enderror">
                        <option value="" disabled selected>Select a category</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <p class="text-red-500 text-xs mt-1.5 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Excerpt -->
                <div>
                    <label for="excerpt" class="block text-sm font-bold text-slate-700 mb-1.5">Excerpt</label>
                    <textarea name="excerpt" id="excerpt" rows="2" required placeholder="A brief summary of the article to show on listings..."
                              class="w-full px-4 py-2.5 rounded-lg border border-slate-200/80 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500/30 text-sm focus:outline-none transition @error('excerpt') border-red-300 @enderror">{{ old('excerpt') }}</textarea>
                    @error('excerpt')
                        <p class="text-red-500 text-xs mt-1.5 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Body -->
                <div>
                    <label for="body" class="block text-sm font-bold text-slate-700 mb-1.5">Body Content</label>
                    <textarea name="body" id="body" rows="10" required placeholder="Write the main content of your blog post here. Use double newlines to separate paragraphs..."
                              class="w-full px-4 py-2.5 rounded-lg border border-slate-200/80 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500/30 text-sm focus:outline-none font-mono text-slate-700 transition @error('body') border-red-300 @enderror">{{ old('body') }}</textarea>
                    @error('body')
                        <p class="text-red-500 text-xs mt-1.5 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Submit buttons -->
                <div class="border-t border-slate-100 pt-5 flex items-center justify-end gap-3">
                    <a href="{{ route('dashboard.posts.index') }}" class="px-4 py-2.5 rounded-lg border border-slate-200 hover:bg-slate-50 text-slate-700 text-sm font-semibold transition-colors">
                        Cancel
                    </a>
                    <button type="submit" class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-lg transition-colors shadow-sm">
                        Publish Post
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
