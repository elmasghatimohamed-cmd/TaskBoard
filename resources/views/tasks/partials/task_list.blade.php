@php
    $statuses = [
        'todo' => ['label' => 'À FAIRE', 'color' => 'bg-gray-100'],
        'in_progress' => ['label' => 'EN COURS', 'color' => 'bg-blue-50'],
        'done' => ['label' => 'TERMINÉ', 'color' => 'bg-green-50']
    ];
@endphp

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    @foreach($statuses as $key => $info)
        <div class="rounded-xl p-4 {{ $info['color'] }}">
            <h2 class="font-bold text-gray-700 mb-4 flex items-center justify-between">
                {{ $info['label'] }}
                <span class="bg-white px-2 py-0.5 rounded text-xs shadow-sm">
                    {{ $tasks->where('status', $key)->count() }}
                </span>
            </h2>

            <div class="space-y-4">
                @forelse($tasks->where('status', $key) as $task)
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4 hover:shadow-md transition">
                        <div class="flex justify-between items-start mb-2">
                            <span
                                class="px-2 py-0.5 text-[10px] font-bold rounded-full 
                                                {{ $task->priority == 'high' ? 'bg-red-100 text-red-700' : ($task->priority == 'medium' ? 'bg-yellow-100 text-yellow-700' : 'bg-green-100 text-green-700') }}">
                                {{ strtoupper($task->priority) }}
                            </span>
                        </div>
                        <h3 class="font-semibold text-gray-900 text-sm mb-1">{{ $task->title }}</h3>
                        <p class="text-gray-500 text-xs line-clamp-2 mb-3">{{ $task->description }}</p>

                        <div class="flex justify-between items-center pt-3 border-t border-gray-50">
                            <span class="text-[10px] text-gray-400">
                                <i class="far fa-calendar-alt"></i> {{ \Carbon\Carbon::parse($task->deadline)->format('d/m') }}
                            </span>
                            <div class="flex space-x-2">
                                <a href="{{ route('tasks.edit', $task) }}" class="text-blue-400 hover:text-blue-600"><i
                                        class="fas fa-edit"></i></a>
                                <form action="{{ route('tasks.destroy', $task) }}" method="POST">
                                    @csrf @method('DELETE')
                                    <button class="text-gray-300 hover:text-red-500"><i class="fas fa-trash"></i></button>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="text-center text-gray-400 text-xs py-4 italic">Aucune tâche</p>
                @endforelse
            </div>
        </div>
    @endforeach
</div>