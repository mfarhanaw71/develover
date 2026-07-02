@extends('layouts.app')

@section('title', 'Progress Pet - SPARK')

@section('content')
<div class="py-8 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto">
    
    <div class="card-spark">
        <div class="card-spark-header">
            <h1 class="text-xl font-bold text-gray-900">
                <i class="fas fa-paw text-primary mr-2"></i>
                Progress Pet Kelompok
            </h1>
            <p class="text-sm text-gray-500 mt-0.5">Pantau perkembangan pet di setiap kelompok bimbingan</p>
        </div>
        
        <div class="card-spark-body">
            
            <div class="grid grid-cols-1 md:grid-cols-1 gap-6">
                @forelse($groups as $group)
                @php
                    $petLevel = $group->pet->level ?? 1;
                    $petEmoji = $petLevel < 3 ? '🐣' : ($petLevel < 6 ? '🐥' : '🦅');
                    $petName = $group->pet->name ?? 'Baby Pet';
                    
                    // 🔵 FIX: Bersihkan path gambar
                    $imagePath = $group->pet->image ?? null;
                    if ($imagePath) {
                        // Hapus domain
                        $imagePath = str_replace('http://127.0.0.1:8000/', '', $imagePath);
                        $imagePath = str_replace('https://127.0.0.1:8000/', '', $imagePath);
                        // Hapus 'storage/' kalo udah ada
                        $imagePath = str_replace('storage/', '', $imagePath);
                        // Path final
                        $imagePath = 'storage/' . $imagePath;
                    }
                @endphp
                
                <div class="border border-primary/5 rounded-xl overflow-hidden hover:shadow-card-hover transition-all duration-300">
                    
                    <!-- Header Group -->
                    <div class="bg-gradient-to-r from-[#068CE6] to-[#008CA9] px-5 py-4 text-white">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="font-bold text-lg">{{ $group->name }}</h3>
                                <p class="text-sm opacity-80"><i class="fas fa-tag mr-1"></i>{{ $group->code }}</p>
                            </div>
                            <span class="bg-white/20 px-3 py-1 rounded-full text-xs">
                                <i class="fas fa-user-graduate mr-1"></i>
                                {{ $group->students->count() }} Mahasiswa
                            </span>
                        </div>
                    </div>
                    
                    <div class="p-6">
                        <!-- 🔵 PET DISPLAY - FULL SIZE & CENTERED -->
                        <div class="text-center mb-6">
                            <div class="relative inline-block">
                                @if($imagePath && file_exists(public_path($imagePath)))
                                    <img src="{{ asset($imagePath) }}" 
                                         alt="{{ $petName }}" 
                                         class="w-56 h-56 mx-auto object-cover rounded-full border-4 border-white/30 shadow-2xl">
                                @else
                                    <div class="text-9xl mb-2">{{ $petEmoji }}</div>
                                @endif
                                <!-- Badge Level -->
                                <span class="absolute -bottom-2 -right-2 bg-primary text-white text-xs font-bold px-3 py-1 rounded-full shadow-lg">
                                    Lv.{{ $petLevel }}
                                </span>
                            </div>
                            <div class="font-bold text-xl text-gray-900 mt-3">{{ $petName }}</div>
                            <div class="text-sm text-gray-500">
                                <i class="fas fa-star text-amber-500 mr-1"></i>
                                Exp {{ $group->pet->experience ?? 0 }}/100
                            </div>
                        </div>
                        
                        <!-- Experience Bar -->
                        <div class="mb-4">
                            <div class="flex justify-between text-sm mb-1">
                                <span class="text-gray-600"><i class="fas fa-chart-line text-primary mr-1"></i>Experience</span>
                                <span class="font-medium">{{ ($group->pet->experience ?? 0) }}%</span>
                            </div>
                            <div class="progress-spark h-4">
                                <div class="progress-spark-bar" style="width: {{ ($group->pet->experience ?? 0) }}%"></div>
                            </div>
                        </div>
                        
                        <!-- Pet Health -->
                        <div class="mb-4">
                            <div class="flex justify-between text-sm mb-1">
                                <span class="text-gray-600"><i class="fas fa-heartbeat text-accent mr-1"></i>Pet Health</span>
                                <span class="font-medium">{{ $group->pet_health }}%</span>
                            </div>
                            <div class="progress-spark h-4">
                                <div class="progress-spark-bar" style="width: {{ $group->pet_health }}%"></div>
                            </div>
                        </div>
                        
                        <!-- Stats -->
                        <div class="grid grid-cols-3 gap-3 mt-4 pt-3 border-t border-gray-100">
                            <div class="text-center bg-gray-50 rounded-lg py-3">
                                <div class="text-2xl font-bold text-primary">{{ $group->students->count() }}</div>
                                <div class="text-xs text-gray-500">Mahasiswa</div>
                            </div>
                            <div class="text-center bg-gray-50 rounded-lg py-3">
                                <div class="text-2xl font-bold text-accent">{{ $group->pet->feedLogs->count() ?? 0 }}</div>
                                <div class="text-xs text-gray-500">Total Feed</div>
                            </div>
                            <div class="text-center bg-gray-50 rounded-lg py-3">
                                <div class="text-2xl font-bold text-amber-500">{{ $group->pet->feedLogs->where('created_at', '>=', now()->subDay())->count() ?? 0 }}</div>
                                <div class="text-xs text-gray-500">Feed Hari Ini</div>
                            </div>
                        </div>
                        
                        <!-- Recent Feeders -->
                        @php
                            $recentFeeds = $group->pet->feedLogs()->with('user')->latest()->take(5)->get() ?? collect();
                        @endphp
                        @if($recentFeeds->count() > 0)
                        <div class="mt-4 pt-3 border-t border-gray-100">
                            <p class="text-sm font-semibold text-gray-700 mb-2">
                                <i class="fas fa-utensils text-amber-500 mr-1"></i>
                                Pemberi Makan Terbaru:
                            </p>
                            <div class="space-y-1">
                                @foreach($recentFeeds as $feed)
                                <div class="flex justify-between text-xs bg-gray-50 px-3 py-1.5 rounded-lg">
                                    <span class="font-medium text-gray-700">{{ $feed->user->name }}</span>
                                    <span class="text-gray-400">
                                        <i class="fas fa-drumstick-bite text-amber-500 mr-1"></i>
                                        {{ $feed->food_amount }} 🍖 • {{ $feed->created_at->diffForHumans() }}
                                    </span>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
                @empty
                <div class="col-span-full text-center py-12">
                    <i class="fas fa-paw text-5xl text-gray-300 block mb-3"></i>
                    <p class="text-gray-500">Belum ada kelompok bimbingan</p>
                </div>
                @endforelse
            </div>
            
        </div>
    </div>
    
</div>
@endsection