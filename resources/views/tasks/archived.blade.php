@extends('layouts.app')

@section('content')
    <h2 class="text-2xl font-semibold text-gray-800 mb-6">Coffre-fort (Archives)</h2>

    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Titre</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($tasks as $task)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $task->title }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-3 flex justify-end">
                            <form action="{{ route('tasks.restore', $task->id) }}" method="POST">
                                @csrf @method('PUT')
                                <button class="text-green-600 hover:text-green-900">Restaurer</button>
                            </form>
                            <form action="{{ route('tasks.forceDestroy', $task->id) }}" method="POST"
                                onsubmit="return confirm('Suppression définitive ?')">
                                @csrf @method('DELETE')
                                <button class="text-red-600 hover:text-red-900">Supprimer</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="2" class="px-6 py-10 text-center text-gray-500 italic">Aucune tâche archivée.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection