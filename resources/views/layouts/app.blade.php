<!DOCTYPE html>
<html lang="en" class="h-full bg-slate-50/50">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'DevInsight') - Minimalist Blog</title>
    <!-- Google Fonts: Inter & Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Tailwind CSS Play CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                        display: ['Plus Jakarta Sans', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    <style>
        body {
            font-feature-settings: "cv02", "cv03", "cv04", "cv11";
        }
    </style>
</head>
<body class="flex flex-col min-h-full font-sans antialiased text-slate-700 bg-slate-50/50">
    <!-- Header -->
    <header class="sticky top-0 z-40 w-full border-b border-slate-200/80 bg-white/80 backdrop-blur-md">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
            <div class="flex items-center gap-6">
                <a href="{{ route('posts.index') }}" class="font-display font-extrabold text-xl tracking-tight text-indigo-600 hover:text-indigo-700 transition duration-150">
                    Dev<span class="text-slate-800">Insight</span>
                </a>
                <span class="h-4 w-px bg-slate-200"></span>
                <span class="text-xs font-semibold uppercase tracking-wider text-slate-400 hidden sm:inline-block">Laravel 13 Blog Demo</span>
            </div>
            
            <nav class="flex items-center gap-4">
                <a href="{{ route('posts.index') }}" class="text-sm font-medium text-slate-600 hover:text-slate-900 transition-colors mr-2">Home</a>
                
                @auth
                    <!-- Authenticated User Profile & Links -->
                    <span class="text-xs font-semibold px-2.5 py-1 rounded bg-slate-100 text-slate-600">
                        {{ auth()->user()->name }} ({{ ucfirst(auth()->user()->role) }})
                    </span>

                    @if(auth()->user()->isAdmin() || auth()->user()->isAuthor())
                        <a href="{{ route('dashboard.posts.index') }}" class="text-sm font-bold text-indigo-600 hover:text-indigo-800 transition-colors">
                            Dashboard
                        </a>
                    @endif

                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="text-sm font-medium text-slate-500 hover:text-slate-900 transition-colors hover:underline">
                            Log Out
                        </button>
                    </form>
                @else
                    <!-- Guest Links -->
                    <a href="{{ route('login') }}" class="text-sm font-medium text-slate-600 hover:text-slate-900 transition-colors">Log in</a>
                    <a href="{{ route('register') }}" class="inline-flex items-center justify-center px-3.5 py-1.5 bg-slate-900 hover:bg-slate-800 text-white text-xs font-semibold rounded-lg transition-colors shadow-sm">
                        Register
                    </a>
                @endauth
            </nav>
        </div>
    </header>

    <!-- Main Container -->
    <main class="flex-grow max-w-6xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            <!-- Left Side: Content -->
            <div class="lg:col-span-8">
                @yield('content')
            </div>

            <!-- Right Side: Sidebar -->
            <aside class="lg:col-span-4 space-y-6">
                <!-- About widget -->
                <div class="p-6 rounded-2xl bg-white border border-slate-200/60 shadow-[0_2px_8px_-3px_rgba(0,0,0,0.05)]">
                    <h3 class="font-display font-bold text-slate-800 text-base mb-3">About The Blog</h3>
                    <p class="text-sm text-slate-500 leading-relaxed">
                        Welcome to DevInsight, a clean blogging platform showcasing architectural principles in Laravel. Explore topics ranging from development practices to designs.
                    </p>
                </div>

                <!-- Categories Widget -->
                <div class="p-6 rounded-2xl bg-white border border-slate-200/60 shadow-[0_2px_8px_-3px_rgba(0,0,0,0.05)]">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="font-display font-bold text-slate-800 text-base">Categories</h3>
                        @if(request()->has('category_id'))
                            <a href="{{ route('posts.index') }}" class="text-xs font-semibold text-indigo-600 hover:text-indigo-800 hover:underline">Clear filter</a>
                        @endif
                    </div>
                    <ul class="space-y-2">
                        <!-- All Categories Link -->
                        <li>
                            <a href="{{ route('posts.index') }}" 
                               class="flex items-center justify-between px-3 py-2 rounded-lg text-sm font-medium transition duration-150 {{ !request()->has('category_id') ? 'bg-indigo-50 text-indigo-700' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                                <span>All Topics</span>
                                <span class="text-xs px-2 py-0.5 rounded-full {{ !request()->has('category_id') ? 'bg-indigo-100 text-indigo-700' : 'bg-slate-100 text-slate-500' }}">
                                    {{ \App\Models\Post::count() }}
                                </span>
                            </a>
                        </li>
                        <!-- Individual Categories -->
                        @foreach($categories as $category)
                            <li>
                                <a href="{{ route('posts.index', ['category_id' => $category->id]) }}" 
                                   class="flex items-center justify-between px-3 py-2 rounded-lg text-sm font-medium transition duration-150 {{ request()->query('category_id') == $category->id ? 'bg-indigo-50 text-indigo-700' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                                    <span>{{ $category->name }}</span>
                                    <span class="text-xs px-2 py-0.5 rounded-full {{ request()->query('category_id') == $category->id ? 'bg-indigo-100 text-indigo-700' : 'bg-slate-100 text-slate-500' }}">
                                        {{ $category->posts_count }}
                                    </span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </aside>
        </div>
    </main>

    <!-- Footer -->
    <footer class="w-full border-t border-slate-200/80 bg-white py-6">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row items-center justify-between gap-4 text-sm text-slate-400 font-medium">
            <p>&copy; 2026 DevInsight. All rights reserved.</p>
            <p class="flex items-center gap-1">
                Built with <span class="text-red-500">&hearts;</span> and <a href="https://laravel.com" class="text-slate-500 hover:text-indigo-600 transition-colors">Laravel</a>.
            </p>
        </div>
    </footer>
</body>
</html>
