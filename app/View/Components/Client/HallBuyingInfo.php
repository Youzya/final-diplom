<?php

namespace App\View\Components\client;

use Closure;
use Illuminate\View\Component;
use App\Models\Movie;
use App\Models\Hall;
use Illuminate\Contracts\View\View;

class HallBuyingInfo extends Component
{
    /**
     * Create a new component instance.
     */
    public $movie;
    public $hall;
    public $showtime;
    
    public function __construct($showtime)
    {
        $this->showtime = $showtime;
        $this->movie = Movie::find($showtime->movie_id);
        $this->hall = Hall::find($showtime->hall_id);
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.client.hall-buying-info');
    }
}
