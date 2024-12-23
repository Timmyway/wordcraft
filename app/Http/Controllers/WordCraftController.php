<?php

namespace App\Http\Controllers;

use App\Helpers\Blog\BlogHelper;
use App\Services\Blog\BlogService;
use Illuminate\Http\Request;

class WordCraftController extends Controller
{
    protected BlogService $blogService;

    public function __construct(BlogService $blogService)
    {
        $this->blogService = $blogService;
    }

    public function blogIndex()
    {
        $posts = $this->blogService->getPosts();

        return view('blog.index', [
            'posts' => $posts,
        ]);
    }

    public function blogShow (string $postId)
    {
        $post = $this->blogService->getPost($postId);
        // $relatedPosts = collect($this->blogService->getRelatedPosts($slug));

        return view('blog.details', [
            'post' => $post,
            // 'relatedPosts' => $relatedPosts,
            'readTime' => $post ? BlogHelper::estimateReadTime($post['body']) : null,
        ]);
    }

    public function about()
    {
        return view('site.about');
    }

    public function contact()
    {
        return view('site.contact');
    }
}
