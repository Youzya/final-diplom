<select class="conf-step__input" name="movie_id" required>
  @foreach($movies as $movie)
  <option value="{{$movie->id}}">{{$movie->name}}</option>
  @endforeach
</select>