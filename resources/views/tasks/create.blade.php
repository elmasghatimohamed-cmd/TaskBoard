@extends('layouts.app')

@section('content')
    <div class="max-w-2xl mx-auto bg-white rounded-2xl shadow-sm p-8 border border-gray-100">
        <h2 class="text-2xl font-bold text-gray-800 mb-6 text-center">Créer une nouvelle tâche</h2>

        <form action="{{ route('tasks.store') }}" method="POST">
            @csrf
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Titre</label>
                    <input type="text" name="title" value="{{ old('title') }}"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-2 border">
                    @error('title', 'taskCreation') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Priorité</label>
                        <select name="priority" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm border p-2">
                            <option value="low">Faible</option>
                            <option value="medium">Moyenne</option>
                            <option value="high">Haute</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Date limite</label>
                        <input type="date" name="deadline"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm border p-2">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Statut</label>
                    <select name="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm border p-2">
                        <option value="todo">À faire</option>
                        <option value="in_progress">En cours</option>
                        <option value="done">Terminé</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Description</label>
                    <textarea name="description" rows="4"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm border p-2"></textarea>
                </div>

                <div class="flex justify-end space-x-3 pt-6">
                    <a href="{{ route('tasks.index') }}"
                        class="px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-100 rounded-md">Annuler</a>
                    <button type="submit"
                        class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 rounded-md shadow-sm">
                        Enregistrer la tâche
                    </button>
                </div>
            </div>
        </form>
    </div>
@endsection