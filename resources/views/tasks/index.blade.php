@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800">Mon Tableau de Bord</h2>
            <a href="{{ route('tasks.create') }}" class="bg-indigo-600 text-white px-4 py-2 rounded-lg text-sm shadow-md">+
                Tâche</a>
        </div>

        <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100 mb-8 flex flex-wrap gap-4 items-center">
            <div class="relative flex-1 min-w-[200px]">
                <input type="text" id="main_search" placeholder="Rechercher..."
                    class="w-full pl-10 pr-4 py-2 rounded-lg border-gray-200 text-sm">
                <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
            </div>
            <select id="filter_priority" class="text-sm border-gray-200 rounded-lg">
                <option value="">Toutes les priorités</option>
                <option value="high">Haute</option>
                <option value="medium">Moyenne</option>
                <option value="low">Faible</option>
            </select>
            <select id="filter_status" class="text-sm border-gray-200 rounded-lg">
                <option value="">Tous les statuts</option>
                <option value="todo">À faire</option>
                <option value="in_progress">En cours</option>
                <option value="done">Terminé</option>
            </select>
        </div>

        <div id="tasks_container">
            @include('tasks.partials.task_list', ['tasks' => $tasks])
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>$(document).ready(function () {
            function fetchTasks() {
                let query = $('#main_search').val();
                let priority = $('#filter_priority').val();
                let status = $('#filter_status').val();

                $.ajax({

                    url: "{{ route('tasks.action') }}",
                    type: "GET",
                    data: {
                        query: query, priority: priority, status: status
                    }

                    ,
                    beforeSend: function () {
                        $('#tasks_container').css('opacity', '0.5'); // Effet de chargement
                    }

                    ,
                    success: function (html) {
                        $('#tasks_container').html(html);
                        $('#tasks_container').css('opacity', '1');
                    }
                });
            }

            $('#main_search').on('keyup', fetchTasks);
            $('#filter_priority, #filter_status').on('change', fetchTasks);
        });
    </script>
@endsection