<?php
namespace App\Services\Blog;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;

class BlogService
{
    protected string $baseUrl;
    protected string $apiKey;

    public function __construct()
    {
        $this->baseUrl = config('wordcraft.superblog.api_url');
        $this->apiKey = config('wordcraft.superblog.api_key');
    }

    /**
     * Fetch all blog posts.
     *
     * @return array|null
     */
    public function getPosts(int $perPage = 10): ?LengthAwarePaginator
    {
        $response = $this->makeRequest('GET', "posts?per_page={$perPage}");

        // Ensure $response contains 'data', then filter and process it
        $posts = collect($response['data'] ?? []);

        // Filter out unpublished posts
        $filteredPosts = $posts->filter(function ($post) {
            return $post['published'] ?? false;
        });

        // Format 'published_at' date and other necessary fields
        $formattedPosts = $filteredPosts->map(function ($post) {
            $post['published_at'] = tim_to_pretty_date($post['published_at']);
            return $post;
        });

        // Create a LengthAwarePaginator to maintain pagination structure
        $paginatedPosts = new LengthAwarePaginator(
            $formattedPosts, // Items for the current page
            $response['total'], // Total number of items
            $response['per_page'], // Items per page
            $response['current_page'], // Current page number
            [
                'path' => LengthAwarePaginator::resolveCurrentPath() // URL for pagination links
            ]
        );

        return $paginatedPosts;
    }

    /**
     * Fetch a specific blog post by slug.
     *
     * @param string $slug
     * @return array|null
     */
    public function getPost(string $postId): ?Collection
    {
        $response = $this->makeRequest('GET', "posts/{$postId}");
        // Return only post if it is published
        if (!$response['published']) {
            return null;
        }
        // Format published date and all necessary fields
        $response['published_at'] = tim_to_pretty_date($response['published_at']);

        return collect($response);
    }

    /**
     * Fetch related blog posts for a specific slug.
     *
     * @param string $slug
     * @return array|null
     */
    public function getRelatedPosts(string $slug): ?array
    {
        return $this->makeRequest('GET', "{$slug}/related");
    }

    /**
     * Make an HTTP request to the SuperBlog API.
     *
     * @param string $method
     * @param string|null $endpoint
     * @return array|null
     */
    protected function makeRequest(string $method, ?string $endpoint = null): ?array
    {
        $url = $endpoint ? "{$this->baseUrl}/{$endpoint}" : $this->baseUrl;

        $response = Http::withHeaders([
            'Authorization' => "Bearer {$this->apiKey}",
        ])->{$method}($url);

        if ($response->successful()) {
            return $response->json();
        }

        // Log error details for debugging in production
        logger()->error('BlogService Request Failed', [
            'method' => $method,
            'url' => $url,
            'status' => $response->status(),
            'body' => $response->body(),
        ]);

        return null;
    }
}
