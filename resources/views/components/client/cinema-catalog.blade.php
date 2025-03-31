@if(!empty($catalogData))
  @foreach($catalogData as $movieData)
    <section class="movie">
      <x-client.movie-info :movieId="$movieData['movie_id']"/>
      @foreach($movieData['showtimesByHalls'] as $showtimesByHalls)
        @if($showtimesByHalls['showtimes'])
          <div class="movie-seances__hall">
            <h3 class="movie-seances__hall-title">{{App\Models\Hall::find($showtimesByHalls['hall_id'])->name}}</h3>
              <ul class="movie-seances__list">
                @foreach($showtimesByHalls['showtimes'] as $showtime)
                  @if($selectedDate === $currentDate)
                    @if((new \Moment\Moment($currentDate . 'T' . substr($showtime->start_time, 0, 5) . ':00', 'Europe/Moscow'))->fromNow()->getMinutes() > 0)
                      <li class="movie-seances__time-block"><span class="movie-seances__time missed" style="background-color: dimgrey">{{$showtime->start_time}}</span></li>
                    @else
                      <li class="movie-seances__time-block"><a class="movie-seances__time" href="{{route('hall', ['showtimeId' => $showtime->id, 'selectedDate' => $selectedDate])}}">{{$showtime->start_time}}</a></li>
                    @endif
                  @else
                    <li class="movie-seances__time-block"><a class="movie-seances__time" href="{{route('hall', ['showtimeId' => $showtime->id, 'selectedDate' => $selectedDate])}}">{{$showtime->start_time}}</a></li>
                  @endif
                @endforeach
              </ul>
          </div>
        @endif
      @endforeach
    </section>
  @endforeach
@endif