<!DOCTYPE html>
<html lang="ru">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>ИдёмВКино</title>
  <link rel="stylesheet" href="{{asset('assets/client/css/normalize.css')}}">
  <link rel="stylesheet" href="{{asset('assets/client/css/styles.css')}}">
  <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900&amp;subset=cyrillic,cyrillic-ext,latin-ext" rel="stylesheet">
</head>

@includeIf('client.info_popup')

<body>
  <header class="page-header">
    <h1 class="page-header__title"><a href="{{route('/')}}">Идём<span>в</span>кино</a></h1>
  </header>
  
  <main>
    <section class="ticket">
      
      <header class="tichet__check">
        <h2 class="ticket__check-title">Вы выбрали билеты:</h2>
      </header>
      <div class="ticket__info-wrapper">
        <p class="ticket__info">На фильм: <span class="ticket__details ticket__title">{{$paymentData['movieName']}}</span></p>
        <p class="ticket__info">Места: <span class="ticket__details ticket__chairs">{{$paymentData['seats']}}</span></p>
        <p class="ticket__info">В зале: <span class="ticket__details ticket__hall">{{$paymentData['hallName']}}</span></p>
        <p class="ticket__info">Начало сеанса: <span class="ticket__details ticket__start">{{$paymentData['startTime']}}</span></p>
        <p class="ticket__info">Стоимость: <span class="ticket__details ticket__cost">{{$paymentData['sum']}}</span> рублей</p>

        <button class="acceptin-button" onclick="location.href='{{route('ticket', ['showtimeId' => $paymentData['showtimeId'], 'hallConfigIdData' => $paymentData['hallConfigIdData'], 'selectedDate' => $paymentData['selectedDate']])}}'" >Получить код бронирования</button>

        <p class="ticket__hint">После оплаты билет будет доступен в этом окне, а также придёт вам на почту. Покажите QR-код нашему контроллёру у входа в зал.</p>
        <p class="ticket__hint">Приятного просмотра!</p>
      </div>
    </section>     
  </main>
  
</body>
</html>