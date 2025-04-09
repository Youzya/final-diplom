
<a class="{{$showtimeDate['class']}}" href="{{route('/', ['date' => $showtimeDate['date']])}}">
    <span class="page-nav__day-week">{{$showtimeDate['weekday']}}</span><span class="page-nav__day-number">{{$showtimeDate['mday']}}</span>
</a>