@extends('layouts.app')
@section('title', 'Classes')
@section('content')
<div class="flex justify-end mb-6">
    <a href="{{ route('classes.create') }}" class="btn-primary">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
        Add Class
    </a>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-5">
    @forelse($classes as $class)
        <div class="card-hover card-body">
            <div class="flex justify-between items-start mb-4">
                <div class="w-12 h-12 rounded-2xl bg-violet-50 text-violet-600 flex items-center justify-center text-xl ring-1 ring-violet-100">🏛️</div>
                <span class="badge-neutral">{{ $class->sections_count }} sections</span>
            </div>
            <h3 class="font-bold text-lg text-slate-900">{{ $class->name }}</h3>
            <p class="text-xs text-slate-400 font-mono mt-0.5">{{ $class->code }}</p>
            <p class="text-sm text-slate-500 mt-3 flex items-center gap-1.5">
                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                {{ $class->students_count }} students
            </p>
            <div class="flex gap-2 mt-5 pt-4 border-t border-slate-100">
                <a href="{{ route('classes.show', $class) }}" class="btn-ghost text-xs flex-1 justify-center">View</a>
                <a href="{{ route('classes.edit', $class) }}" class="btn-ghost text-xs flex-1 justify-center">Edit</a>
                @if($class->students_count === 0)
                    <form method="POST" action="{{ route('classes.destroy', $class) }}" class="flex-1" onsubmit="return confirm('Delete {{ $class->name }}?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn-ghost text-xs text-red-600 w-full justify-center">Delete</button>
                    </form>
                @endif
            </div>
        </div>
    @empty
        <div class="col-span-full card card-body empty-state">No classes yet. Create your first class!</div>
    @endforelse
</div>
@endsection
