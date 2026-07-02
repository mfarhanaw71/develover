@extends('layouts.app')

@section('title', 'Pengumuman - SPARK')

@section('content')
<div class="py-8 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto">
    
    <div class="card-spark">
        <div class="card-spark-header flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">
                    <i class="fas fa-bullhorn text-primary mr-2"></i>
                    Pengumuman
                </h1>
                <p class="text-sm text-gray-500 mt-0.5">
                    Kelola pengumuman untuk mahasiswa bimbingan
                </p>
            </div>
            <a href="{{ route('mentor.announcements.create') }}" 
               class="btn-spark btn-spark-primary">
                <i class="fas fa-plus"></i>
                Buat Pengumuman
            </a>
        </div>
        
        <div class="card-spark-body">
            <!-- Filter -->
            <div class="mb-6">
                <div class="flex items-center gap-3">
                    <i class="fas fa-filter text-gray-400 text-sm"></i>
                    <select id="groupFilter" 
                            class="border border-gray-200 rounded-lg px-4 py-2 text-sm focus:border-primary focus:ring-1 focus:ring-primary outline-none transition">
                        <option value="">Semua Kelompok</option>
                        @foreach($groups as $group)
                            <option value="{{ $group->id }}">{{ $group->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            
            <!-- Announcements List -->
            <div class="space-y-4">
                @forelse($announcements as $announcement)
                <div class="border rounded-xl p-5 hover:shadow-card-hover transition-all duration-300 border-primary/5 hover:border-primary/15" 
                     data-group-id="{{ $announcement->group_id }}">
                    <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-3">
                        <div class="flex-1">
                            <h3 class="font-bold text-gray-900 text-lg">{{ $announcement->title }}</h3>
                            <div class="flex flex-wrap items-center gap-3 mt-1 text-sm text-gray-500">
                                <span class="inline-flex items-center gap-1">
                                    <i class="fas fa-layer-group text-accent"></i>
                                    {{ $announcement->group->name }}
                                </span>
                                <span class="inline-flex items-center gap-1">
                                    <i class="far fa-clock"></i>
                                    {{ $announcement->created_at->diffForHumans() }}
                                </span>
                            </div>
                        </div>
                        <!-- 🔵 AKSI: SHOW, EDIT, DELETE -->
                        <div class="flex items-center gap-2 flex-shrink-0">
                            <a href="{{ route('mentor.announcements.show', $announcement->id) }}" 
                               class="text-primary hover:text-primary-hover p-2 rounded-lg hover:bg-primary/5 transition">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('mentor.announcements.edit', $announcement->id) }}" 
                               class="text-amber-600 hover:text-amber-700 p-2 rounded-lg hover:bg-amber-50 transition">
                                <i class="fas fa-pen"></i>
                            </a>
                            <form action="{{ route('mentor.announcements.destroy', $announcement->id) }}" 
                                  method="POST" class="inline" 
                                  onsubmit="return confirm('Yakin hapus pengumuman ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="text-red-500 hover:text-red-700 p-2 rounded-lg hover:bg-red-50 transition">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                    <p class="text-gray-600 mt-2 text-sm">{{ Str::limit($announcement->content, 150) }}</p>
                </div>
                @empty
                <div class="text-center py-10">
                    <i class="fas fa-inbox text-5xl text-gray-300 mb-3 block"></i>
                    <p class="text-gray-500">Belum ada pengumuman.</p>
                    <a href="{{ route('mentor.announcements.create') }}" 
                       class="text-primary hover:text-primary-hover font-medium inline-flex items-center gap-1 mt-2">
                        Buat pengumuman pertama <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
                @endforelse
            </div>
        </div>
    </div>
    
</div>

<script>
    document.getElementById('groupFilter')?.addEventListener('change', function() {
        let groupId = this.value;
        let items = document.querySelectorAll('[data-group-id]');
        items.forEach(item => {
            item.style.display = (!groupId || item.dataset.groupId == groupId) ? '' : 'none';
        });
    });
</script>
@endsection