<div class="popup" id="movie-add-popup">
  <div class="popup__container">
    <div class="popup__content">
      <div class="popup__header">
        <h2 class="popup__title">
          Добавление фильма
          <a class="popup__dismiss">
            <img src="{{url('/assets/admin/i/close.png')}}" alt="Закрыть" onclick="switchPopup(document.getElementById('movie-add-popup'))">
          </a>
        </h2>
      </div>
      <div class="popup__wrapper">
        <form action="add_movie" method="post" accept-charset="utf-8" enctype="multipart/form-data" class="popup__form">
          @csrf
          <label class="popup__left" for="poster-input-file">
            <input type="file" name="image" id="poster-input-file" accept="image/*" required hidden>
            <span class="select-poster">+</span>
            <img id="poster-preview" class="poster-preview" src="" alt="Предпросмотр постера">
          </label>
          <div class="popup__right">
            <label class="conf-step__label conf-step__label-fullsize">
              Название:
              <input class="conf-step__input" type="text" placeholder="Например, «Гражданин Кейн»" name="name" required>
              Описание:
              <input class="conf-step__input" type="text" placeholder="Например, этот фильм про..." name="description" required>
              Страна:
              <input class="conf-step__input" type="text" placeholder="Например, США" name="country" required>
                Продолжительность фильма (в минутах):
                <input class="conf-step__input" type="number" placeholder="Например, 120" name="duration" min="1" required>
            </label>
            <div class="conf-step__buttons text-center">
              <input type="submit" value="Добавить фильм" class="conf-step__button conf-step__button-accent">
              <button type="button" class="conf-step__button conf-step__button-regular" onclick="switchPopup(document.getElementById('movie-add-popup'))">Отменить</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
