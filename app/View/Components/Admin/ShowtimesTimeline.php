<?php

namespace App\View\Components\admin;

use Closure;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;

class ShowtimesTimeline extends Component
{
    public $showtimes;
    
    /**
     * Create a new component instance.
     */
    public function __construct($showtimes)
    {
        $this->showtimes = $showtimes;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.admin.showtimes-timeline');
    }
}
