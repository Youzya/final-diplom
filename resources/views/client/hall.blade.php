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
@if ($errors->any())
  @includeIf('client.alert_popup')
@endif

<body>
  <header class="page-header">
    <h1 class="page-header__title"><a href="{{route('/')}}">Идём<span>в</span>кино</a></h1>
  </header>
  <main>
    <section class="buying">
      <x-client.hall-buying-info :showtime="$showtime"/>
      <x-client.hall-buying-scheme :showtime="$showtime" :selectedDate="$selectedDate"/>
      <button class="acceptin-button" onclick="showInfoPopup('Сообщение:', 'Сначала выберете места!')" data-showtime="{{$showtime->id}}" data-selected-date="{{$selectedDate}}" style="cursor: pointer">Забронировать</button>
    </section>     
  </main>
  
  <script src="{{asset('/assets/client/js/index.js')}}"></script>
</body>
</html>