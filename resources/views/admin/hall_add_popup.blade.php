<div class="popup" id="hall-add-popup">
  <div class="popup__container">
    <div class="popup__content">
      <div class="popup__header">
        <h2 class="popup__title">
          Добавление зала
          <a class="popup__dismiss"><img src="{{url('/assets/admin/i/close.png')}}" alt="Закрыть" onclick="switchHallPopup(document.getElementById('hall-add-popup'))"></a>
        </h2>

      </div>
      <div class="popup__wrapper">
        <form action="add_hall" method="post" accept-charset="utf-8">
          @csrf
          <label class="conf-step__label conf-step__label-fullsize" for="name">
            Название зала
            <input class="conf-step__inputв" type="text" placeholder="Например, &laquo;Зал 1&raquo;" name="name" required>
          </label>
          <div class="conf-step__buttons text-center">
            <input type="submit" value="Добавить зал" class="conf-step__button conf-step__button-accent">
            <button type="button" class="conf-step__button conf-step__button-regular" onclick="switchHallPopup(document.getElementById('hall-add-popup'))">Отменить</button>            
          </div>
        </form>
      </div>
    </div>
  </div>
</div>