<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class LottieAnimation extends Component
{
    public $path;
    public $width;
    public $height;
    public $loop;

    /**
     * Create a new component instance.
     */
    public function __construct($path, $width = '300px', $height = '300px', $loop = true)
    {
        $this->path = $path;
        $this->width = $width;
        $this->height = $height;
        $this->loop = $loop;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.lottie-animation');
    }
}