@extends('layouts.app')

@section('title', 'Manage Posts - Dashboard')

@section('content')
    <div class="space-y-6">
        <!-- Dashboard Header -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between border-b border-slate-100 pb-5 gap-4">
            <div>
                <h1 class="font-display font-extrabold text-3xl text-slate-800 tracking-tight">
                    Manage Posts
                </h1>
                <p class="text-sm text-slate-400 mt-1">
                    @if(auth()->user()->isAdmin())
                        You are logged in as <span class="font-semibold text-slate-600">Admin</span>. Viewing all posts.
                    @else
                        You are logged in as <span class="font-semibold text-slate-600">Author</span>. Viewing your posts.
                    @endif
                </p>
            </div>
            <div>
                <a href="{{ route('dashboard.posts.create') }}" class="inline-flex items-center justify-center px-4 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-lg transition-colors shadow-sm gap-2">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                    </svg>
                    <span>Create New Post</span>
                </a>
            </div>
        </div>

        <!-- Success Alert -->
        @if(session('success'))
            <div class="p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm font-medium flex items-center gap-2">
                <svg class="h-5 w-5 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        <!-- Posts Table -->
        <div class="bg-white border border-slate-200/60 rounded-2xl shadow-[0_2px_8px_-3px_rgba(0,0,0,0.05)] overflow-hidden">
            @if($posts->isEmpty())
                <div class="text-center py-12 px-4">
                    <svg class="mx-auto h-12 w-12 text-slate-300 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                    </svg>
                    <h3 class="font-display font-bold text-slate-700 text-lg">No posts yet</h3>
                    <p class="text-slate-400 text-sm mt-1">Get started by creating your first blog article.</p>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-100 text-left text-sm">
                        <thead class="bg-slate-50 font-display font-semibold text-slate-700">
                            <tr>
                                <th scope="col" class="px-6 py-3.5">Title</th>
                                <th scope="col" class="px-6 py-3.5">Category</th>
                                <th scope="col" class="px-6 py-3.5">Author</th>
                                <th scope="col" class="px-6 py-3.5">Date Created</th>
                                <th scope="col" class="px-6 py-3.5 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-slate-600 font-medium">
                            @foreach($posts as $post)
                                <tr class="hover:bg-slate-50/50 transition-colors">
                                    <td class="px-6 py-4 max-w-xs truncate">
                                        <a href="{{ route('posts.show', $post) }}" class="text-slate-800 hover:text-indigo-600 font-bold transition-colors">
                                            {{ $post->title }}
                                        </a>
                                    </td>
                                    <td class="px-6 py-4">
                                        @if($post->category)
                                            <span class="inline-flex px-2 py-0.5 rounded-full bg-slate-100 text-slate-700 text-xs font-semibold">
                                                {{ $post->category->name }}
                                            </span>
                                        @else
                                            <span class="text-slate-400 text-xs">Uncategorized</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="text-slate-500 text-xs">{{ $post->user->name ?? 'System' }}</span>
                                    </td>
                                    <td class="px-6 py-4 text-slate-400 text-xs">
                                        {{ $post->created_at->format('M d, Y') }}
                                    </td>
                                    <td class="px-6 py-4 text-right space-x-2 whitespace-nowrap">
                                        <!-- Edit button (Authorized check) -->
                                        @can('update', $post)
                                            <a href="{{ route('dashboard.posts.edit', $post) }}" class="inline-flex items-center text-xs font-bold text-indigo-600 hover:text-indigo-900 border border-indigo-100 bg-indigo-50/30 hover:bg-indigo-50 px-2 py-1 rounded transition duration-150">
                                                Edit
                                            </a>
                                        @endcan

                                        <!-- Delete button (Authorized check) -->
                                        @can('delete', $post)
                                            <form action="{{ route('dashboard.posts.destroy', $post) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this post?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="inline-flex items-center text-xs font-bold text-red-600 hover:text-red-900 border border-red-100 bg-red-50/30 hover:bg-red-50 px-2 py-1 rounded transition duration-150">
                                                    Delete
                                                </button>
                                            </form>
                                        @endcan
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
@endsection
