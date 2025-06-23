<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Article;
use Illuminate\Support\Str;
use Carbon\Carbon;

class ArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    // public function run()
    // {
    //     Article::query()->delete();
    //     $date = Carbon::now();

    //     for ($i = 0; $i < 25; $i++) {
    //         $title = fake()->sentence(6, true);

    //         Article::create([
    //             'title'       => $title,
    //             'slug'        => Str::slug($title),
    //             'author'      => fake()->name(),
    //             'description' => fake()->paragraphs(10, true),

    //             'image'       => 'https://picsum.photos/1280/720?random=' . $i,

    //             'published_at' => $date->toDateTimeString(),
    //         ]);

    //         $date->subDays(rand(1, 3))->subHours(rand(1, 12));
    //     }
    // }
}
