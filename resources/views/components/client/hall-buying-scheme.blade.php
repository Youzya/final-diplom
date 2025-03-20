
<div class="buying-scheme">
    <div class="buying-scheme__wrapper">
        @for($i = 1; $i < ($hall->rowCount + 1); $i++)
            <div class="buying-scheme__row">
            @foreach (array_filter($hallConfig, fn($seat) => $seat['row'] == $i) as $seat)
                <span class="buying-scheme__chair buying-scheme__chair_{{$seat['status']}}" onclick="seatClickStatusChange(this, {{$hall->priceStandart}}, {{$hall->priceVip}})" data-seat-id="{{$seat['id']}}" data-seat-status="{{$seat['status']}}" data-seat-origin-status="{{$seat['status']}}"></span>
            @endforeach
            </div>
        @endfor
    </div>
    <div class="buying-scheme__legend">
      <div class="col">
        <p class="buying-scheme__legend-price"><span class="buying-scheme__chair buying-scheme__chair_standart"></span> Свободно (<span class="buying-scheme__legend-value">{{$hall->priceStandart}}</span>руб)</p>
        <p class="buying-scheme__legend-price"><span class="buying-scheme__chair buying-scheme__chair_vip"></span> Свободно VIP (<span class="buying-scheme__legend-value">{{$hall->priceVip}}</span>руб)</p>            
      </div>
      <div class="col">
        <p class="buying-scheme__legend-price"><span class="buying-scheme__chair buying-scheme__chair_taken"></span> Занято</p>
        <p class="buying-scheme__legend-price"><span class="buying-scheme__chair buying-scheme__chair_selected"></span> Выбрано</p>                    
      </div>
    </div>
  </div>