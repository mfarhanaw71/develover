<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>@yield('title', 'SPARK')</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    
    <!-- Font Awesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-50">
    <div class="min-h-screen bg-gray-50">
        
        <!-- 🔵 NAVBAR LENGKAP -->
        <nav class="bg-gradient-to-r from-[#068CE6] to-[#27B1FE] shadow-lg">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex items-center gap-6">
                        <!-- Logo SPARK -->
                        <a href="{{ route('mentor.dashboard') }}" class="flex items-center gap-2">
                            <span class="font-battlesbridge text-2xl text-white tracking-wide">
                                SPARK
                            </span>
                            <span class="text-white/60 text-xs font-light hidden sm:inline">
                                Mentor
                            </span>
                        </a>
                        
                        <!-- 🔵 MENU NAVBAR -->
                        <div class="hidden md:flex items-center gap-1">
                            <a href="{{ route('mentor.dashboard') }}" 
                               class="text-white/80 hover:text-white px-3 py-2 rounded-lg text-sm font-medium transition {{ request()->routeIs('mentor.dashboard') ? 'bg-white/20 text-white' : '' }}">
                                <i class="fas fa-home mr-1"></i>
                                Dashboard
                            </a>
                            <a href="{{ route('mentor.students.index') }}" 
                               class="text-white/80 hover:text-white px-3 py-2 rounded-lg text-sm font-medium transition {{ request()->routeIs('mentor.students.*') ? 'bg-white/20 text-white' : '' }}">
                                <i class="fas fa-user-graduate mr-1"></i>
                                Mahasiswa
                            </a>
                            <a href="{{ route('mentor.pet.progress') }}" 
                               class="text-white/80 hover:text-white px-3 py-2 rounded-lg text-sm font-medium transition {{ request()->routeIs('mentor.pet.progress') ? 'bg-white/20 text-white' : '' }}">
                                <i class="fas fa-paw mr-1"></i>
                                Progress Pet
                            </a>
                            <a href="{{ route('mentor.quests.progress') }}" 
                               class="text-white/80 hover:text-white px-3 py-2 rounded-lg text-sm font-medium transition {{ request()->routeIs('mentor.quests.progress') ? 'bg-white/20 text-white' : '' }}">
                                <i class="fas fa-scroll mr-1"></i>
                                Progress Quest
                            </a>
                            <a href="{{ route('mentor.announcements.index') }}" 
                               class="text-white/80 hover:text-white px-3 py-2 rounded-lg text-sm font-medium transition {{ request()->routeIs('mentor.announcements.*') ? 'bg-white/20 text-white' : '' }}">
                                <i class="fas fa-bullhorn mr-1"></i>
                                Pengumuman
                            </a>
                        </div>
                    </div>
                    
                    <!-- Right side -->
                    <div class="flex items-center gap-4">
                        <span class="text-white/80 text-sm hidden md:block">
                            {{ Auth::user()->name }}
                        </span>
                        <a href="{{ route('logout') }}" 
                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                           class="text-white/70 hover:text-white transition">
                            <i class="fas fa-sign-out-alt"></i>
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                            @csrf
                        </form>
                    </div>
                </div>
                
                <!-- 🔵 MOBILE MENU -->
                <div class="md:hidden flex items-center gap-1 py-2 overflow-x-auto">
                    <a href="{{ route('mentor.dashboard') }}" 
                       class="text-white/80 hover:text-white px-3 py-1.5 rounded-lg text-xs font-medium transition whitespace-nowrap {{ request()->routeIs('mentor.dashboard') ? 'bg-white/20 text-white' : '' }}">
                        <i class="fas fa-home mr-1"></i>
                        Home
                    </a>
                    <a href="{{ route('mentor.students.index') }}" 
                       class="text-white/80 hover:text-white px-3 py-1.5 rounded-lg text-xs font-medium transition whitespace-nowrap {{ request()->routeIs('mentor.students.*') ? 'bg-white/20 text-white' : '' }}">
                        <i class="fas fa-user-graduate mr-1"></i>
                        Mahasiswa
                    </a>
                    <a href="{{ route('mentor.pet.progress') }}" 
                       class="text-white/80 hover:text-white px-3 py-1.5 rounded-lg text-xs font-medium transition whitespace-nowrap {{ request()->routeIs('mentor.pet.progress') ? 'bg-white/20 text-white' : '' }}">
                        <i class="fas fa-paw mr-1"></i>
                        Pet
                    </a>
                    <a href="{{ route('mentor.quests.progress') }}" 
                       class="text-white/80 hover:text-white px-3 py-1.5 rounded-lg text-xs font-medium transition whitespace-nowrap {{ request()->routeIs('mentor.quests.progress') ? 'bg-white/20 text-white' : '' }}">
                        <i class="fas fa-scroll mr-1"></i>
                        Quest
                    </a>
                    <a href="{{ route('mentor.announcements.index') }}" 
                       class="text-white/80 hover:text-white px-3 py-1.5 rounded-lg text-xs font-medium transition whitespace-nowrap {{ request()->routeIs('mentor.announcements.*') ? 'bg-white/20 text-white' : '' }}">
                        <i class="fas fa-bullhorn mr-1"></i>
                        Pengumuman
                    </a>
                </div>
            </div>
        </nav>

        <!-- Page Content -->
        <main>
            @yield('content')
        </main>
    </div>
</body>
</html>