<?php

use JaopMX\FaqPackage\Models\Category;
use JaopMX\FaqPackage\Models\Post;
use JaopMX\FaqPackage\Tests\User;
use JaopMX\FaqPackage\Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class PostTest extends TestCase
{
    use RefreshDatabase, WithoutMiddleware;

    /**
     * @test
     */
    public function it_tests_i_can_create_a_post()
    {
        $category = factory(Category::class)->create();
        $user = factory(User::class)->create();

        $this->actingAs($user)
            ->visit('faq/posts/create')
            ->see('Creando post')
            ->type('Testing post', 'title')
            ->select($category->id, 'category')
            ->type('Test text from post', 'body')
            ->select(['candidate', 'recruiter'], 'roles')
            ->press('Guardar');

        $this->seeInDatabase('faq_posts', [
            'title' => 'Testing post',
            'body' => 'Test text from post',
            'roles' => '["candidate","recruiter"]'
        ]);

        $this->seeInDatabase('faq_category_post', [
            'category_id' => $category->id,
        ]);
    }

    /**
     * @test
     */
    public function it_tests_i_can_edit_a_post()
    {
        $user = factory(User::class)->create();
        $category = factory(Category::class)->create();
        $category2 = factory(Category::class)->create();
        $post = createPost($user, $category->id);

        $this->actingAs($user)
            ->visit('faq/posts/edit/' . $post->id)
            ->see('Editando post')
            ->type('Nuevo titulo', 'title')
            ->select($category2->id, 'category')
            ->type('Nuevo testo', 'body')
            ->press('Guardar');

        $this->seeInDatabase('faq_posts', [
            'title' => 'Nuevo titulo',
            'body' => 'Nuevo testo'
        ]);

        $this->seeInDatabase('faq_category_post', [
            'category_id' => $category2->id,
        ]);
    }

    /**
     * @test
     */
    public function it_tests_i_can_deactivate_a_post()
    {
        $user = factory(User::class)->create();
        $category = factory(Category::class)->create();
        $post = createPost($user, $category->id);

        $this->actingAs($user)
            ->visit('faq/posts')
            ->see($post->title)
            ->click('deactivate-post-' . $post->id);

        $this->seeInDatabase('faq_posts', [
            'id' => $post->id,
            'active' => 0
        ]);
    }

    /**
     * @test
     */
    public function it_tests_i_can_make_a_search()
    {
        $this->withoutExceptionHandling();
        $category = factory(Category::class)->create();
        $post = factory(Post::class)->create();
        $this->GET('faq/search')->assertResponseOk();
    }

    /**
     * @test
     */
    public function it_tests_i_can_make_a_search_with_partial()
    {
        $this->withoutExceptionHandling();
        $post = factory(Post::class)->create();

        session()->put('faq-role', 'recruiter');

        $this->GET('faq/partials/search')->assertResponseOk();
    }
}