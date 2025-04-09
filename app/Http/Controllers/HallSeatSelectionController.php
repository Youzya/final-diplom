<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Showtime;

class HallSeatSelectionController extends Controller
{
    public function getHallConfiguration($showtimeId, $selectedDate)
    {
        $showtime = Showtime::find($showtimeId);
        return view('client.hall', ['showtime' => $showtime, 'selectedDate' => $selectedDate]);
    }
}
