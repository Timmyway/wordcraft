<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class TwHero extends Component
{
    public $content;
    public $bgUrl;
    /**
     * Create a new component instance.
     */
    public function __construct(string $bgUrl = '')
    {
        $this->bgUrl = $bgUrl;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.tw-hero');
    }
}
