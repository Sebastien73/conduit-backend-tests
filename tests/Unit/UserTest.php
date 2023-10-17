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
        $musonda = User::find(2);

        $this->assertEquals(
            Article::where('user_id', $musonda->id)->select(['id', 'title', 'slug', 'description'])->get()->map->only(['id', 'title', 'slug', 'description']),
            $musonda->articles->map->only(['id', 'title', 'slug', 'description'])
        );

        $this->assertGreaterThanOrEqual(2,count($musonda->articles));
    }

    public function test_favouriteArticles()
    {
        //Where has = filtre au niveau des relations du modèle (côté bdd)
        // Filter on model Article with relationship user
        // In builder query, search with where clause (column id of user table, id of user specific
        // Don't forgot ->select() with array of column's name what you need (set select after where())
        // Don't forgot ->get() to keep result of query after select()
        // For keep only columns you need, set map->only after get()
        // Don't forgot to repeat the same array that select method

        // If you need to compared values the pluck method is good.
        // The pluck method don't take an array in parameter but a key, a value
        // Don't forgot ->pluck after ->get() for take all elements of array and keep only attribute specific
        // Here, test all articles where has relationship with user musonda
        $musonda = User::find(2);
        $this->assertEquals(
            Article::whereHas('users', function (Builder $query) use($musonda){
                $query->where('id', $musonda->id);
            })->select(['id', 'title', 'slug', 'description'])->get()->map->only(['id', 'title', 'slug', 'description']),
            $musonda->favoritedArticles->map->only(['id', 'title', 'slug', 'description'])
        );
    }

    public function test_followers()
    {
        $rose = User::find(1);
        $this->assertEquals(
            User::whereHas('following', function (Builder $query) use($rose){
                $query->where('following_id', $rose->id);
            })->select(['id','username','email', 'bio'])->get()->map->only(['id','username','email', 'bio']),
            $rose->followers->map->only(['id','username','email', 'bio'])
        );
    }

    public function test_following()
    {
        $rose = User::find(1);

        $this->assertEquals(
            User::whereHas('followers', function (Builder $query) use($rose){
                $query->where('follower_id', $rose->id);
            })->select(['id','username','email', 'bio'])->get()->map->only(['id','username','email', 'bio']),
            $rose->following->map->only(['id','username','email', 'bio'])
        );


        $this->assertCount(1,$rose->following);
    }

    public function test_doesUserFollowAnotherUser()
    {
        $rose = User::find(1);
        $musonda = User::find(2);

        $this->assertTrue($rose->doesUserFollowAnotherUser($rose->id, $musonda->id));
        $this->assertFalse($rose->doesUserFollowAnotherUser($rose->id,4));
    }

}
