<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Article;

class ArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $articles = json_decode(file_get_contents(public_path().'/articles.json'), true);

        foreach($articles as $article){
            $newArticle = new Article();
            $newArticle->fill($article);
            $newArticle->save();
        }
    }
}