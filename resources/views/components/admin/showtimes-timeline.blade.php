<div class="conf-step__seances-timeline">
  @foreach($showtimes as $showtime)
    <div class="conf-step__seances-movie" style="width: {{round(App\Models\Showtime::find($showtime->id)->movie->duration / 14.4, 2)}}%; background-color: rgb(133, 255, 137); left: {{round(((explode(':', $showtime->start_time)[0] * 60) + (explode(':', $showtime->start_time)[1])) / 14.4, 2)}}%;">
      <button class="trash-delete-btn" onclick="switchDeletePopup(document.getElementById('showtime-delete-popup'), '{{App\Models\Showtime::find($showtime->id)->movie->name}}', {{$showtime->id}})">
        <img src="{{ asset('assets/admin/i/trash-sprite.png') }}" alt="Удалить">
      </button>
      <p class="conf-step__seances-movie-title">{{App\Models\Showtime::find($showtime->id)->movie->name}}</p>
      <p class="conf-step__seances-movie-start">{{$showtime->start_time}}</p>
    </div>
  @endforeach
</div>
