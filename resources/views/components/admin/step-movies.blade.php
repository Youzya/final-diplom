<div class="conf-step__movies">
    @foreach($movies as $movie)
    <div class="conf-step__movie">
        <button class="trash-delete-btn" onclick="switchDeletePopup(document.getElementById('movie-delete-popup'), '{{$movie->name}}', {{$movie->id}})">
            <img src="{{ asset('assets/admin/i/trash-sprite.png') }}" alt="Удалить">
        </button>
        <img class="conf-step__movie-poster" alt="poster" src="{{url($movie->image)}}">
        <h3 class="conf-step__movie-title">{{$movie->name}}</h3>
        <p class="conf-step__movie-duration">{{$movie->duration}} минут</p>
    </div>
    @endforeach
</div>
