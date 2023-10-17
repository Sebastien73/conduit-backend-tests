<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{

    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        //\App\Models\User::factory(10)->create();

        //Creation de l'utilisateur rose
        $rose = User::create(
            [
                'username' => "Rose",
                'email' => "rose@gmail.com",
                'password' => bcrypt('pwd'),
                'image' => null,
                'bio' => "Je voudrais devenir enseignante pour enfants",
                'created_at' => now()
            ]
        );

        //Création de l'utilisateur musonda
        $musonda = User::create(
            [
                'username' => "Musonda",
                'email' => "musonda@gmail.com",
                'password' => bcrypt('pwd2'),
                'image' => null,
                'bio' => "Je songe àdevenir infirmière, j’écris mes réflexions",
                'created_at' => now()
            ]
        );

        //Musonda follow Rose et Rose follow musonda
        $musonda->following()->attach($rose);
        $rose->following()->attach($musonda);

        //Création d'un article attaché à rose
        $article_rose = Article::create(
            [
                'user_id' => $rose->id,
                'title' => 'Coucou Musonda',
                'slug' => 'Coucou Musonda',
                'description' => 'Article of Rose',
                'body' => 'Article of Rose',
                'created_at' => now(),
                'updated_at' => now()
            ]
        );

        //Article de rose follow par musonda
        $article_rose->users()->attach($musonda);

        //Création de deux articles attachés à musonda
        $article_mus1 = Article::create(
            [
                'user_id' => $musonda->id,
                'title' => 'Coucou Rose1',
                'slug' => 'Coucou Rose1',
                'description' => 'Article 1 of Musonda',
                'body' => 'Article 1 of Musonda',
                'created_at' => now(),
                'updated_at' => now()
            ]
        );

        $article_mus2 = Article::create(
            [
                'user_id' => $musonda->id,
                'title' => 'Coucou Rose2',
                'slug' => 'Coucou Rose2',
                'description' => 'Article 2 of Musonda',
                'body' => 'Article 2 of Musonda',
                'created_at' => now(),
                'updated_at' => now()
            ]
        );

        // Follow de Rose sur les deux articles de Musonda
        $article_mus1->users()->attach($rose);
        $article_mus2->users()->attach($rose);

        //Création d'un tag éducation
        $education_tag = Tag::create(
            [
              'name' => 'éducation'
            ]
        );

        // Ajout d'un Tag sur l'article de rose
        $article_rose->tags()->attach($education_tag);

        // Ajout d'un commentaire sur l'article de Rose par Musonda
        $article_rose->comments()->create(
            [
                'user_id' => $musonda->id,
                'article_id' => $article_rose->id,
                'body' => "J'adore ta manière de concevoir l'éducation des enfants !",
                'created_at' => now(),
                'updated_at' => now()
            ]
        );
    }
}
