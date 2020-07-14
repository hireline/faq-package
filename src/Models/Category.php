<?php

namespace JaopMX\FaqPackage\Models;

use JaopMX\FaqPackage\Models\Post;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
	protected $table = 'faq_categories';
	protected $fillable = ['name', 'slug', 'description'];

	public function posts()
    {
        return $this->belongsToMany(Post::class, 'faq_category_post');
    }

    public function getActivePostsAttribute()
    {
        $q = $this->posts()->where('active', 1);
        if(session()->has('faq-role')){
            $q->where('roles', 'like', '%'.session()->get('faq-role').'%');
        }
        return $q->count();
    }

    public function getTotalPostAttribute()
    {
        return $this->posts()->count();
    }
}