@extends('layouts.app')

@section('title', 'Import Mahasiswa - SPARK')

@section('content')
<div class="py-8 px-4 sm:px-6 lg:px-8 max-w-3xl mx-auto">
    
    <div class="card-spark">
        <div class="card-spark-header flex items-center justify-between">
            <h1 class="text-xl font-bold text-gray-900">
                <i class="fas fa-file-import text-accent mr-2"></i>
                Import Mahasiswa (Excel)
            </h1>
            <a href="{{ route('mentor.students.index') }}" 
               class="text-gray-500 hover:text-gray-700 transition">
                <i class="fas fa-arrow-left mr-1"></i>
                Kembali
            </a>
        </div>
        
        <div class="card-spark-body">
            
            <!-- Panduan -->
            <div class="bg-accent-light/10 border border-accent/20 rounded-xl p-4 mb-4">
                <h3 class="font-bold text-accent mb-2 flex items-center gap-2">
                    <i class="fas fa-list-check"></i>
                    Panduan Format Excel:
                </h3>
                <ul class="text-sm text-gray-700 space-y-1">
                    <li><i class="fas fa-file text-accent mr-2 w-4"></i>File .xlsx atau .csv</li>
                    <li><i class="fas fa-columns text-accent mr-2 w-4"></i>Kolom: <strong>name</strong>, <strong>nim</strong></li>
                    <li><i class="fas fa-table text-accent mr-2 w-4"></i>Contoh: <code>John Doe | 09011282328001</code></li>
                    <li><i class="fas fa-key text-accent mr-2 w-4"></i>Password default: <strong>spark123</strong></li>
                    <li><i class="fas fa-layer-group text-accent mr-2 w-4"></i>Masuk ke kelompok yang dipilih</li>
                </ul>
            </div>
            
            <!-- Tips -->
            <div class="bg-amber-50 border border-amber-200 rounded-xl p-4 mb-6">
                <p class="text-sm text-amber-700 flex items-start gap-2">
                    <i class="fas fa-lightbulb text-amber-500 mt-0.5"></i>
                    <span><strong>Tips:</strong> Pastikan tidak ada NIM yang duplikat dengan data yang sudah ada. Jika ada duplikat, data akan dilewati.</span>
                </p>
            </div>
            
            <form action="{{ route('mentor.students.import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div class="mb-4">
                    <label for="group_id" class="block text-sm font-medium text-gray-700 mb-1">
                        <i class="fas fa-layer-group text-accent mr-1"></i>
                        Pilih Kelompok *
                    </label>
                    <select name="group_id" id="group_id" 
                            class="w-full border border-gray-200 rounded-lg px-4 py-2.5 focus:border-primary focus:ring-1 focus:ring-primary outline-none transition"
                            required>
                        <option value="">-- Pilih Kelompok --</option>
                        @foreach($groups as $group)
                            <option value="{{ $group->id }}">{{ $group->name }} ({{ $group->code }})</option>
                        @endforeach
                    </select>
                </div>
                
                <div class="mb-4">
                    <label for="file" class="block text-sm font-medium text-gray-700 mb-1">
                        <i class="fas fa-file-excel text-accent mr-1"></i>
                        File Excel *
                    </label>
                    <div class="relative">
                        <input type="file" name="file" id="file" accept=".xlsx,.csv,.xls"
                               class="w-full border border-gray-200 rounded-lg px-4 py-2.5 focus:border-primary focus:ring-1 focus:ring-primary outline-none transition file:mr-4 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-primary/10 file:text-primary hover:file:bg-primary/20"
                               required>
                    </div>
                    <p class="text-xs text-gray-400 mt-1"><i class="fas fa-info-circle mr-1"></i>Maksimal 2MB</p>
                </div>
                
                <div class="flex justify-end gap-3 mt-6">
                    <a href="{{ route('mentor.students.index') }}" 
                       class="btn-spark btn-spark-ghost">
                        Batal
                    </a>
                    <button type="submit" class="btn-spark" 
                            style="background-color: #008CA9; hover:background-color: #006f86; color: white;">
                        <i class="fas fa-upload"></i>
                        Upload & Import
                    </button>
                </div>
            </form>
            
            <div class="mt-6 text-center">
                <a href="#" class="text-primary text-sm hover:underline inline-flex items-center gap-1">
                    <i class="fas fa-download"></i>
                    Download Template Excel
                </a>
            </div>
            
        </div>
    </div>
    
</div>
@endsection