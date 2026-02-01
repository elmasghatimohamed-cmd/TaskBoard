<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Task;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */

    public function run(): void
    {
        // Au lieu de Task::factory()->create();
        Task::create([
            'title' => 'Ma première tâche de test',
            'description' => 'Description de test',
            'priority' => 'high',
            'status' => 'todo',
            'user_id' => 1,
            'deadline' => now()->addDays(5),
        ]);
    }
}
