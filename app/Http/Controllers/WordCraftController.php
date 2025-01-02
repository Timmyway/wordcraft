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

    public function blogIndex(Request $request)
    {
        $page = $request->page ?? 1;
        // Load 10 posts per page, starting from the specified page
        $posts = $this->blogService->getPosts(10, $page);

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
