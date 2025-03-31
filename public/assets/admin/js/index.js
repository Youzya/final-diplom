let inputPoster = document.getElementById('poster-input-file');
let imageName = document.querySelector('.poster-file-name');
let posterPreview = document.getElementById('poster-preview');
let saveButton = document.querySelector('.save-button');

inputPoster.addEventListener('change', () => {
  let inputImage = inputPoster.files[0];
  
  if (inputImage) {
    if (imageName) {
      imageName.innerText = inputImage.name;
    }
    
    let reader = new FileReader();
    reader.onload = (e) => {
      if (posterPreview) {
        posterPreview.src = e.target.result;
      }
    };
    reader.readAsDataURL(inputImage);
  }
  toggleSaveButton();
});

inputPoster.addEventListener('invalid', (e) => {
  e.preventDefault();
  if (imageName) {
    imageName.innerText = 'Добавьте файл!';
  }
});

function toggleSaveButton() {
  if (saveButton) {
    saveButton.disabled = false;
  }
}

document.querySelectorAll('.conf-step__input').forEach(input => {
  input.addEventListener('input', toggleSaveButton);
});

function switchPopup(el) {
  if (el) {
    el.classList.toggle('active');
  }
}

function deletePopup(el) {
  if (el) {
    el.classList.remove('active');
  }
}

function switchDeletePopup(el, name = null, id = null) {
  if (name && id) {
    el.querySelector('span').textContent = name;
    el.querySelector('[name="id"]').value = id;
  }
  if (el) {
    switchPopup(el);
  }
}

function switchHallTabs(id, className) {
  let currentActiveHall = document.getElementsByClassName(className + ' active');
  if (currentActiveHall[0]) {
    switchPopup(currentActiveHall[0]);
  }
  document.getElementById(`${className}-${id}`).classList.toggle('active');
}

document.querySelectorAll('.hall-tabs').forEach(tab => {
  tab.addEventListener('click', () => {
    toggleSaveButton();
  });
});

function seatClickStatusChange(el) {
  let statusMap = {
    'conf-step__chair conf-step__chair_standart': 'conf-step__chair conf-step__chair_vip',
    'conf-step__chair conf-step__chair_vip': 'conf-step__chair conf-step__chair_disabled',
    'conf-step__chair conf-step__chair_disabled': 'conf-step__chair conf-step__chair_standart'
  };
  
  el.className = statusMap[el.className] || el.className;
  el.dataset.seatStatus = el.className.split('_').pop();
  toggleSaveButton();
}

async function updateHallConfig(el) {
  const requestData = [];
  let token = el.dataset.token;
  let seatsCollection = el.closest('.hall-config').querySelectorAll('[data-seat-id]');

  seatsCollection.forEach(seat => {
    requestData.push({ id: seat.dataset.seatId, status: seat.dataset.seatStatus });
  });

  let response = await fetch('update_hall_config', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json;charset=utf-8',
      'X-CSRF-TOKEN': token
    },
    body: JSON.stringify(requestData)
  });

  let result = await response.json();
  showResponseMessage(result);
}

async function updateHallPrice(el) {
  let token = el.dataset.token;
  let hallId = el.dataset.hallId;
  let priceCollection = el.closest('.hall-price')?.querySelectorAll('.conf-step__input');

  if (!priceCollection || priceCollection.length < 2) {
    console.error("Ошибка: не найдены поля с ценами");
    return;
  }

  let response = await fetch('update_hall_price', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json;charset=utf-8',
      'X-CSRF-TOKEN': token
    },
    body: JSON.stringify({
      id: hallId,
      priceStandart: priceCollection[0].value,
      priceVip: priceCollection[1].value
    })
  });

  let result = await response.json();

  if (result.errors) {
    showResponseMessage(result.errors, 'error');
    return;
  }

  showResponseMessage(result);
}

function ensureInfoPopup() {
  let infoPopup = document.getElementById('info-popup');

  if (!infoPopup) {
    infoPopup = document.createElement('div');
    infoPopup.id = 'info-popup';
    infoPopup.innerHTML = `
      <h2></h2>
      <div class="messages__wrapper"></div>
      <button onclick="switchPopup(this.closest('#info-popup'))">Закрыть</button>
    `;
    document.body.appendChild(infoPopup);
  }
  return infoPopup;
}

function showResponseMessage(result, status = 'success') {
  let infoPopup = ensureInfoPopup();
  let messages = infoPopup.querySelector('.messages__wrapper');

  if (!messages) {
    console.error("Ошибка: не найден .messages__wrapper внутри #info-popup");
    return;
  }

  messages.innerHTML = '';

  if (status === 'error') {
    infoPopup.querySelector('h2').textContent = 'Ошибка!';
    if (Array.isArray(result)) {
      result.forEach(error => {
        let p = document.createElement("p");
        p.className = 'message';
        p.textContent = error;
        messages.appendChild(p);
      });
    } else {
      let p = document.createElement("p");
      p.className = 'message';
      p.textContent = result;
      messages.appendChild(p);
    }
  } else {
    infoPopup.querySelector('h2').textContent = 'Сообщение!';
    let p = document.createElement("p");
    p.className = 'message';
    p.textContent = 'Цены успешно сохранены!';
    messages.appendChild(p);
  }

  switchPopup(infoPopup);
}
