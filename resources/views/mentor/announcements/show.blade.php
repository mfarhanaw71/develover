@extends('layouts.app')

@section('title', $announcement->title . ' - SPARK')

@section('content')
<div class="py-8 px-4 sm:px-6 lg:px-8 max-w-4xl mx-auto">
    
    <div class="card-spark">
        <div class="card-spark-body">
            
            <div class="flex items-center justify-between mb-4">
                <a href="{{ route('mentor.announcements.index') }}" 
                   class="text-gray-500 hover:text-gray-700 transition inline-flex items-center gap-1">
                    <i class="fas fa-arrow-left"></i>
                    Kembali
                </a>
                <div class="flex items-center gap-2">
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
            
            <div class="border-b border-gray-100 pb-4 mb-4">
                <h1 class="text-2xl font-bold text-gray-900">{{ $announcement->title }}</h1>
                <div class="flex flex-wrap items-center gap-4 mt-2 text-sm text-gray-500">
                    <span class="inline-flex items-center gap-1">
                        <i class="fas fa-layer-group text-accent"></i>
                        <strong>{{ $announcement->group->name }}</strong>
                    </span>
                    <span class="inline-flex items-center gap-1">
                        <i class="fas fa-user text-primary"></i>
                        <strong>{{ $announcement->creator->name }}</strong>
                    </span>
                    <span class="inline-flex items-center gap-1">
                        <i class="far fa-calendar-alt"></i>
                        {{ $announcement->created_at->format('d F Y, H:i') }}
                    </span>
                </div>
            </div>
            
            <div class="prose max-w-none">
                <div class="whitespace-pre-line text-gray-700 leading-relaxed">
                    {{ $announcement->content }}
                </div>
            </div>
            
            <div class="mt-6 pt-4 border-t border-gray-100 text-sm text-gray-400">
                <p><i class="far fa-clock mr-1"></i>Terakhir diperbarui: {{ $announcement->updated_at->diffForHumans() }}</p>
            </div>
            
        </div>
    </div>
    
</div>
@endsection