<?php

namespace JaopMX\FaqPackage\Models;

use Laravel\Scout\Searchable;
use HTMLPurifier_Config;
use HTMLPurifier;
use JaopMX\FaqPackage\Models\Category;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use Searchable;

    protected $table = 'faq_posts';
    protected $fillable = ['title', 'body', 'active', 'slug', 'roles'];
    protected $casts = ['roles' => 'array'];

    public function searchableAs()
    {
        return config('faq.posts_index', 'faq_posts');
    }

    /**
     * Only models with this conditions are indexed
     *
     */
    public function shouldBeSearchable()
    {
        return $this->active;
    }

    /**
     * Get the indexable data array for the model.
     *
     * @return array
     */
    public function toSearchableArray()
    {
        $array['user_id'] = $this->author_id;
        $array['author'] = $this->author->full_name;
        $array['title'] = $this->title;
        $array['body'] = $this->clear_body;
        $array['active'] = $this->active;
        $array['roles'] = $this->roles;
        $array['url'] = $this->url;

        return $array;
    }

    public function author()
    {
        return $this->morphTo();
    }

    public function getUrlAttribute()
    {
        return route('posts.show', ['slug' => $this->slug]);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'faq_category_post');
    }

    public function getClearBodyAttribute()
    {
        $config = HTMLPurifier_Config::createDefault();
        $config->set('HTML.AllowedElements', '');
        $config->set('Attr.AllowedClasses', '');
        $config->set('HTML.AllowedAttributes', '');
        $config->set('CSS.AllowedProperties', 'text-align');
        $config->set('AutoFormat.RemoveEmpty', true);
        $purifier = new HTMLPurifier($config);
        $text = $purifier->purify($this->body);

        return $text;
    }
}