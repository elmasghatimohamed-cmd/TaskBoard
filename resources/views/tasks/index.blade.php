@extends('layouts.app')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-semibold text-gray-800">Liste des tâches</h2>
        <a href="{{ route('tasks.create') }}"
            class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg transition shadow-md">
            + Nouvelle Tâche
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($tasks as $task)
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition">
                <div class="flex justify-between items-start mb-4">
                    <span
                        class="px-2 py-1 text-xs font-semibold rounded-full 
                                {{ $task->priority == 'high' ? 'bg-red-100 text-red-700' : ($task->priority == 'medium' ? 'bg-yellow-100 text-yellow-700' : 'bg-green-100 text-green-700') }}">
                        {{ strtoupper($task->priority) }}
                    </span>
                    <div class="flex space-x-2">
                        <a href="{{ route('tasks.edit', $task) }}" class="text-blue-500 hover:text-blue-700"><i
                                class="fas fa-edit"></i></a>
                        <form action="{{ route('tasks.destroy', $task) }}" method="POST"
                            onsubmit="return confirm('Archiver cette tâche ?')">
                            @csrf @method('DELETE')
                            <button class="text-gray-400 hover:text-red-500"><i class="fas fa-archive"></i></button>
                        </form>
                    </div>
                </div>

                <h3 class="text-lg font-bold text-gray-900 mb-2">{{ $task->title }}</h3>
                <p class="text-gray-600 text-sm mb-4 line-clamp-2">{{ $task->description }}</p>

                <div class="flex items-center justify-between mt-4 pt-4 border-t border-gray-50 text-xs text-gray-500">
                    <div class="flex items-center">
                        <i class="far fa-calendar-alt mr-2"></i>
                        {{ \Carbon\Carbon::parse($task->deadline)->format('d M, Y') }}
                    </div>
                    <span class="font-medium text-indigo-600">{{ str_replace('_', ' ', $task->status) }}</span>
                </div>
            </div>
        @endforeach
    </div>
@endsection