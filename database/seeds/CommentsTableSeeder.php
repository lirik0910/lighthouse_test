<?php

use Illuminate\Database\Seeder;
Use Illuminate\Support\Str;

class CommentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $posts = App\Post::all();

        foreach ($posts as $post){
            App\Comment::create([
                'post_id' => $post->id,
                'user_id' => 1,
                'reply' => Str::random(10),
                'body' => Str::random(30)
            ]);
        }
    }
}
