<!DOCTYPE html>
<html lang="fr">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>TaskManager Pro</title>
		<script src="https://cdn.tailwindcss.com"></script>
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
	</head>
	<body class="bg-gray-50 font-sans">
		<nav class="bg-white shadow-sm border-b">
			<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex justify-between items-center">
				<h1 class="text-xl font-bold text-indigo-600">TaskApp</h1>
				<div class="space-x-4">
					<a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'text-indigo-600 font-semibold' : 'text-gray-600' }} hover:text-indigo-600 transition">
						<i class="fas fa-chart-line mr-1"></i>
						Dashboard
					</a>

					<a href="{{ route('tasks.index') }}" class="text-gray-600 hover:text-indigo-600">Mes Tâches</a>
					<a href="{{ route('tasks.archived') }}" class="text-gray-600 hover:text-indigo-600">Archives</a>
				</div>
			</div>
		</nav>

		<main
			class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
			@if (session('status'))
                <div
                    class="mb-4 p-4 bg-green-100 border-l-4 border-green-500 text-green-700 shadow-sm">{{ session('status') }}
                </div>
            @endif
																		        @yield('content')
		</main>
	</body>
</html>

