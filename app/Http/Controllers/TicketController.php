<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\Showtime;
use App\Models\HallConfig;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store($showtimeId, $hallConfigIdData, $selectedDate)
    {
        $hallConfigIdArray = explode('&', $hallConfigIdData);

        foreach ($hallConfigIdArray as $hallConfigId) {
            $ticket = new Ticket;
            $ticket->showtime_id = $showtimeId;
            $ticket->hallConfig_id = $hallConfigId;
            $ticket->date = $selectedDate;
            $ticket->save();
        }

        $ticketsData = [];
        $seats = [];

        foreach ($hallConfigIdArray as $hallConfigId) {
            $seat = HallConfig::find($hallConfigId);
            $seats[] = "$seat->seat место ($seat->row ряд)";
        }

        $ticketsData['movieName'] = Showtime::find($showtimeId)->movie->name;
        $ticketsData['hallName'] = Showtime::find($showtimeId)->hall->name;
        $ticketsData['seats'] = join(', ', $seats);
        $ticketsData['startTime'] = Showtime::find($showtimeId)->start_time;
        $ticketsData['strigForQRcode'] = "$selectedDate/$showtimeId/$hallConfigIdData";
      
        return view('client.ticket', ['ticketsData'=> $ticketsData]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Ticket $ticket)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Ticket $ticket)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Ticket $ticket)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ticket $ticket)
    {
        //
    }
}
