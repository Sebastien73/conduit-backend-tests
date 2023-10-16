<?php

namespace Tests\Unit;

use App\Models\Article;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    protected $seed = true;

    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
    }

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_example()
    {
        $this->assertTrue(true);
    }

    public function test_getRouteKeyName()
    {
        $this->assertEquals('username', User::make()->getRouteKeyName());
    }

    public function test_articles()
    {
        $rose = User::find(1);
        // Méthod pluck -> prends tout les éléments d'un tableau et garde seulement les attributs que l'on aura demandé.

        $this->assertEquals(
            Article::where('user_id', $rose->id)->get()->pluck(['id', 'title', 'slug', 'description']),
            $rose->articles->pluck(['id', 'title', 'slug', 'description'])
        );
    }

    public function test_favouriteArticles()
    {
        //Where has = filtre au niveau des relations du modèle (côté bdd)
        // Filter on model Article with relationship user
        // In builder query, search with where clause (column id of user table, id of user specific
        // Don't forgot ->get() to keep result of query
        // Don't forgot ->pluck after ->get() for take all elements of array and keep only attribute specific
        // Here, test all articles where has relationship with user musonda
        $musonda = User::find(2);

        $this->assertEquals(
            Article::whereHas('users', function (Builder $query) use($musonda){
                $query->where('id', $musonda->id);
            })->get()->pluck(['id', 'title', 'slug', 'description']),
            $musonda->favoritedArticles->pluck(['id', 'title', 'slug', 'description'])
        );
    }

    public function test_followers()
    {
        $rose = User::find(1);

        $this->assertEquals(
            User::whereHas('following', function (Builder $query) use($rose){
                $query->where('following_id', $rose->id);
            })->get()->pluck(['username','email','bio']),
            $rose->followers->pluck(['username','email','bio'])
        );
    }

    public function test_following()
    {
        $rose = User::find(1);

        $this->assertEquals(
            User::whereHas('followers', function (Builder $query) use($rose){
                $query->where('follower_id', $rose->id);
            })->get()->pluck(['username','email','bio']),
            $rose->followers->pluck(['username','email','bio'])
        );
    }

    public function test_doesUserFollowAnotherUser()
    {
        $rose = User::find(1);
        $musonda = User::find(2);

        $this->assertTrue($rose->doesUserFollowAnotherUser($rose->id, $musonda->id));
        $this->assertFalse($rose->doesUserFollowAnotherUser($rose->id,4));
    }

}
