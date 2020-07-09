<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Faq Posts Index
    |--------------------------------------------------------------------------
    |
    | This is the index where your faq posts will be indexed, yo can use it
    | to replace the default index scout will be looking for.
    |
    */

    'posts_index' => 'faq_posts',

    /*
    |--------------------------------------------------------------------------
    | Faq Admin Section Middleware
    |--------------------------------------------------------------------------
    |
    | This is the index where your faq posts will be indexed, yo can use it
    | to replace the default index scout will be looking for.
    |
    */

    'admin_middleware' => 'web',

    'roles' => ['recruiter', 'candidate']
];