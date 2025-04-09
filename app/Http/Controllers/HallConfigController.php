<?php

namespace App\Http\Controllers;

use App\Models\HallConfig;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HallConfigController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return HallConfig::all();
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
    public function store(array $hallData)
    {
        $hallConfig = new HallConfig();
        $hallConfig->hall_id = $hallData['id'];
        $hallConfig->row = $hallData['rows'];
        $hallConfig->seat = $hallData['seats'];
        $hallConfig->save();
    }

    /**
     * Display the specified resource.
     */
    public function show(HallConfig $hallConfig)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(HallConfig $hallConfig)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $result = null;
        $requestData = $request->toArray();
        foreach ($requestData as $seatData) {
            $findedSeat = HallConfig::find($seatData['id']);
            $findedSeat->status = $seatData['status'];
            $findedSeat->save();
            $result = $findedSeat;
        }

        if ($result) {
            return response(json_encode('Настройки кресел успешно сохранены!'), 200)
            ->header('Content-Type', 'text/plain');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(HallConfig $hallConfig)
    {
        //
    }
}
