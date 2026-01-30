@extends('layouts.app')

@section('content')
        <div class="mb-8">
            <h2 class="text-3xl font-bold text-gray-800">Tableau de bord</h2>
            <p class="text-gray-500">Aperçu en temps réel de votre productivité.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center">
                <div class="p-3 bg-indigo-100 rounded-lg text-indigo-600 mr-4">
                    <i class="fas fa-tasks fa-2x"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-500 font-medium">Total Tâches</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['total'] }}</p>
                </div>
            </div>

            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center">
                <div class="p-3 bg-blue-100 rounded-lg text-blue-600 mr-4">
                    <i class="fas fa-clock fa-lg"></i>

                </div>
                <div>
                    <p class="text-sm text-gray-500 font-medium">En cours</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['in_progress'] }}</p>
                </div>
            </div>

            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center">
                <div class="p-3 bg-green-100 rounded-lg text-green-600 mr-4">
                    <i class="fas fa-check-circle fa-2x"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-500 font-medium">Terminées</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['done'] }}</p>
                </div>
            </div>

            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center">
                <div class="p-3 bg-red-100 rounded-lg text-red-600 mr-4">
                    <i class="fas fa-exclamation-triangle fa-2x"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-500 font-medium">En retard</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['overdue'] }}</p>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-2 bg-white p-8 rounded-2xl shadow-sm border border-gray-100">
                <h3 class="text-lg font-bold text-gray-800 mb-6">Répartition par Priorité</h3>

                <div class="space-y-6">
    @php
        // Plus besoin de requêtes ici, on utilise uniquement le tableau $stats envoyé par le contrôleur
        $priorities = [
            [
                'label' => 'Haute',
                'count' => $stats['high_priority'],
                'color' => 'bg-red-500'
            ],
            [
                'label' => 'Moyenne',
                'count' => $stats['medium_priority'],
                'color' => 'bg-yellow-500'
            ],
            [
                'label' => 'Faible',
                'count' => $stats['low_priority'],
                'color' => 'bg-green-500'
            ]
        ];
    @endphp
    @foreach($priorities as $p)
        <div class="mb-4">
            <div class="flex justify-between mb-2">
                <span class="text-sm font-medium text-gray-700">{{ $p['label'] }}</span>
                <span class="text-sm text-gray-500">{{ $p['count'] }} tâche(s)</span>
            </div>
            <div class="w-full bg-gray-100 rounded-full h-2.5">
                @php 
                    $percentage = $stats['total'] > 0 ? ($p['count'] / $stats['total']) * 100 : 0; 
                @endphp
                <div class="{{ $p['color'] }} h-2.5 rounded-full transition-all duration-500"
                     style="width: {{ $percentage }}%"></div>
            </div>
        </div>
    @endforeach
                </div>
            </div>

            <div class="bg-gradient-to-br from-indigo-600 to-purple-700 p-8 rounded-2xl shadow-lg text-white">
                <h3 class="text-xl font-bold mb-4">Actions Rapides</h3>
                <p class="text-indigo-100 mb-6 text-sm">Organisez votre journée en quelques clics.</p>

                <div class="flex flex-col space-y-3">
                    <a href="{{ route('tasks.create') }}"
                        class="bg-white text-indigo-600 text-center py-3 rounded-xl font-bold hover:bg-indigo-50 transition">
                        + Ajouter une tâche
                    </a>
                    <a href="{{ route('tasks.index') }}"
                        class="bg-indigo-500/30 border border-indigo-400 text-white text-center py-3 rounded-xl font-bold hover:bg-indigo-500/50 transition">
                        Voir tout le listing
                    </a>
                    <a href="{{ route('tasks.archived') }}" class="text-indigo-200 text-center text-sm hover:text-white py-2">
                        Consulter les archives
                    </a>
                </div>
            </div>
        </div>
@endsection