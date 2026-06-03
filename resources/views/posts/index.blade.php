@extends('layouts.app')

@section('title', $selectedCategory ? $selectedCategory->name . ' Posts' : 'Latest Articles')

@section('content')
    <div class="space-y-8">
        <!-- Section Header -->
        <div class="border-b border-slate-100 pb-5">
            @if($selectedCategory)
                <div class="flex items-center gap-2 text-xs font-semibold text-indigo-600 uppercase tracking-wider mb-1">
                    <span>Filtering by category</span>
                    <span class="inline-block w-1.5 h-1.5 rounded-full bg-indigo-500"></span>
                </div>
                <h1 class="font-display font-extrabold text-3xl text-slate-800 tracking-tight">
                    {{ $selectedCategory->name }}
                </h1>
                <p class="text-sm text-slate-400 mt-1">Showing all posts filed under the {{ strtolower($selectedCategory->name) }} topic.</p>
            @else
                <h1 class="font-display font-extrabold text-3xl text-slate-800 tracking-tight">
                    Latest Articles
                </h1>
                <p class="text-sm text-slate-400 mt-1">Explore our latest stories, tutorials, and insights.</p>
            @endif
        </div>

        <!-- Posts List -->
        @if($posts->isEmpty())
            <div class="text-center py-16 px-4 bg-white border border-slate-200/60 rounded-2xl">
                <svg class="mx-auto h-12 w-12 text-slate-300 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z" />
                </svg>
                <h3 class="font-display font-bold text-slate-700 text-lg">No posts found</h3>
                <p class="text-slate-400 text-sm mt-1 max-w-sm mx-auto">There are currently no blog articles in this category. Check back later or browse other topics!</p>
                <a href="{{ route('posts.index') }}" class="inline-flex items-center gap-2 mt-5 px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold rounded-lg transition-colors shadow-sm">
                    Back to All Posts
                </a>
            </div>
        @else
            <div class="space-y-6">
                @foreach($posts as $post)
                    <article class="p-6 rounded-2xl bg-white border border-slate-200/60 hover:border-indigo-100 hover:shadow-[0_4px_16px_-4px_rgba(79,70,229,0.06)] hover:-translate-y-[2px] transition duration-200 flex flex-col justify-between group">
                        <div>
                            <!-- Post Meta info -->
                            <div class="flex items-center gap-3 text-xs mb-3 font-semibold">
                                @if($post->category)
                                    <a href="{{ route('posts.index', ['category_id' => $post->category->id]) }}" 
                                       class="px-2.5 py-0.5 rounded-full bg-indigo-50 text-indigo-700 hover:bg-indigo-100 transition duration-150">
                                        {{ $post->category->name }}
                                    </a>
                                @else
                                    <span class="px-2.5 py-0.5 rounded-full bg-slate-100 text-slate-500">Uncategorized</span>
                                @endif
                                <span class="text-slate-300">•</span>
                                <span class="text-slate-400 font-medium">{{ $post->created_at->format('M d, Y') }}</span>
                            </div>

                            <!-- Post Title -->
                            <h2 class="font-display font-bold text-xl text-slate-800 group-hover:text-indigo-600 transition-colors tracking-tight mb-2">
                                <a href="{{ route('posts.show', $post) }}">{{ $post->title }}</a>
                            </h2>

                            <!-- Post Excerpt -->
                            <p class="text-slate-500 text-sm leading-relaxed mb-4">
                                {{ $post->excerpt }}
                            </p>
                        </div>

                        <!-- Read More link -->
                        <div class="border-t border-slate-100 pt-4 flex items-center justify-between">
                            <span class="text-xs text-slate-400 font-medium">Read time: ~3 mins</span>
                            <a href="{{ route('posts.show', $post) }}" class="inline-flex items-center gap-1 text-sm font-semibold text-indigo-600 hover:text-indigo-800 transition-colors">
                                <span>Read full article</span>
                                <svg class="h-4 w-4 transform group-hover:translate-x-0.5 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                                </svg>
                            </a>
                        </div>
                    </article>
                @endforeach
            </div>
        @endif
    </div>
@endsection
