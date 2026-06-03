@extends('layouts.app')

@section('title', $post->title)

@section('content')
    <div class="space-y-6">
        <!-- Back Link -->
        <a href="{{ route('posts.index') }}" class="inline-flex items-center gap-1 text-sm font-semibold text-slate-500 hover:text-indigo-600 transition-colors">
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            <span>Back to all posts</span>
        </a>

        <!-- Post Detail Card -->
        <article class="p-8 rounded-2xl bg-white border border-slate-200/60 shadow-[0_2px_8px_-3px_rgba(0,0,0,0.05)]">
            <!-- Category and Date -->
            <div class="flex items-center gap-3 text-xs font-semibold mb-4">
                @if($post->category)
                    <a href="{{ route('posts.index', ['category_id' => $post->category->id]) }}" 
                       class="px-2.5 py-0.5 rounded-full bg-indigo-50 text-indigo-700 hover:bg-indigo-100 transition duration-150">
                        {{ $post->category->name }}
                    </a>
                @else
                    <span class="px-2.5 py-0.5 rounded-full bg-slate-100 text-slate-500">Uncategorized</span>
                @endif
                <span class="text-slate-300">•</span>
                <span class="text-slate-400 font-medium">{{ $post->created_at->format('F d, Y') }}</span>
                <span class="text-slate-300">•</span>
                <span class="text-slate-400 font-medium inline-flex items-center gap-1">
                    <svg class="h-3.5 w-3.5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                    </svg>
                    <span>{{ $post->views_count }} views</span>
                </span>
            </div>

            <!-- Title -->
            <h1 class="font-display font-extrabold text-3xl md:text-4xl text-slate-800 tracking-tight leading-tight mb-6">
                {{ $post->title }}
            </h1>

            <!-- Excerpt/Intro (Styled box) -->
            <div class="border-l-4 border-indigo-500 bg-slate-50 p-4 rounded-r-xl mb-8">
                <p class="text-slate-600 italic text-sm md:text-base leading-relaxed">
                    {{ $post->excerpt }}
                </p>
            </div>

            <!-- Body Content -->
            <div class="text-slate-600 space-y-6 text-base md:text-lg leading-relaxed font-normal">
                @foreach(explode("\n\n", $post->body) as $paragraph)
                    @if(trim($paragraph))
                        <p>{!! nl2br(e($paragraph)) !!}</p>
                    @endif
                @endforeach
            </div>

            <!-- Like / Dislike voting section -->
            <div class="border-t border-slate-100 pt-6 mt-8 flex items-center justify-between">
                <span class="text-sm font-semibold text-slate-500">Was this article helpful?</span>
                <div class="flex items-center gap-3">
                    <!-- Like Form -->
                    <form action="{{ route('posts.like', $post) }}" method="POST">
                        @csrf
                        <input type="hidden" name="type" value="like">
                        <button type="submit" 
                                class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-bold border transition @auth {{ $userReaction && $userReaction->is_like === true ? 'bg-indigo-50 border-indigo-200 text-indigo-700 hover:bg-indigo-100' : 'bg-white border-slate-200 text-slate-600 hover:bg-slate-50' }} @else bg-white border-slate-200 text-slate-600 hover:bg-slate-50 @endauth">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M14 9V5a3 3 0 00-3-3l-4 9v11h11.28a2 2 0 002-1.7l1.38-9a2 2 0 00-2-2.3zM7 22H4a2 2 0 01-2-2v-7a2 2 0 012-2h3"/>
                            </svg>
                            <span>Helpful ({{ $post->likes_count }})</span>
                        </button>
                    </form>

                    <!-- Dislike Form -->
                    <form action="{{ route('posts.like', $post) }}" method="POST">
                        @csrf
                        <input type="hidden" name="type" value="dislike">
                        <button type="submit" 
                                class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-bold border transition @auth {{ $userReaction && $userReaction->is_like === false ? 'bg-rose-50 border-rose-200 text-rose-700 hover:bg-rose-100' : 'bg-white border-slate-200 text-slate-600 hover:bg-slate-50' }} @else bg-white border-slate-200 text-slate-600 hover:bg-slate-50 @endauth">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M10 15v4a3 3 0 003 3l4-9V2H5.72a2 2 0 00-2 1.7l-1.38 9a2 2 0 002 2.3zm7-13h3a2 2 0 012 2v7a2 2 0 01-2 2h-3"/>
                            </svg>
                            <span>Not Helpful ({{ $post->dislikes_count }})</span>
                        </button>
                    </form>
                </div>
            </div>
        </article>

        <!-- Newsletter Subscription Widget -->
        <div class="p-8 rounded-2xl bg-gradient-to-br from-indigo-600 to-indigo-700 text-white shadow-[0_4px_16px_-4px_rgba(79,70,229,0.2)]">
            <h3 class="font-display font-bold text-xl mb-2">Subscribe to our newsletter</h3>
            <p class="text-indigo-100 text-sm leading-relaxed mb-4 max-w-md">Get the latest articles sent directly to your inbox. No spam, unsubscribe at any time.</p>
            <form class="flex flex-col sm:flex-row gap-2" onsubmit="event.preventDefault(); alert('Subscribed!');">
                <input type="email" placeholder="Enter your email" required
                       class="flex-grow px-4 py-2.5 rounded-lg text-slate-800 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-300">
                <button type="submit" 
                        class="px-5 py-2.5 bg-white text-indigo-700 font-semibold text-sm rounded-lg hover:bg-indigo-50 transition-colors shadow-sm">
                    Subscribe
                </button>
            </form>
        </div>
    </div>
@endsection
