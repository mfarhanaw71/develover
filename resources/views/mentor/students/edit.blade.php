@extends('layouts.app')

@section('title', 'Edit Mahasiswa - SPARK')

@section('content')
<div class="py-8 px-4 sm:px-6 lg:px-8 max-w-2xl mx-auto">
    
    <div class="card-spark">
        <div class="card-spark-header flex items-center justify-between">
            <h1 class="text-xl font-bold text-gray-900">
                <i class="fas fa-user-edit text-amber-600 mr-2"></i>
                Edit Mahasiswa
            </h1>
            <a href="{{ route('mentor.students.index') }}" 
               class="text-gray-500 hover:text-gray-700 transition">
                <i class="fas fa-arrow-left mr-1"></i>
                Kembali
            </a>
        </div>
        
        <div class="card-spark-body">
            <form action="{{ route('mentor.students.update', $student->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">
                        <i class="fas fa-user text-primary mr-1"></i>
                        Nama Lengkap *
                    </label>
                    <input type="text" name="name" id="name" value="{{ old('name', $student->name) }}" 
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
                    <input type="text" name="nim" id="nim" value="{{ old('nim', $student->nim) }}" 
                           class="w-full border border-gray-200 rounded-lg px-4 py-2.5 focus:border-primary focus:ring-1 focus:ring-primary outline-none transition @error('nim') border-red-500 @enderror"
                           required>
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
                            <option value="{{ $group->id }}" {{ old('group_id', $student->group_id) == $group->id ? 'selected' : '' }}>
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
                        Password (kosongkan jika tidak diubah)
                    </label>
                    <input type="password" name="password" id="password" 
                           class="w-full border border-gray-200 rounded-lg px-4 py-2.5 focus:border-primary focus:ring-1 focus:ring-primary outline-none transition">
                </div>
                
                <div class="mb-4">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="is_active" value="1" {{ $student->is_active ? 'checked' : '' }}
                               class="rounded border-gray-300 text-primary focus:ring-primary focus:ring-1">
                        <span class="text-sm text-gray-700">
                            <i class="fas fa-check-circle text-green-500 mr-1"></i>
                            Aktifkan akun ini
                        </span>
                    </label>
                </div>
                
                <div class="flex justify-end gap-3 mt-6">
                    <a href="{{ route('mentor.students.index') }}" 
                       class="btn-spark btn-spark-ghost">
                        Batal
                    </a>
                    <button type="submit" class="btn-spark" 
                            style="background-color: #D97706; hover:background-color: #B45309; color: white;">
                        <i class="fas fa-save"></i>
                        Update Mahasiswa
                    </button>
                </div>
            </form>
        </div>
    </div>
    
</div>
@endsection