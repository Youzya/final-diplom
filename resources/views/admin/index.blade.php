<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>ИдёмВКино</title>
  <link rel="stylesheet" href="{{asset('assets/admin/css/styles.css')}}">
  <link rel="stylesheet" href="{{asset('assets/admin/css/normalize.css')}}">
  <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900&amp;subset=cyrillic,cyrillic-ext,latin-ext" rel="stylesheet">
</head>

@includeIf('admin.hall_add_popup')
@includeIf('admin.hall_delete_popup')
@includeIf('admin.movie_add_popup')
@includeIf('admin.movie_delete_popup')
@includeIf('admin.showtime_add_popup')
@includeIf('admin.showtime_delete_popup')
@includeIf('admin.info_popup')

@if ($errors->any())
  @includeIf('admin.validation_alert_popup')
@endif

<body>
  <header class="page-header">
    <div class="header__info">
      <h1 class="page-header__title">Идём<span>в</span>кино</h1>
      <span class="page-header__subtitle">РЕЖИМ АДМИНИСТРАТОРА</span>
    </div>
    <div class="login-logout">

        <div class="logout__block">
            <a class="logout__link" href="{{ route('logout') }}"
              onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();">
                {{ __('Выйти') }}
            </a>

            <form id="logout-form" class="logout-form" action="{{ route('logout') }}" method="POST">
                @csrf
            </form>
        </div>
    </div>
  </header>

  <main class="conf-steps">
    <section class="conf-step">
      <header class="conf-step__header conf-step__header_opened">
        <h2 class="conf-step__title">Управление залами</h2>
      </header>
      <div class="conf-step__wrapper">
        @if(count($data))
        <p class="conf-step__paragraph">Доступные залы:</p>
        @endif
        <ul class="conf-step__list">
          @for($i = 0; $i < count($data); $i++)
            <li>{{$data[$i]->name}}
                <button class="conf-step__button conf-step__button-trash" onclick="switchDeletePopup(document.getElementById('hall-delete-popup'), '{{$data[$i]->name}}', {{$data[$i]->id}})"></button>
            </li>
          @endfor
        </ul>
        <button class="conf-step__button conf-step__button-accent" onclick="switchPopup(document.getElementById('hall-add-popup'))">Создать зал</button>
      </div>
    </section>
    
    @if(count($data))
    <section class="conf-step">
      <a class="anchor-link" name="hall-config-section"></a>
      <header class="conf-step__header conf-step__header_opened">
        <h2 class="conf-step__title">Конфигурация залов</h2>
      </header>
      <div class="conf-step__wrapper">
        <p class="conf-step__paragraph">Выберите зал для конфигурации:</p>
        <ul class="conf-step__selectors-box">
          @for($i = 0; $i < count($data); $i++)
            <li><input type="radio" class="conf-step__radio" name="chairs-hall" value="{{$data[$i]->name}}" {{($data[$i]->id == (session()->get('checkedHallConfigTab') ? session()->get('checkedHallConfigTab') : $data[0]->id)) ? 'checked' : null}} onclick="switchHallTabs({{$data[$i]->id}}, 'hall-config')"><span class="conf-step__selector">{{$data[$i]->name}}</span></li>
          @endfor
        </ul>
        
        @for($i = 0; $i < count($data); $i++)
        <div class="hall-config {{($data[$i]->id == (session()->get('checkedHallConfigTab') ? session()->get('checkedHallConfigTab') : $data[0]->id)) ? 'active' : null}}" id="hall-config-{{$data[$i]->id}}">
          <p class="conf-step__paragraph">Укажите количество рядов и максимальное количество кресел в ряду:</p>
          <div class="conf-step__legend">
            <form action="update_seat_count" method="post">
              @csrf
              <label class="conf-step__label">Рядов, шт<input type="number" class="conf-step__input" name="rows" value="{{$data[$i]->rowCount}}"></label>
              <span class="multiplier">x</span>
              <label class="conf-step__label">Мест, шт<input type="number" class="conf-step__input" name="seats" value="{{$data[$i]->seatsCount}}"></label>
              <input type="text" class="conf-step__input" name="id" value="{{$data[$i]->id}}" style="display: none">
              <input type="submit" value="{{($data[$i]->rowCount === 0 || $data[$i]->seatsCount === 0) ? 'Построить зал' : 'Сбросить и перестроить зал'}}" class="conf-step__button conf-step__button-accent" style="margin-left: 20px">
            </form>
          </div>
          @if($data[$i]->rowCount > 0 && $data[$i]->seatsCount > 0)
          <p class="conf-step__paragraph">Теперь вы можете указать типы кресел на схеме зала:</p>
          <div class="conf-step__legend">
            <span class="conf-step__chair conf-step__chair_standart"></span> — обычные кресла
            <span class="conf-step__chair conf-step__chair_vip"></span> — VIP кресла
            <span class="conf-step__chair conf-step__chair_disabled"></span> — заблокированные (нет кресла)
            <p class="conf-step__hint">Чтобы изменить вид кресла, нажмите по нему левой кнопкой мыши</p>
          </div>  

          <div class="conf-step__hall">
            <x-admin.step-hall :hallData="['id' => $data[$i]->id, 'rows' => $data[$i]->rowCount, 'seats' => $data[$i]->seatsCount]"/>
          </div>
          <fieldset class="conf-step__buttons text-center">
            <a class="conf-step__button conf-step__button-regular" href="{{route('admin')}}">Отмена</a>
            <input type="submit" value="Сохранить" 
       class="conf-step__button conf-step__button-accent save-hall-config" 
       onclick="updateHallConfig(this)" 
       data-token="{{csrf_token()}}">

          </fieldset>  
          @endif
        </div>
        @endfor
      </div>  
    </section>
    
    <section class="conf-step">
      <header class="conf-step__header conf-step__header_opened">
        <h2 class="conf-step__title">Конфигурация цен</h2>
      </header>
      <div class="conf-step__wrapper">
        <p class="conf-step__paragraph">Выберите зал для конфигурации:</p>
        <ul class="conf-step__selectors-box">
          @for($i = 0; $i < count($data); $i++)
            <li><input type="radio" class="conf-step__radio" name="prices-hall" value="{{$data[$i]->name}}" {{$i === 0 ? 'checked' : null}} onclick="switchHallTabs({{$data[$i]->id}}, 'hall-price')"><span class="conf-step__selector">{{$data[$i]->name}}</span></li>
          @endfor
        </ul>
          
        @for($i = 0; $i < count($data); $i++)
        <div class="hall-price {{$i === 0 ? 'active' : null}}" id="hall-price-{{$data[$i]->id}}">
          <p class="conf-step__paragraph">Установите цены для типов кресел:</p>
            <div class="conf-step__legend">
              <label class="conf-step__label">Цена, рублей<input type="number" class="conf-step__input" placeholder="0" value="{{$data[$i]->priceStandart}}"></label>
              за <span class="conf-step__chair conf-step__chair_standart"></span> обычные кресла
            </div>  
            <div class="conf-step__legend">
              <label class="conf-step__label">Цена, рублей<input type="number" class="conf-step__input" placeholder="0" value="{{$data[$i]->priceVip}}"></label>
              за <span class="conf-step__chair conf-step__chair_vip"></span> VIP кресла
            </div>  
          
          <fieldset class="conf-step__buttons text-center">
            <a class="conf-step__button conf-step__button-regular" href="{{route('admin')}}">Отмена</a>
            <input type="submit" value="Сохранить" class="conf-step__button conf-step__button-accent save-button" onclick="updateHallPrice(this); this.disabled=true;" data-token="{{csrf_token()}}" data-hall-id="{{$data[$i]->id}}">

          </fieldset>
        </div>
        @endfor
      </div>
    </section>
    
    <section class="conf-step">
      <a class="anchor-link" name="showtime-section"></a>
      <header class="conf-step__header conf-step__header_opened">
        <h2 class="conf-step__title">Сетка сеансов</h2>
      </header>
      <div class="conf-step__wrapper">
        <p class="conf-step__paragraph">
          <button class="conf-step__button conf-step__button-accent" onclick="switchPopup(document.getElementById('movie-add-popup'))">Добавить фильм</button>
        </p>
        <x-admin.step-movies :movies="App\Models\Movie::all()"/>
        
        <div class="conf-step__seances" style="margin-top: 10px">
          <p class="conf-step__paragraph" style="margin: 0">
            <button class="conf-step__button conf-step__button-accent" onclick="switchPopup(document.getElementById('showtime-add-popup'))">Добавить сеанс</button>
          </p>

          @for($i = 0; $i < count($data); $i++)
          <div class="conf-step__seances-hall">
            <h3 class="conf-step__seances-title">{{$data[$i]->name}}</h3>
            <x-admin.showtimes-timeline :showtimes="App\Models\Showtime::where('hall_id', $data[$i]->id)->get()"/>
          </div>
          @endfor
        </div>
      </div>
    </section>
    
    <section class="conf-step">
      <a class="anchor-link" name="hall-activate-section"></a>
      <header class="conf-step__header conf-step__header_opened">
        <h2 class="conf-step__title">Открыть продажи</h2>
      </header>
      <div class="conf-step__wrapper text-center" style="margin-bottom: 70px">
        <p class="conf-step__paragraph">Выберите зал:</p>
        <ul class="conf-step__selectors-box">
          @for($i = 0; $i < count($data); $i++)
            <li><input type="radio" class="conf-step__radio" name="activate-hall" value="{{$data[$i]->name}}" {{($data[$i]->id == (session()->get('checkedHallActivateTab') ? session()->get('checkedHallActivateTab') : $data[0]->id)) ? 'checked' : null}} onclick="switchHallTabs({{$data[$i]->id}}, 'hall-activate')"><span class="conf-step__selector">{{$data[$i]->name}}</span></li>
          @endfor
        </ul>
        @for($i = 0; $i < count($data); $i++)
        <div class="hall-activate {{($data[$i]->id == (session()->get('checkedHallActivateTab') ? session()->get('checkedHallActivateTab') : $data[0]->id)) ? 'active' : null}}" id="hall-activate-{{$data[$i]->id}}" style="padding: 0">
          <form action="hall_activate" method="POST" accept-charset="utf-8">
            @csrf
            <input class="conf-step__input" type="hidden" name="hall_id" value="{{$data[$i]->id}}">
            <button class="conf-step__button conf-step__button-accent" {{$data[$i]->active ? 'style=background-color:crimson' : null}}>{{$data[$i]->active ? 'Закрыть продажу билетов' : 'Открыть продажу билетов'}}</button>
          </form>
        </div>
        @endfor 
      </div>
    </section>
    @endif    
  </main>

  <script src="{{asset('/assets/admin/js/accordeon.js')}}"></script>
  <script src="{{asset('/assets/admin/js/index.js')}}"></script>

  <script>
