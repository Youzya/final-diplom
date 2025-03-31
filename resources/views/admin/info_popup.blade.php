<div class="popup" id="info-popup">
  <div class="popup__container">
    <div class="popup__content">
      <div class="popup__header">
        <h2 class="popup__title">
          <a class="popup__dismiss" href="#"><img src="{{url('/assets/admin/i/close.png')}}" alt="Закрыть" onclick="deletePopup(this.closest('.popup'))"></a>
        </h2>
      </div>
      <div class="popup__wrapper">
        <div class="messages__wrapper" style="font-size: 15px"></div>
        <div class="conf-step__buttons text-center">
          <button class="conf-step__button conf-step__button-regular" onclick="deletePopup(this.closest('.popup'))">Ok</button>
        </div>
      </div>
    </div>
  </div>
</div>