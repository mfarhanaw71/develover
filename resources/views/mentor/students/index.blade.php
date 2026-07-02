@extends('layouts.app')

@section('title', 'Manajemen Mahasiswa - SPARK')

@section('content')
<div class="py-8 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto">
    
    <div class="card-spark">
        <!-- Header -->
        <div class="card-spark-header flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">
                    <i class="fas fa-user-graduate text-primary mr-2"></i>
                    Manajemen Mahasiswa
                </h1>
                <p class="text-sm text-gray-500 mt-0.5">Kelola mahasiswa bimbingan Anda</p>
            </div>
            <div class="flex flex-wrap gap-2">
                <a href="{{ route('mentor.students.import.form') }}" 
                   class="btn-spark" style="background-color: #008CA9; hover:background-color: #006f86; color: white;">
                    <i class="fas fa-file-import"></i>
                    Import Excel
                </a>
                <a href="{{ route('mentor.students.create') }}" 
                   class="btn-spark btn-spark-primary">
                    <i class="fas fa-plus"></i>
                    Tambah
                </a>
            </div>
        </div>
        
        <div class="card-spark-body">
            <!-- Filter & Search -->
            <div class="flex flex-wrap gap-3 mb-4">
                <div class="relative flex-1 min-w-[200px]">
                    <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
                    <input type="text" id="search" 
                           placeholder="Cari NIM atau Nama..." 
                           class="w-full border border-gray-200 rounded-lg pl-9 pr-4 py-2 text-sm focus:border-primary focus:ring-1 focus:ring-primary outline-none transition">
                </div>
                <select id="groupFilter" 
                        class="border border-gray-200 rounded-lg px-4 py-2 text-sm focus:border-primary focus:ring-1 focus:ring-primary outline-none transition">
                    <option value="">Semua Kelompok</option>
                    @foreach($groups as $group)
                        <option value="{{ $group->id }}">{{ $group->name }}</option>
                    @endforeach
                </select>
            </div>
            
            <!-- Table -->
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">NIM</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kelompok</th>
                            <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase">Food Points</th>
                            <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase">Quest</th>
                            <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase">CFT</th>
                            <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase">Status</th>
                            <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($students as $student)
                        <tr data-group-id="{{ $student->group_id }}" class="hover:bg-gray-50/50 transition">
                            <td class="px-4 py-3 text-sm font-mono text-gray-700">{{ $student->nim }}</td>
                            <td class="px-4 py-3 text-sm font-medium text-gray-900">{{ $student->name }}</td>
                            <td class="px-4 py-3 text-sm text-gray-600">{{ $student->group->name ?? '-' }}</td>
                            <td class="px-4 py-3 text-sm text-center">
                                <span class="inline-flex items-center gap-1 bg-amber-50 text-amber-700 px-2 py-1 rounded-full text-xs">
                                    <i class="fas fa-drumstick-bite"></i>
                                    {{ $student->food_points }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-sm text-center">
                                {{ $student->userQuests()->where('is_completed', true)->whereDate('completed_date', today())->count() }}
                            </td>
                            <td class="px-4 py-3 text-sm text-center">
                                {{ $student->cftAttempts()->where('is_correct', true)->count() }}
                            </td>
                            <td class="px-4 py-3 text-sm text-center">
                                @if($student->is_active)
                                    <span class="badge-spark badge-spark-success">
                                        <i class="fas fa-circle text-[6px] mr-1"></i>
                                        Aktif
                                    </span>
                                @else
                                    <span class="badge-spark badge-spark-danger">
                                        <i class="fas fa-circle text-[6px] mr-1"></i>
                                        Nonaktif
                                    </span>
                                @endif
                            </td>
                            <!-- 🔵 AKSI: EDIT & HAPUS -->
                            <td class="px-4 py-3 text-sm text-center">
                                <div class="flex items-center justify-center gap-1">
                                    <a href="{{ route('mentor.students.edit', $student->id) }}" 
                                       class="text-amber-600 hover:text-amber-700 p-1.5 rounded hover:bg-amber-50 transition">
                                        <i class="fas fa-pen text-sm"></i>
                                    </a>
                                    <form action="{{ route('mentor.students.destroy', $student->id) }}" 
                                          method="POST" class="inline" 
                                          onsubmit="return confirm('Yakin hapus mahasiswa ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="text-red-500 hover:text-red-700 p-1.5 rounded hover:bg-red-50 transition">
                                            <i class="fas fa-trash text-sm"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="px-4 py-8 text-center text-gray-500">
                                <i class="fas fa-inbox text-3xl block mb-2 text-gray-300"></i>
                                Belum ada mahasiswa bimbingan.
                                <div class="mt-2 flex items-center justify-center gap-3">
                                    <a href="{{ route('mentor.students.create') }}" class="text-primary hover:underline">Tambah manual</a>
                                    <span class="text-gray-300">|</span>
                                    <a href="{{ route('mentor.students.import.form') }}" class="text-accent hover:underline">Import Excel</a>
                                </div>
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
    function filterTable() {
        let searchText = document.getElementById('search').value.toLowerCase();
        let groupFilter = document.getElementById('groupFilter').value;
        let rows = document.querySelectorAll('tbody tr');
        
        rows.forEach(row => {
            let text = row.innerText.toLowerCase();
            let groupMatch = !groupFilter || row.dataset.groupId == groupFilter;
            let searchMatch = text.includes(searchText);
            row.style.display = (groupMatch && searchMatch) ? '' : 'none';
        });
    }
    
    document.getElementById('search')?.addEventListener('keyup', filterTable);
    document.getElementById('groupFilter')?.addEventListener('change', filterTable);
</script>
@endsection