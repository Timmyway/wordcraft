<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class TwBlogRow extends Component
{
    public $post;
    public $ctaText;
    /**
     * Create a new component instance.
     */
    public function __construct($post, string $ctaText = '')
    {
        $this->post = $post;
        if (empty($ctaText)) {
            $this->generateCtaText();
        }
    }

    public function generateCtaText()
    {
        // Liste des CTA optimisés
        $ctaOptions = [
            "En savoir plus",
            "Lire la suite",
            "Explorez"
        ];

        // Sélectionner un CTA aléatoire de la liste
        $this->ctaText = $ctaOptions[array_rand($ctaOptions)];
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.tw-blog-row');
    }
}
