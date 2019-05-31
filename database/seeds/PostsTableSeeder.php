<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        for ($k = 0; $k < 10; $k++){
            App\Post::create([
                'user_id' => 1,
                'title' => Str::random(10),
                'content' => Str::random(200),
            ]);
        }
    }
}
