<?php

namespace App\View\Components\client;

use Closure;
use Illuminate\View\Component;
use App\Models\Hall;
use Illuminate\Contracts\View\View;
\Moment\Moment::setLocale('ru_RU');

class CinemaCatalog extends Component
{
    public $catalogData = [];
    public $selectedDate;
    public $currentDate;
    
    /**
     * Create a new component instance.
     */
    public function __construct($currentDate, $selectedDate)
    {
        $this->selectedDate = $selectedDate;
        $this->currentDate = $currentDate;
        $this->getCatalogData();
    }

    public function getCatalogData()
    {
        $activeHalls = Hall::all()->where('active', true);

        if ($activeHalls->isEmpty()) {
            return;
        }

        $hallsWithShowtimes = [];

        foreach($activeHalls as $hall) {
            $hallsWithShowtimes[] = Hall::find($hall->id)->showtimes;
        }

        $moviesInActiveHalls = [];

        foreach($hallsWithShowtimes as $showtimes) {
            foreach($showtimes as $showtime) {
                $moviesInActiveHalls[] = $showtime['movie_id'];
            }
        }

        $todayMoviesId = [];
  
        foreach (array_unique($moviesInActiveHalls) as $movieId) {
            $todayMoviesId[] = $movieId;
        }

        for ($i = 0; $i < count($todayMoviesId); $i++) {
            $currentMovieId = $todayMoviesId[$i];
            $movieData[$i]['movie_id'] = $currentMovieId;
            $movieData[$i]['showtimesByHalls'] = [];

            foreach($hallsWithShowtimes as $showtimes) {
                $currentHallShowtimes = [];
                $currentHallShowtimes['hall_id'] = $showtimes[0]['hall_id'];
                $currentHallShowtimes['showtimes'] = [];

                foreach($showtimes as $showtime) {
                    if ($showtime['movie_id'] === $currentMovieId) {
                        $currentHallShowtimes['showtimes'][] = $showtime;
                    }
                }

                $movieData[$i]['showtimesByHalls'][] = $currentHallShowtimes;
            }

            $this->catalogData[] = $movieData[$i];
        }
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.client.cinema-catalog');
    }
}
