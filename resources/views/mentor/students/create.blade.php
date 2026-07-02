@extends('layouts.app')

@section('title', 'Tambah Mahasiswa - SPARK')

@section('content')
<div class="py-8 px-4 sm:px-6 lg:px-8 max-w-2xl mx-auto">
    
    <div class="card-spark">
        <div class="card-spark-header flex items-center justify-between">
            <h1 class="text-xl font-bold text-gray-900">
                <i class="fas fa-user-plus text-primary mr-2"></i>
                Tambah Mahasiswa Baru
            </h1>
            <a href="{{ route('mentor.students.index') }}" 
               class="text-gray-500 hover:text-gray-700 transition">
                <i class="fas fa-arrow-left mr-1"></i>
                Kembali
            </a>
        </div>
        
        <div class="card-spark-body">
            <form action="{{ route('mentor.students.store') }}" method="POST">
                @csrf
                
                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">
                        <i class="fas fa-user text-primary mr-1"></i>
                        Nama Lengkap *
                    </label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" 
                           class="w-full border border-gray-200 rounded-lg px-4 py-2.5 focus:border-primary focus:ring-1 focus:ring-primary outline-none transition @error('name') border-red-500 @enderror"
                           required>
                    @error('name')
                        <p class="text-red-500 text-sm mt-1"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="mb-4">
                    <label for="nim" class="block text-sm font-medium text-gray-700 mb-1">
                        <i class="fas fa-id-card text-accent mr-1"></i>
                        NIM *
                    </label>
                    <input type="text" name="nim" id="nim" value="{{ old('nim') }}" 
                           placeholder="Contoh: 09011282328001"
                           class="w-full border border-gray-200 rounded-lg px-4 py-2.5 focus:border-primary focus:ring-1 focus:ring-primary outline-none transition @error('nim') border-red-500 @enderror"
                           required>
                    <p class="text-xs text-gray-400 mt-1"><i class="fas fa-info-circle mr-1"></i>NIM digunakan untuk login mahasiswa.</p>
                    @error('nim')
                        <p class="text-red-500 text-sm mt-1"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="mb-4">
                    <label for="group_id" class="block text-sm font-medium text-gray-700 mb-1">
                        <i class="fas fa-layer-group text-accent mr-1"></i>
                        Kelompok *
                    </label>
                    <select name="group_id" id="group_id" 
                            class="w-full border border-gray-200 rounded-lg px-4 py-2.5 focus:border-primary focus:ring-1 focus:ring-primary outline-none transition @error('group_id') border-red-500 @enderror"
                            required>
                        <option value="">Pilih Kelompok</option>
                        @foreach($groups as $group)
                            <option value="{{ $group->id }}" {{ old('group_id') == $group->id ? 'selected' : '' }}>
                                {{ $group->name }} ({{ $group->code }})
                            </option>
                        @endforeach
                    </select>
                    @error('group_id')
                        <p class="text-red-500 text-sm mt-1"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="mb-4">
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">
                        <i class="fas fa-key text-primary mr-1"></i>
                        Password *
                    </label>
                    <input type="password" name="password" id="password" value="spark123"
                           class="w-full border border-gray-200 rounded-lg px-4 py-2.5 focus:border-primary focus:ring-1 focus:ring-primary outline-none transition @error('password') border-red-500 @enderror"
                           required>
                    <p class="text-xs text-gray-400 mt-1"><i class="fas fa-info-circle mr-1"></i>Default: <strong>spark123</strong>. Mahasiswa bisa mengganti nanti.</p>
                    @error('password')
                        <p class="text-red-500 text-sm mt-1"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="flex justify-end gap-3 mt-6">
                    <a href="{{ route('mentor.students.index') }}" 
                       class="btn-spark btn-spark-ghost">
                        Batal
                    </a>
                    <button type="submit" class="btn-spark btn-spark-primary">
                        <i class="fas fa-save"></i>
                        Simpan Mahasiswa
                    </button>
                </div>
            </form>
        </div>
    </div>
    
</div>
@endsection