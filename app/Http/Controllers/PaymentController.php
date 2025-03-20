<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Showtime;
use App\Models\HallConfig;
use App\Models\Ticket;

class PaymentController extends Controller
{
    public function indexPayment($hallConfigIdData, $sum, $showtimeId, $selectedDate)
    {
        $hallConfigIdArray = explode('&', $hallConfigIdData);
        $reservationCheck = [];
        
        foreach ($hallConfigIdArray as $seatId) {
            $ticket = Ticket::where('hallConfig_id', $seatId)->where('date', $selectedDate)->firstWhere('showtime_id', $showtimeId);
            $ticket ? array_push($reservationCheck, $ticket) : null;
        }

        if (!empty($reservationCheck)) {
            $errors = [];

            foreach ($reservationCheck as $seat) {
                $hallConfig = HallConfig::get()->firstWhere('id', $seat['hallConfig_id']);
                $errors[] = "Место $hallConfig->seat (ряд $hallConfig->row) уже занято";
            }

            return redirect()->back()->withErrors($errors);
        }
        
        $paymentData = [];
        $seats = [];

        foreach ($hallConfigIdArray as $seatId) {
            $seat = HallConfig::find($seatId);
            $seats[] = "$seat->seat место ($seat->row ряд)";
        }

        $paymentData['movieName'] = Showtime::find($showtimeId)->movie->name;
        $paymentData['hallName'] = Showtime::find($showtimeId)->hall->name;
        $paymentData['showtimeId'] = $showtimeId;
        $paymentData['hallConfigIdData'] = $hallConfigIdData;
        $paymentData['seats'] = join(', ', $seats);
        $paymentData['startTime'] = Showtime::find($showtimeId)->start_time;
        $paymentData['sum'] = $sum;
        $paymentData['selectedDate'] = $selectedDate;

        return view('client.payment', ['paymentData' => $paymentData]);
    }
}
