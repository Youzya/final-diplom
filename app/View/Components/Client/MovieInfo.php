<?php

namespace App\View\Components\client;

use App\Models\Movie;
use Closure;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;

class MovieInfo extends Component
{
    public $movie;
    
    /**
     * Create a new component instance.
     */
    public function __construct($movieId)
    {
        $this->movie = Movie::find($movieId);
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.client.movie-info');
    }
}