document.addEventListener("DOMContentLoaded", function() {
    const saveHallConfigButton = document.querySelector(".save-hall-config");
    const savePricesButton = document.querySelector(".save-button");
    const hallSeats = document.querySelector(".conf-step__hall");
    const priceInputs = document.querySelectorAll("input, select, textarea");

    function disableButton(button) {
        if (button) {
            button.disabled = true;
            button.style.backgroundColor = "#ccc";
            button.style.cursor = "not-allowed";
        }
    }

    function enableButton(button) {
        if (button) {
            button.disabled = false;
            button.style.backgroundColor = "";
            button.style.cursor = "pointer";
        }
    }

    if (saveHallConfigButton) {
        disableButton(saveHallConfigButton);
    }
    if (savePricesButton) {
        disableButton(savePricesButton);
    }

    if (hallSeats) {
        hallSeats.addEventListener("click", function() {
            enableButton(saveHallConfigButton);
        });
    }

    priceInputs.forEach(input => {
        input.addEventListener("input", function() {
            enableButton(savePricesButton);
        });
    });

    if (saveHallConfigButton) {
        saveHallConfigButton.addEventListener("click", function() {
            disableButton(saveHallConfigButton);
        });
    }

    if (savePricesButton) {
        savePricesButton.addEventListener("click", function() {
            disableButton(savePricesButton);
        });
    }
});
</script>

<script>
document.getElementById('poster-input-file').addEventListener('change', function(event) {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const preview = document.getElementById('poster-preview');
            preview.src = e.target.result;
            preview.style.display = "block";
            document.querySelector('.select-poster').style.opacity = "0";
        };
        reader.readAsDataURL(file);
    }
});
</script>

</body>
</html>
