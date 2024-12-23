<?php
namespace App\Services\Blog;

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
    public function getPosts(int $perPage = 10): ?Collection
    {
        $response = $this->makeRequest('GET', "posts?per_page={$perPage}");
        return collect($response);
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
