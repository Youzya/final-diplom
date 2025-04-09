<?php

namespace App\View\Components\admin;

use Closure;
use App\Models\HallConfig;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;

class StepHall extends Component
{
    public $seatsData;
    public $rows;
    public $seats;
    
    /**
     * Create a new component instance.
     */
    public function __construct($hallData)
    {
        $this->seatsData = HallConfig::where('hall_id', $hallData['id'])->get()->toArray();
        $this->rows = $hallData['rows'];
        $this->seats = $hallData['seats'];
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.admin.step-hall');
    }
}
