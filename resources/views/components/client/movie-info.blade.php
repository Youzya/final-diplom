<div class="movie__info">
    <div class="movie__poster">
        <img class="movie__poster-image" alt="{{$movie->name}} постер" src="{{$movie->image}}">
    </div>
    <div class="movie__description">
        <h2 class="movie__title">{{$movie->name}}</h2>
        <p class="movie__synopsis">{{$movie->description}}</p>
        <p class="movie__data">
        <span class="movie__data-duration">{{$movie->duration}} минут</span>
        <span class="movie__data-origin">{{$movie->country}}</span>
        </p>
    </div>
</div> 