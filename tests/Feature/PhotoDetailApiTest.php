<?php

namespace Tests\Feature;

use App\Models\Photo;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Comment;

class PhotoDetailApiTest extends TestCase
{
    use RefreshDatabase;
    /**
     * @test
     */
    public function should_正しい構造のJSONを返却する()
    {
        /*  コメント */
        Photo::factory()->create()->each(function ($photo) {
            $photo->comments()->saveMany(Comment::factory()->count(3)->make());
        });
        $photo = Photo::first();

        $response = $this->json('GET', route('photo.show', [
            'id' => $photo->id,
        ]));

        $response->assertStatus(200)
            ->assertJsonFragment([
                'id' => $photo->id,
                'url' => $photo->url,
                'liked_by_user' => false,
                'likes_count' => 0,
                'owner' => [
                    'name' => $photo->owner->name,
                ],
                'comments' => $photo->comments
                    ->sortByDesc('id')
                    ->map(function ($comment) {
                        return [
                            'author' => [
                                'name' => $comment->author->name,
                            ],
                            'content' => $comment->content,
                        ];
                    })
                    ->all(),
            ]);
    }
    /**
     * A basic feature test example.
     *
     * @return void
     */
     /*  詳細 
    public function test_should_正しい構造のJSONを返却する()
    {
        Photo::factory()->create();
        
        $photo = Photo::first();

        $response = $this->json('GET', route('photo.show', [
            'id' => $photo->id,
        ]));

        $response->assertStatus(200)
            ->assertJsonFragment([
                'id' => $photo->id,
                'url' => $photo->url,
                'owner' => [
                    'name' => $photo->owner->name,
                ],
            ]);

        //$response->dump();
    }
    */
}