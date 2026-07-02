@extends('layouts.app')

@section('title', 'Edit Pengumuman - SPARK')

@section('content')
<div class="py-8 px-4 sm:px-6 lg:px-8 max-w-3xl mx-auto">
    
    <div class="card-spark">
        <div class="card-spark-header flex items-center justify-between">
            <h1 class="text-xl font-bold text-gray-900">
                <i class="fas fa-pen text-amber-600 mr-2"></i>
                Edit Pengumuman
            </h1>
            <a href="{{ route('mentor.announcements.index') }}" 
               class="text-gray-500 hover:text-gray-700 transition">
                <i class="fas fa-arrow-left mr-1"></i>
                Kembali
            </a>
        </div>
        
        <div class="card-spark-body">
            <form action="{{ route('mentor.announcements.update', $announcement->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="mb-4">
                    <label for="title" class="block text-sm font-medium text-gray-700 mb-1">
                        <i class="fas fa-heading text-primary mr-1"></i>
                        Judul Pengumuman *
                    </label>
                    <input type="text" name="title" id="title" value="{{ old('title', $announcement->title) }}" 
                           class="w-full border border-gray-200 rounded-lg px-4 py-2.5 focus:border-primary focus:ring-1 focus:ring-primary outline-none transition @error('title') border-red-500 @enderror"
                           required>
                    @error('title')
                        <p class="text-red-500 text-sm mt-1"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="mb-4">
                    <label for="group_id" class="block text-sm font-medium text-gray-700 mb-1">
                        <i class="fas fa-layer-group text-accent mr-1"></i>
                        Kelompok Tujuan *
                    </label>
                    <select name="group_id" id="group_id" 
                            class="w-full border border-gray-200 rounded-lg px-4 py-2.5 focus:border-primary focus:ring-1 focus:ring-primary outline-none transition @error('group_id') border-red-500 @enderror"
                            required>
                        <option value="">Pilih Kelompok</option>
                        @foreach($groups as $group)
                            <option value="{{ $group->id }}" {{ old('group_id', $announcement->group_id) == $group->id ? 'selected' : '' }}>
                                {{ $group->name }} ({{ $group->code }})
                            </option>
                        @endforeach
                    </select>
                    @error('group_id')
                        <p class="text-red-500 text-sm mt-1"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="mb-4">
                    <label for="content" class="block text-sm font-medium text-gray-700 mb-1">
                        <i class="fas fa-align-left text-primary mr-1"></i>
                        Isi Pengumuman *
                    </label>
                    <textarea name="content" id="content" rows="6" 
                              class="w-full border border-gray-200 rounded-lg px-4 py-2.5 focus:border-primary focus:ring-1 focus:ring-primary outline-none transition @error('content') border-red-500 @enderror"
                              required>{{ old('content', $announcement->content) }}</textarea>
                    @error('content')
                        <p class="text-red-500 text-sm mt-1"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="flex justify-end gap-3 mt-6">
                    <a href="{{ route('mentor.announcements.index') }}" 
                       class="btn-spark btn-spark-ghost">
                        Batal
                    </a>
                    <button type="submit" class="btn-spark" 
                            style="background-color: #D97706; hover:background-color: #B45309; color: white;">
                        <i class="fas fa-save"></i>
                        Update Pengumuman
                    </button>
                </div>
            </form>
        </div>
    </div>
    
</div>
@endsection