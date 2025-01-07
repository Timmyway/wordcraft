<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class TwHero extends Component
{
    public $content;
    public $bgUrl;
    public $bgSize;
    public $height;
    public $overlayOpacity;
    /**
     * Create a new component instance.
     */
    public function __construct(string $height = 'auto', string $bgUrl = '', string $bgSize = 'cover', int $overlayOpacity = 50)
    {
        $this->bgUrl = $bgUrl;
        $this->bgSize = $bgSize;
        $this->height = $height;
        $this->overlayOpacity = $overlayOpacity;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.tw-hero');
    }
}
