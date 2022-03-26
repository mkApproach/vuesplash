<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
/*
use Illuminate\Database\Eloquent\Factory;
*/

class LogoutApiTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        // テストユーザー作成
        $this->user = User::factory()->create();
    }
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_should_認証済みのユーザーをログアウトさせる()
    {
        $response = $this->actingAs($this->user)
                         ->json('POST', route('logout'));

        $response->assertStatus(200);
        $this->assertGuest();
    }
}
