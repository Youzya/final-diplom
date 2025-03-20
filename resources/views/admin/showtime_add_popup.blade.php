<div class="popup" id="showtime-add-popup">
  <div class="popup__container">
    <div class="popup__content">
      <div class="popup__header">
        <h2 class="popup__title">
          Добавление сеанса
          <a class="popup__dismiss"><img src="{{url('/assets/admin/i/close.png')}}" alt="Закрыть" onclick="switchPopup(document.getElementById('showtime-add-popup'))"></a>
        </h2>

      </div>
      <div class="popup__wrapper">
        <form action="add_showtime" method="post" accept-charset="utf-8">
          @csrf
          <label class="conf-step__label conf-step__label-fullsize" for="hall_id">
            Зал
            <x-admin.showtime-hall-select :halls="App\Models\Hall::all()"/>
          </label>
          <label class="conf-step__label conf-step__label-fullsize" for="movie_id">
            Фильм
            <x-admin.showtime-movie-select :movies="App\Models\Movie::all()"/>
          </label>
          <label class="conf-step__label conf-step__label-fullsize" for="start_time">
            Время начала
            <input class="conf-step__input" type="time" value="00:00" name="start_time" required>
          </label>

          <div class="conf-step__buttons text-center">
            <input type="submit" value="Добавить" class="conf-step__button conf-step__button-accent">
            <button type="button" class="conf-step__button conf-step__button-regular" onclick="switchPopup(document.getElementById('showtime-add-popup'))">Отменить</button>            
          </div>
        </form>
      </div>
    </div>
  </div>
</div>