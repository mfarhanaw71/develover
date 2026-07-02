@extends('layouts.app')

@section('title', 'Dashboard Mentor - SPARK')

@section('content')
<div class="py-8 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto">
    
    <!-- Header - TANPA EMOJI TANGAN -->
    <div class="card-spark mb-8 overflow-hidden">
        <div class="bg-gradient-to-r from-[#068CE6] to-[#008CA9] px-6 py-8 md:px-8 md:py-10">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                <div>
                    <h1 class="font-battlesbridge text-3xl md:text-4xl text-white">
                        Ahoy, {{ Auth::user()->name }}!
                    </h1>
                    <p class="text-white/80 text-sm md:text-base mt-1">
                        <i class="fas fa-compass mr-2"></i>
                        Selamat datang di dashboard mentor SPARK
                    </p>
                </div>
                <div class="mt-3 md:mt-0">
                    <span class="inline-flex items-center gap-2 bg-white/20 text-white px-4 py-2 rounded-full text-sm">
                        <i class="fas fa-calendar-day"></i>
                        {{ now()->format('d F Y') }}
                    </span>
                </div>
            </div>
        </div>
    </div>
    
    <!-- 🔵 STATS CARDS - PAKAI ICON FONT AWESOME -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 md:gap-6 mb-8">
        <!-- Card 1: Total Mahasiswa -->
        <div class="card-spark card-spark-hover p-5">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-primary/10 flex items-center justify-center text-primary text-xl">
                    <i class="fas fa-users"></i>
                </div>
                <div>
                    <div class="text-2xl font-bold text-gray-900">{{ $total_students ?? 0 }}</div>
                    <div class="text-sm text-gray-500">Total Mahasiswa</div>
                </div>
            </div>
        </div>
        
        <!-- Card 2: Kelompok -->
        <div class="card-spark card-spark-hover p-5">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-accent/10 flex items-center justify-center text-accent text-xl">
                    <i class="fas fa-layer-group"></i>
                </div>
                <div>
                    <div class="text-2xl font-bold text-gray-900">{{ $total_groups ?? 0 }}</div>
                    <div class="text-sm text-gray-500">Kelompok</div>
                </div>
            </div>
        </div>
        
        <!-- Card 3: Quest Hari Ini -->
        <div class="card-spark card-spark-hover p-5">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-emerald-100 flex items-center justify-center text-emerald-600 text-xl">
                    <i class="fas fa-check-double"></i>
                </div>
                <div>
                    <div class="text-2xl font-bold text-gray-900">{{ $total_quests_completed_today ?? 0 }}</div>
                    <div class="text-sm text-gray-500">Quest Hari Ini</div>
                </div>
            </div>
        </div>
        
        <!-- Card 4: Rata-rata Pet Level -->
        <div class="card-spark card-spark-hover p-5">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-purple-100 flex items-center justify-center text-purple-600 text-xl">
                    <i class="fas fa-paw"></i>
                </div>
                <div>
                    <div class="text-2xl font-bold text-gray-900">{{ $avg_pet_level ?? 1 }}</div>
                    <div class="text-sm text-gray-500">Rata-rata Pet Level</div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Two Column Layout -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        
        <!-- Kelompok Bimbingan -->
        <div class="card-spark">
            <div class="card-spark-header flex items-center justify-between">
                <h2 class="text-lg font-bold text-gray-900">
                    <i class="fas fa-layer-group text-primary mr-2"></i>
                    Kelompok Bimbingan
                </h2>
                <span class="badge-spark badge-spark-primary">
                    {{ $groups->count() ?? 0 }} Kelompok
                </span>
            </div>
            <div class="card-spark-body space-y-4">
                @forelse($groups as $group)
                <div class="border rounded-xl p-4 hover:shadow-card-hover transition-all duration-300 border-primary/5">
                    <div class="flex justify-between items-start">
                        <div>
                            <h3 class="font-bold text-gray-900">{{ $group->name }}</h3>
                            <p class="text-sm text-gray-500">
                                <i class="fas fa-tag mr-1"></i>
                                {{ $group->code }}
                            </p>
                        </div>
                        <span class="badge-spark badge-spark-accent text-xs">
                            <i class="fas fa-user-graduate mr-1"></i>
                            {{ $group->students->count() }} Mahasiswa
                        </span>
                    </div>
                    
                    <div class="mt-3">
                        <div class="flex justify-between text-sm mb-1">
                            <span class="text-gray-600">
                                <i class="fas fa-heartbeat text-accent mr-1"></i>
                                Pet Health
                            </span>
                            <span class="font-medium">{{ $group->pet_health }}%</span>
                        </div>
                        <div class="progress-spark">
                            <div class="progress-spark-bar" style="width: {{ $group->pet_health }}%"></div>
                        </div>
                    </div>
                    
                    <div class="mt-2 text-sm flex items-center gap-3">
                        <span class="text-gray-600">
                            <i class="fas fa-paw text-primary mr-1"></i>
                            Level:
                        </span>
                        <span class="font-bold text-primary">{{ $group->pet->level ?? 1 }}</span>
                    </div>
                </div>
                @empty
                <p class="text-gray-500 text-center py-6">
                    <i class="fas fa-inbox text-2xl block mb-2 text-gray-300"></i>
                    Belum ada kelompok bimbingan
                </p>
                @endforelse
            </div>
        </div>
        
        <!-- Pengumuman Terbaru -->
        <div class="card-spark">
            <div class="card-spark-header flex items-center justify-between">
                <h2 class="text-lg font-bold text-gray-900">
                    <i class="fas fa-bullhorn text-primary mr-2"></i>
                    Pengumuman Terbaru
                </h2>
                <a href="{{ route('mentor.announcements.create') }}" 
                   class="btn-spark btn-spark-primary text-sm py-1.5 px-3">
                    <i class="fas fa-plus"></i>
                    Buat
                </a>
            </div>
            <div class="card-spark-body space-y-3">
                @forelse($recent_announcements as $announcement)
                <div class="border-b border-gray-100 pb-3 last:border-0 last:pb-0">
                    <div class="flex justify-between items-start">
                        <h3 class="font-semibold text-gray-900">{{ $announcement->title }}</h3>
                        <span class="text-xs text-gray-400">{{ $announcement->created_at->diffForHumans() }}</span>
                    </div>
                    <p class="text-sm text-gray-600 mt-1">{{ Str::limit($announcement->content, 80) }}</p>
                    <a href="{{ route('mentor.announcements.show', $announcement->id) }}" 
                       class="text-primary text-xs hover:text-primary-hover inline-flex items-center gap-1 mt-1">
                        Baca selengkapnya <i class="fas fa-arrow-right text-[10px]"></i>
                    </a>
                </div>
                @empty
                <p class="text-gray-500 text-center py-6">
                    <i class="fas fa-inbox text-2xl block mb-2 text-gray-300"></i>
                    Belum ada pengumuman
                </p>
                @endforelse
            </div>
        </div>
    </div>
    
    <!-- Quick Actions -->
    <div class="card-spark mt-8">
        <div class="card-spark-header">
            <h2 class="text-lg font-bold text-gray-900">
                <i class="fas fa-bolt text-yellow-500 mr-2"></i>
                Quick Actions
            </h2>
        </div>
        <div class="card-spark-body">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                <a href="{{ route('mentor.students.create') }}" 
                   class="flex items-center justify-center gap-2 bg-primary/5 hover:bg-primary/10 text-primary p-4 rounded-xl transition-all duration-200 border border-primary/10 hover:border-primary/20">
                    <i class="fas fa-user-plus"></i>
                    <span class="font-medium text-sm">Tambah Mahasiswa</span>
                </a>
                <a href="{{ route('mentor.students.import.form') }}" 
                   class="flex items-center justify-center gap-2 bg-accent/5 hover:bg-accent/10 text-accent p-4 rounded-xl transition-all duration-200 border border-accent/10 hover:border-accent/20">
                    <i class="fas fa-file-import"></i>
                    <span class="font-medium text-sm">Import Excel</span>
                </a>
                <a href="{{ route('mentor.pet.progress') }}" 
                   class="flex items-center justify-center gap-2 bg-emerald-50 hover:bg-emerald-100 text-emerald-600 p-4 rounded-xl transition-all duration-200 border border-emerald-100 hover:border-emerald-200">
                    <i class="fas fa-paw"></i>
                    <span class="font-medium text-sm">Progress Pet</span>
                </a>
                <a href="{{ route('mentor.quests.progress') }}" 
                   class="flex items-center justify-center gap-2 bg-purple-50 hover:bg-purple-100 text-purple-600 p-4 rounded-xl transition-all duration-200 border border-purple-100 hover:border-purple-200">
                    <i class="fas fa-scroll"></i>
                    <span class="font-medium text-sm">Progress Quest</span>
                </a>
            </div>
        </div>
    </div>
    
</div>
@endsection