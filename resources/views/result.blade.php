@php use App\Models\Result; @endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="{{ asset('css/result.css') }}">
</head>
<body>
    @include('components/header')

    <div class="mapContainer">
        <img src="{{ asset("maps/$uid-1.png") }}" alt/>

        <?php
            $result = Result::where('id', $uid)->first();
            $rects = json_decode($result->rects);
        ?>

        @if($rects)
            @foreach($rects as $rect)
                <div class="diff" style="
                left: {{ $rect[0][0] }}px;
                top: {{ $rect[0][1] }}px;
                width: {{ $rect[1][0] - $rect[0][0] }}px;
                height: {{ $rect[1][1] - $rect[0][1] }}px;
                " onmouseenter="">
                </div>
            @endforeach
        @endif
    </div>
</body>
</html>
