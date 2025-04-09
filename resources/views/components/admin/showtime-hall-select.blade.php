<select class="conf-step__input" name="hall_id" required>
  @foreach($halls as $hall)
  <option value="{{$hall->id}}">{{$hall->name}}</option>
  @endforeach
</select>