<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MovieController extends Controller
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
                'name' => 'required|unique:halls',
                'duration' => 'required|numeric',
                'description' => 'required|string',
                'country' => 'required|string',
                'image' => 'required|mimes:jpeg,gif,bmp,png|max:1024',
            ],
            [
                'name.required' => 'Название фильма не заполнено',
                'name.unique' => 'Фильм с таким именем уже существует',
                'duration.numeric' => 'В поле "продолжитель фильма" используются только цифры',
                'duration.required' => 'Продолжительность фильма не заполнено',
                'description.string' => 'В поле "Описание фильма" должен быть текст',
                'description.required' => 'Описание фильма не заполнено',
                'country.string' => 'В поле "Страна" должен быть текст',
                'country.required' => 'Страна не заполнена',
                'image.required' => 'Не выбран файл картинки',
                'image.mimes' => 'Требуемые форматы картинки: jpeg, gif, bmp, png',
                'image.max' => 'Максимальный размер картинки 1024 пикселя',
            ]
        );

        $image = $request->file('image');
        $filename = $image->getClientOriginalName();
        $image->move(public_path('posters'), $filename);

        $movie = new Movie;
        $movie->name = $request->name;
        $movie->duration = $request->duration;
        $movie->description = $request->description;
        $movie->country = $request->country;
        $movie->image = '/posters/' . $filename;
        $movie->save();
        return redirect('admin')->withFragment('#showtime-section');
    }

    /**
     * Display the specified resource.
     */
    public function show(Movie $movie)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Movie $movie)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Movie $movie)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $movie = Movie::find($request['id']);
        $movie->delete();
        return redirect('admin')->withFragment('#showtime-section');
    }
}
