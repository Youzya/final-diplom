<div class="popup" id="hall-delete-popup">
  <div class="popup__container">
    <div class="popup__content">
      <div class="popup__header">
        <h2 class="popup__title">
          Удаление зала
          <a class="popup__dismiss" href="#"><img src="{{url('/assets/admin/i/close.png')}}" alt="Закрыть" onclick="switchPopup(document.getElementById('hall-delete-popup'))"></a>
        </h2>

      </div>
      <div class="popup__wrapper">
        <form action="delete_hall" method="post" accept-charset="utf-8">
          @csrf
          <p class="conf-step__paragraph">Вы действительно хотите удалить зал <span></span>?</p>
          <!-- В span будет подставляться название зала -->
          <input type="hidden" class="conf-step__input" name="id" value="">
          <div class="conf-step__buttons text-center">
            <input type="submit" value="Удалить" class="conf-step__button conf-step__button-accent">
            <button type="button" class="conf-step__button conf-step__button-regular" onclick="switchPopup(document.getElementById('hall-delete-popup'))">Отменить</button>            
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
