<?php

namespace App\Http\Controllers;

use App\Models\Hall;
use App\Http\Controllers\Controller;
use App\Models\HallConfig;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator as FacadesValidator;
use Illuminate\Validation\Validator;

class HallController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Hall::all();
        return view('admin.index', ['data' => $data]);
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
                'name' => 'required|unique:halls',
            ],
            [
                'name.required' => 'Поле имя, пустое',
                'name.unique' => 'Такое имя зала уже используется, введите другое',
            ]
        );

        $hall = new Hall;
        $hall->name = $request->name;
        $hall->save();

        return redirect('admin');
    }

    /**
     * Display the specified resource.
     */
    public function show(Hall $hall)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Hall $hall)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateSeatCount(Request $request)
    {
        $request->validate(
            [
                'rows' => 'required|numeric|min:1|max:10',
                'seats' => 'required|numeric|min:1|max:10',
            ],
            [
                'rows' => 'Количество рядов должно быть от 1 до 10',
                'seats' => 'Количество мест должно быть от 1 до 10',
            ]
        );

        $hall = Hall::find($request->id);

        if ($hall) {
            $hall->rowCount = $request->rows;
            $hall->seatsCount = $request->seats;
            $result = $hall->save();

            if ($result) {
                $hallConfig = HallConfig::where('hall_id', $request->id)->get();
                
                if (!empty($hallConfig)) {
                    foreach ($hallConfig as $seat) {
                        $seat->delete();
                    }
                }
    
                for ($i = 1; $i < $request->rows + 1; $i++) {
                    for ($b = 1; $b < $request->seats + 1; $b++) {
                        (new HallConfigController)->store(['id' => $request->id, 'rows' => $i, 'seats' => $b]);
                    }
                }
            }
        }

        return redirect('admin')->withFragment('#hall-config-section')->with(['checkedHallConfigTab' => $request->id]);
    }
    public function updatePrice(Request $request)
    {
        $validator = FacadesValidator::make(
            $request->all(), 
            [
                'priceStandart' => 'required|numeric|min:100',
                'priceVip' => 'required|numeric|min:100',
            ], 
            [
            'priceStandart' => 'Минимальная значение поля цена 1: 100',
            'priceVip' => 'Минимальная значение поля цена 2: 100',
            ]
        );

        if ($validator->fails()) {
            return response()->json(['errors'=>$validator->errors()->all()]);
        }

        $hall = Hall::find($request->id);

        if ($hall) {
            $hall->priceStandart = $request->priceStandart;
            $hall->priceVip = $request->priceVip;
            $result = $hall->save();

            if ($result) {
                return response('Цены успешно сохранены!', 200)
                ->header('Content-Type', 'text/plain');
            }
        }
    }

    public function activateHall(Request $request)
    {
        $hall = Hall::find($request->hall_id);

        $hall->active = !$hall->active;
        $hall->save();

        return redirect('admin')->withFragment('#hall-activate-section')->with(['checkedHallActivateTab' => $request->hall_id]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
{
    $hall = Hall::find($request['id']);

    if (!$hall) {
        return redirect('admin')->withErrors('Зал не найден');
    }

    // Удаляем связанные записи в HallConfig
    HallConfig::where('hall_id', $hall->id)->delete();

    // Теперь можно удалить зал
    $hall->delete();

    return redirect('admin')->with('success', 'Зал успешно удалён');
}
}
