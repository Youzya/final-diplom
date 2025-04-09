<div class="conf-step__hall-wrapper">
@for($i = 1; $i < ($rows + 1); $i++)
    <div class="conf-step__row">
    @foreach (array_filter($seatsData, fn($seatsRow) => $seatsRow['row'] == $i) as $seatsRow)
        <span class="conf-step__chair conf-step__chair_{{$seatsRow['status']}}" onclick="seatClickStatusChange(this)" data-seat-id="{{$seatsRow['id']}}" data-seat-status="{{$seatsRow['status']}}"></span>
    @endforeach
    </div>
@endfor
</div>