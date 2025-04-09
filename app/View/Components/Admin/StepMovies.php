<?php

namespace App\View\Components\admin;

use Closure;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;

class StepMovies extends Component
{
    public $movies;
    
    /**
     * Create a new component instance.
     */
    public function __construct($movies)
    {
        $this->movies = $movies;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.admin.step-movies');
    }
}
