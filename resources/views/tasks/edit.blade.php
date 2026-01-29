@extends('layouts.app')

@section('content')
    <div class="max-w-2xl mx-auto">
        <a href="{{ route('tasks.index') }}"
            class="text-sm text-indigo-600 hover:text-indigo-800 flex items-center mb-4 transition">
            <i class="fas fa-arrow-left mr-2"></i> Retour à la liste
        </a>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="bg-indigo-50 px-8 py-4 border-b border-indigo-100">
                <h2 class="text-xl font-bold text-indigo-900">Modifier la tâche</h2>
                <p class="text-indigo-600 text-sm">ID de référence : #{{ $task->id }}</p>
            </div>

            <form action="{{ route('tasks.update', $task) }}" method="POST" class="p-8">
                @csrf
                @method('PUT')

                <div class="space-y-6">
                    <div>
                        <label for="title" class="block text-sm font-semibold text-gray-700 mb-1">Titre de la
                            mission</label>
                        <input type="text" name="title" id="title" value="{{ old('title', $task->title) }}"
                            class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 p-2.5 border @error('title', 'taskUpdate') border-red-500 @enderror">
                        @error('title', 'taskUpdate')
                            <p class="text-red-500 text-xs mt-1 flex items-center"><i
                                    class="fas fa-exclamation-circle mr-1"></i> {{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="priority" class="block text-sm font-semibold text-gray-700 mb-1">Niveau de
                                priorité</label>
                            <select name="priority" id="priority"
                                class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 p-2.5 border">
                                <option value="low" {{ old('priority', $task->priority) == 'low' ? 'selected' : '' }}>
                                    Faible</option>
                                <option value="medium" {{ old('priority', $task->priority) == 'medium' ? 'selected' : '' }}>
                                    Moyenne</option>
                                <option value="high" {{ old('priority', $task->priority) == 'high' ? 'selected' : '' }}>
                                    Haute</option>
                            </select>
                        </div>

                        <div>
                            <label for="deadline" class="block text-sm font-semibold text-gray-700 mb-1">Date
                                d'échéance</label>
                            <input type="date" name="deadline" id="deadline"
                                value="{{ old('deadline', $task->deadline instanceof \DateTime ? $task->deadline->format('Y-m-d') : substr($task->deadline, 0, 10)) }}"
                                class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 p-2.5 border">
                        </div>
                    </div>

                    <div>
                        <label for="status" class="block text-sm font-semibold text-gray-700 mb-1">État d'avancement</label>
                        <div class="grid grid-cols-3 gap-3">
                            @foreach(['todo' => 'À faire', 'in_progress' => 'En cours', 'done' => 'Terminé'] as $value => $label)
                                <label class="cursor-pointer">
                                    <input type="radio" name="status" value="{{ $value }}" class="peer hidden" {{ old('status', $task->status) == $value ? 'checked' : '' }}>
                                    <div
                                        class="text-center p-2 rounded-lg border border-gray-200 text-sm font-medium transition peer-checked:bg-indigo-600 peer-checked:text-white peer-checked:border-indigo-600 hover:bg-gray-50">
                                        {{ $label }}
                                    </div>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <div>
                        <label for="description" class="block text-sm font-semibold text-gray-700 mb-1">Description
                            détaillée (optionnel)</label>
                        <textarea name="description" id="description" rows="5"
                            class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 p-2.5 border shadow-inner"
                            placeholder="Précisez les détails de la tâche...">{{ old('description', $task->description) }}</textarea>
                    </div>

                    <div class="flex items-center justify-between pt-6 border-t border-gray-100">
                        <button type="button" onclick="window.history.back()"
                            class="text-gray-500 hover:text-gray-700 font-medium">
                            Annuler
                        </button>
                        <button type="submit"
                            class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2.5 px-6 rounded-lg transition duration-200 transform hover:scale-105 shadow-md">
                            Mettre à jour la tâche
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection