<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

class CinemaCatalogController extends Controller
{
    public $showtimePeriod = [];
    public $selectedDate;
    
    public function index($date = null)
    {
        $dateExist = false;

        for ($i = 0; $i < 7; $i++) {
            $showtimeDate = [];
            $time = new \Moment\Moment('now', 'Europe/Moscow');
            $time->addDays($i);
            $showtimeDate['weekday'] = $time->format('D');
            $showtimeDate['mday'] = $time->format('d') . ' ' . $time->format('M');
            $showtimeDate['date'] = $time->format('Y-m-d');

            if ($showtimeDate['date'] === $date) {
                $dateExist = true;
            }

            $this->showtimePeriod[$i] = $showtimeDate;
        }

        $currentDate = (new \Moment\Moment('now', 'Europe/Moscow'))->format('Y-m-d');
        $this->selectedDate = !$dateExist ? $currentDate : $date;

        return view('client.index', ['showtimePeriod' => $this->showtimePeriod, 'selectedDate' => $this->selectedDate]);
    }
}
