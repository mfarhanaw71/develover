@extends('layouts.app')

@section('title', 'Progress Quest - SPARK')

@section('content')
<div class="py-8 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto">
    
    <div class="card-spark">
        <div class="card-spark-header flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <h1 class="text-xl font-bold text-gray-900">
                    <i class="fas fa-scroll text-primary mr-2"></i>
                    Progress Quest Mahasiswa
                </h1>
                <p class="text-sm text-gray-500 mt-0.5">Pantau penyelesaian quest harian mahasiswa</p>
            </div>
            <span class="text-sm text-gray-400">
                <i class="far fa-calendar-alt mr-1"></i>
                {{ now()->format('d F Y') }}
            </span>
        </div>
        
        <div class="card-spark-body">
            
            <!-- 🔵 PERUBAHAN: Filter dengan icon -->
            <div class="flex flex-wrap gap-3 mb-6">
                <div class="flex items-center gap-2">
                    <i class="fas fa-filter text-gray-400 text-sm"></i>
                    <select id="groupFilter" 
                            class="border border-gray-200 rounded-lg px-4 py-2 text-sm focus:border-primary focus:ring-1 focus:ring-primary outline-none transition">
                        <option value="">Semua Kelompok</option>
                        @foreach($groups as $group)
                            <option value="{{ $group->id }}">{{ $group->name }}</option>
                        @endforeach
                    </select>
                </div>
                <select id="questFilter" 
                        class="border border-gray-200 rounded-lg px-4 py-2 text-sm focus:border-primary focus:ring-1 focus:ring-primary outline-none transition">
                    <option value="">Semua Quest</option>
                    @foreach($quests as $quest)
                        <option value="{{ $quest->id }}">{{ $quest->title }}</option>
                    @endforeach
                </select>
                <button onclick="resetFilters()" 
                        class="btn-spark btn-spark-ghost text-sm py-2">
                    <i class="fas fa-undo"></i>
                    Reset
                </button>
            </div>
            
            <!-- 🔵 PERUBAHAN: Summary Cards -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
                <div class="bg-primary/5 rounded-xl p-4 text-center border border-primary/10">
                    <div class="text-2xl font-bold text-primary">{{ $total_students ?? 0 }}</div>
                    <div class="text-xs text-gray-500"><i class="fas fa-user-graduate mr-1"></i>Total Mahasiswa</div>
                </div>
                <div class="bg-emerald-50 rounded-xl p-4 text-center border border-emerald-100">
                    <div class="text-2xl font-bold text-emerald-600">{{ $completed_today ?? 0 }}</div>
                    <div class="text-xs text-gray-500"><i class="fas fa-check-circle mr-1"></i>Quest Selesai Hari Ini</div>
                </div>
                <div class="bg-amber-50 rounded-xl p-4 text-center border border-amber-100">
                    <div class="text-2xl font-bold text-amber-600">{{ $completion_rate ?? 0 }}%</div>
                    <div class="text-xs text-gray-500"><i class="fas fa-chart-pie mr-1"></i>Rata-rata Completion</div>
                </div>
                <div class="bg-accent-light/20 rounded-xl p-4 text-center border border-accent/20">
                    <div class="text-2xl font-bold text-accent">{{ $total_food_given ?? 0 }}</div>
                    <div class="text-xs text-gray-500"><i class="fas fa-drumstick-bite mr-1"></i>Total Food Diberikan</div>
                </div>
            </div>
            
            <!-- 🔵 PERUBAHAN: Table dengan hover -->
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Mahasiswa</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kelompok</th>
                            @foreach($quests as $quest)
                            <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase group relative">
                                <span class="cursor-help" title="{{ $quest->title }}">
                                    {{ Str::limit($quest->title, 12) }}
                                </span>
                            </th>
                            @endforeach
                            <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase">Total</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($students as $student)
                        <tr data-group-id="{{ $student->group_id }}" class="hover:bg-gray-50/50 transition">
                            <td class="px-4 py-3 text-sm">
                                <div class="font-medium text-gray-900">{{ $student->name }}</div>
                                <div class="text-xs text-gray-400 font-mono">{{ $student->nim }}</div>
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-600">{{ $student->group->name ?? '-' }}</td>
                            @php
                                $completedCount = 0;
                            @endphp
                            @foreach($quests as $quest)
                                @php
                                    $isCompleted = $student->userQuests
                                        ->where('quest_id', $quest->id)
                                        ->whereDate('quest_date', today())
                                        ->where('is_completed', true)
                                        ->isNotEmpty();
                                    if($isCompleted) $completedCount++;
                                @endphp
                                <td class="px-4 py-3 text-center">
                                    @if($isCompleted)
                                        <span class="inline-flex items-center justify-center w-8 h-8 bg-emerald-100 rounded-full text-emerald-600">
                                            <i class="fas fa-check text-sm"></i>
                                        </span>
                                    @else
                                        <span class="inline-flex items-center justify-center w-8 h-8 bg-gray-100 rounded-full text-gray-400">
                                            <i class="fas fa-minus text-sm"></i>
                                        </span>
                                    @endif
                                </td>
                            @endforeach
                            <td class="px-4 py-3 text-center font-bold text-primary">
                                {{ $completedCount }}/{{ $quests->count() }}
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="{{ 3 + $quests->count() }}" class="px-4 py-8 text-center text-gray-500">
                                <i class="fas fa-inbox text-3xl block mb-2 text-gray-300"></i>
                                Belum ada data mahasiswa
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
        </div>
    </div>
    
</div>

<script>
    function resetFilters() {
        document.getElementById('groupFilter').value = '';
        document.getElementById('questFilter').value = '';
        filterTable();
    }
    
    function filterTable() {
        let groupFilter = document.getElementById('groupFilter').value;
        let questFilter = document.getElementById('questFilter').value;
        let rows = document.querySelectorAll('tbody tr');
        
        rows.forEach(row => {
            let groupMatch = !groupFilter || row.dataset.groupId == groupFilter;
            row.style.display = groupMatch ? '' : 'none';
        });
        
        // Quest filter akan memerlukan server-side logic
        // Ini hanya client-side untuk kelompok
    }
    
    document.getElementById('groupFilter')?.addEventListener('change', filterTable);
</script>
@endsection