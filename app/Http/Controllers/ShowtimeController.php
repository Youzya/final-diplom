<?php

namespace App\Http\Controllers;

use App\Models\Showtime;
use App\Models\Movie;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Moment\Moment;

class ShowtimeController extends Controller
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
    public function store(Request $request)
    {
        $request->validate(
            [
                'hall_id' => 'required|numeric',
                'movie_id' => 'required|numeric',
                'start_time' => 'required|string',
            ],
            [
                'hall_id.required' => 'id зала не заполнено',
                'hall_id.numeric' => 'id зала должно быть числом',
                'movie_id.required' => 'id фильма не заполнено',
                'movie_id.numeric' => 'id фильма должно быть числом',
                'start_time.required' => 'Время начала сеанса не заполнено',
                'start_time.string' => 'Введите время сеанса в нужном формате',
            ]
        );

        $startTime = $request->start_time;
        $endTime = (new Moment($request->start_time))->addMinutes(Movie::find($request->movie_id)->duration)->format('H:i');

        $endLessStart = Carbon::createFromTimeString($endTime)->lt(Carbon::createFromTimeString($startTime));
        $currentHallShowtimes = Showtime::where('hall_id', $request->hall_id)->get();
        $overlappings = [];

        foreach ($currentHallShowtimes as $showtime) {
            if ($endLessStart) {
                if ($showtime->start_time <= '23:59' && $showtime->end_time >= $startTime) {
                    $overlappings[] = $showtime;
                }

                if ($showtime->start_time <= $endTime && $showtime->end_time <= $startTime) {
                    $overlappings[] = $showtime;
                }   
                
                if ($showtime->start_time > $showtime->end_time) {
                    if ($showtime->start_time <= '23:59' && $showtime->end_time <= $startTime) {
                        $overlappings[] = $showtime;
                    } 
                }
            }

            if ($showtime->start_time <= $endTime && $showtime->end_time >= $startTime) {
                $overlappings[] = $showtime;
            }
        }

        if (!empty($overlappings)) {
            $errors[] = 'При попытке добавления найдены пересечения с другими сеансами:';

            foreach ($overlappings as $overlapp) {
                $errors[] = $overlapp->start_time . ' - ' . $overlapp->end_time;
            }

            return redirect()->back()->withErrors($errors)->withFragment('#showtime-section');
        }

        $showtime = new Showtime();
        $showtime->hall_id = $request->hall_id;
        $showtime->movie_id = $request->movie_id;
        $showtime->start_time = $startTime;
        $showtime->end_time = $endTime;
        $showtime->save();
        return redirect('admin')->withFragment('#showtime-section');
    }

    /**
     * Display the specified resource.
     */
    public function show(Showtime $showtime)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Showtime $showtime)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Showtime $showtime)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $showtime = Showtime::find($request['id']);
    
        if (!$showtime) {
            return redirect('admin')->withErrors(['Сеанс не найден'])->withFragment('#showtime-section');
        }
    
        \DB::table('tickets')->where('showtime_id', $showtime->id)->delete();

        $showtime->delete();
    
        return redirect('admin')->withFragment('#showtime-section');
    }
    
}
