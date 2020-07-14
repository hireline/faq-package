<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use JaopMX\FaqPackage\Models\Post;
use JaopMX\FaqPackage\Models\Category;
use JaopMX\FaqPackage\Tests\User;
use JaopMX\FaqPackage\Tests\TestCase;

class CategoryTest extends TestCase
{
    use WithoutMiddleware;

	/**
	* @test
	*/
	public function it_test_that_i_can_create_a_category()
	{
        $user = factory(User::class)->create();

		$this->actingAs($user)
            ->visit('faq/categories')
			->click('#add-collection')
			->see('Nueva categoría')
			->type('TestCategory', '#name')
			->type('Description test', '#description')
			->press('Guardar');

		$this->seeInDatabase('faq_categories', [
			'name' => 'TestCategory',
            'description' => 'Description test'
		]);
	} 

	/**
     * @test
     */
    public function it_tests_i_can_edit_a_category()
    {
        $user = factory(User::class)->create();
        $category = factory(Category::class)->create();

        $this->actingAs($user)
            ->visit('faq/categories')
            ->click('#edit-category-'.$category->id)
            ->see('Editando categoría')
            ->type($category->id, '#category_id')
            ->type('Nuevo titulo', '#name')
            ->type('Nueva descripcion', '#description')
            ->press('Editar');
            
        $this->seeInDatabase('faq_categories', [
            'name' => 'Nuevo titulo',
            'slug' => Str::slug('Nuevo titulo'),
            'description' => 'Nueva descripcion'
        ]);
    }

    /**
     * @test
     */
    public function it_tests_i_can_list_all_my_categories_and_go_to_one_of_my_posts()
    {
        $category = factory(Category::class)->create();
        $post = factory(Post::class)->create(['roles' => 'recruiter']);
        $post->categories()->attach($category->id);
        session()->put('faq-role', 'recruiter');

        $this->visit('faq')
            ->see($category->name)
            ->click('#show-category-'.$category->id)
            ->see($post->title)
            ->click('show-post-'.$post->id)
            ->see($post->body);
    }
}