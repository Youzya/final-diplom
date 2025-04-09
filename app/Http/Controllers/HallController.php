<?php

namespace App\Http\Controllers;

use App\Models\Hall;
use App\Models\HallConfig;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator as FacadesValidator;

class HallController extends Controller
{
    public function index()
    {
        $data = Hall::all();
        return view('admin.index', ['data' => $data]);
    }

    public function create()
    {
        //
    }

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

    public function show(Hall $hall)
    {
        //
    }

    public function edit(Hall $hall)
    {
        //
    }

    public function updateSeatCount(Request $request)
    {
        $request->validate(
            [
                'rows' => 'required|numeric|min:1|max:10',
                'seats' => 'required|numeric|min:1|max:10',
            ],
            [
                'rows.required' => 'Количество рядов должно быть от 1 до 10',
                'seats.required' => 'Количество мест должно быть от 1 до 10',
            ]
        );

        $hall = Hall::find($request->id);

        if ($hall) {
            $hall->rowCount = $request->rows;
            $hall->seatsCount = $request->seats;
            $result = $hall->save();

            if ($result) {
                HallConfig::where('hall_id', $request->id)->delete();

                for ($i = 1; $i <= $request->rows; $i++) {
                    for ($b = 1; $b <= $request->seats; $b++) {
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
                'priceStandart.required' => 'Минимальная значение поля цена 1: 100',
                'priceVip.required' => 'Минимальная значение поля цена 2: 100',
            ]
        );

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $hall = Hall::find($request->id);

        if (!$hall) {
            return response()->json(['error' => 'Зал не найден'], 404);
        }

        $hall->priceStandart = $request->priceStandart;
        $hall->priceVip = $request->priceVip;
        $hall->save();

        return response()->json([
            'message' => 'Цены успешно сохранены!',
            'prices' => [
                'priceStandart' => $hall->priceStandart,
                'priceVip' => $hall->priceVip,
            ]
        ], 200);
    }

    public function activateHall(Request $request)
    {
        $hall = Hall::find($request->hall_id);

        if ($hall) {
            $hall->active = !$hall->active;
            $hall->save();
        }

        return redirect('admin')->withFragment('#hall-activate-section')->with(['checkedHallActivateTab' => $request->hall_id]);
    }

    public function destroy(Request $request)
    {
        $hall = Hall::find($request['id']);

        if (!$hall) {
            return redirect('admin')->withErrors('Зал не найден');
        }

        HallConfig::where('hall_id', $hall->id)->delete();
        $hall->delete();

        return redirect('admin')->with('success', 'Зал успешно удалён');
    }
}
