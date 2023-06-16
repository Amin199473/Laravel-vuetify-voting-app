<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Idea;
use App\Models\User;
use App\Models\Vote;
use App\Models\Status;
use App\Models\Comment;
use App\Models\Category;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Amin',
            'email' => 'darkknight199473@gmail.com',
        ]);

        User::factory(19)->create();
        Status::factory()->create([
            'name' => 'Open',
            'color' => 'blue',
        ]);
        Status::factory()->create([
            'name' => 'Considering',
            'color' => 'purple',
        ]);
        Status::factory()->create([
            'name' => 'In Progress',
            'color' => 'orange',
        ]);
        Status::factory()->create([
            'name' => 'Implemented',
            'color' => 'green',
        ]);
        Status::factory()->create([
            'name' => 'Closed',
            'color' => 'red',
        ]);
        Category::factory()->create(['name' => 'category 1']);
        Category::factory()->create(['name' => 'category 2']);
        Category::factory()->create(['name' => 'category 3']);
        Category::factory()->create(['name' => 'category 4']);
        Category::factory()->create(['name' => 'category 5']);
        Idea::factory(100)->create();

        //generate unique vote . Ensure idea_id and User_ida are unique for each row
        foreach (range(1, 20) as $user_id) {
            foreach (range(1, 100) as $idea_id) {
                if ($idea_id % 2 === 0) {
                    Vote::factory()->create([
                        'user_id' => $user_id,
                        'idea_id' => $idea_id,
                    ]);
                }
            }
        }

        //generate comments for idea
        Comment::factory(500)->create();

    }
}
