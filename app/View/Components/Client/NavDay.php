<?php

namespace App\View\Components\Client;

use Closure;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;

class NavDay extends Component
{
    public $showtimeDate;
    public $selectedDate;
    
    /**
     * Create a new component instance.
     */
    public function __construct($showtimeDate, $selectedDate)
    {
        $this->showtimeDate = $showtimeDate;
        $this->selectedDate = $selectedDate;
        $this->showtimeDate['class'] = 'page-nav__day';
        $this->сlassFormation();
    }

    protected function сlassFormation() {

        if ($this->showtimeDate['date'] === (new \Moment\Moment('now', 'Europe/Moscow'))->format('Y-m-d')) {
            $this->showtimeDate['class'] .= ' page-nav__day_today';
        }

        if ($this->showtimeDate['date'] === $this->selectedDate) {
            $this->showtimeDate['class'] .= ' page-nav__day_chosen';
        }

        if ($this->showtimeDate['weekday'] === 'сб' || $this->showtimeDate['weekday'] === 'вс') {
            $this->showtimeDate['class'] .= ' page-nav__day_weekend';
        }
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.client.nav-day');
    }
}
