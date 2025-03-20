function showInfoPopup(header, message) {
  let infoPopup = document.getElementById('info-popup');
  infoPopup.querySelector('h2').textContent = header;
  infoPopup.querySelector('.messages__wrapper').textContent = message;
  switchPopup(infoPopup);
}

function switchPopup(el) {
  if(el) {
    el.classList.toggle('active');
  }
}

function deletePopup(el) {
  if(el) {
    el.remove();
  }
}

function seatClickStatusChange(el, priceStandart, priceVip) {
  let sum = document.getElementById('total-sum')

  if (el.className == 'buying-scheme__chair buying-scheme__chair_standart') {
    el.className = 'buying-scheme__chair buying-scheme__chair_selected'
    el.dataset.seatStatus = 'selected'
    sum.textContent = +sum.textContent + priceStandart
  } else if (el.className == 'buying-scheme__chair buying-scheme__chair_vip') {
    el.className = 'buying-scheme__chair buying-scheme__chair_selected'
    el.dataset.seatStatus = 'selected'
    sum.textContent = +sum.textContent + priceVip
  } else if (el.className == 'buying-scheme__chair buying-scheme__chair_selected') {
    el.className = 'buying-scheme__chair buying-scheme__chair_' + el.dataset.seatOriginStatus
    el.dataset.seatStatus = el.dataset.seatOriginStatus

    if (el.dataset.seatOriginStatus === 'standart') {
      sum.textContent = +sum.textContent - priceStandart
    } else if (el.dataset.seatOriginStatus === 'vip') {
      sum.textContent = +sum.textContent - priceVip
    }
  }

  generateRouteToPayment(sum.textContent)
}

function generateRouteToPayment(sum) {
  let selectedSeats = document.querySelectorAll('[data-seat-status = "selected"]')
  let button = document.querySelector('.acceptin-button')

  if (!selectedSeats.length) {
    infoPopup = document.getElementById('info-popup')
    button.setAttribute("onclick", "showInfoPopup('Сообщение:', 'Сначала выберете места!')")
    return
  }

  button = document.querySelector('.acceptin-button')
  host = location
  let selectedSeatsId = []

  for (const seat of selectedSeats) {
    selectedSeatsId.push(seat.dataset.seatId)
  }

  button.setAttribute("onclick", `window.location.href="${location.origin}/payment/${encodeURIComponent(selectedSeatsId.join('&'))}/${sum}/${button.dataset.showtime}/${button.dataset.selectedDate}"`);
}
