<?php

namespace Tests\Unit;

use App\Models\Article;
use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
class UserTest extends TestCase
{
    use RefreshDatabase;
    protected $seed = true;
    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name,$data,$dataName);
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
        $this->assertEquals('username',User::make()->getRouteKeyName());
    }

    public function test_articles()
    {
        $rose = User::find(1);
        $this->assertEquals($rose->id, $rose->articles->count());

        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $rose->articles);
    }
    //public function test_favouriteArticles(){}
    //public function test_followers(){}
    //public function test_following(){}
    //public function test_doesUserFollowAnotherUser(){}

}
