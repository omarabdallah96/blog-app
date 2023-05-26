<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\BlogPost;
use App\Models\User;

class GetPostsTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test the creation of a blog post.
     *
     * @return void
     */
    public function testCreateBlogPost()
    {
        $user = User::factory()->create();

        $blogPost = BlogPost::factory()->create(
            [

                'author_id' => $user->id
            ]
        );

        $response = $this->get('/api/posts/' . $blogPost->id);

        $response->assertStatus(200)
            ->assertSeeText('' . $blogPost->title);
    }
    public function testGetBlogPost()
    {
        $user = User::factory()->create();

        $blogPost = BlogPost::factory(20)->create([
            'author_id' => $user->id
        ]);


        $response = $this->get('/api/posts');

        $response->assertStatus(200)
            ->assertJson([
                'data' => [],
            ]);
    }
}
