<?php

namespace App\View\Components\client;

use Closure;
use Illuminate\View\Component;
use App\Models\Hall;
use App\Models\HallConfig;
use Illuminate\Contracts\View\View;

class HallBuyingScheme extends Component
{
    /**
     * Create a new component instance.
     */
    public $hall;
    public $hallConfig;
    public $selectedDate;
    
    public function __construct($showtime, $selectedDate)
    {
        $this->hall = Hall::find($showtime->hall_id);
        $this->hallConfig = HallConfig::all()->where('hall_id', $this->hall->id)->toArray();

        $takenTickets = $showtime->tickets->where('date', $selectedDate);

        foreach ($takenTickets as $takenTicket) {
            $hallConfigId = $takenTicket->hallConfig_id;

            $this->hallConfig = array_map(function($hallConfigSeat) use ($hallConfigId) {
                                    if ($hallConfigSeat['id'] === $hallConfigId) {
                                        $hallConfigSeat['status'] = 'taken';
                                        return $hallConfigSeat;
                                    } else  {
                                        return $hallConfigSeat;
                                    }
                                }, $this->hallConfig);
        }

        $this->selectedDate = $selectedDate;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.client.hall-buying-scheme');
    }
}
