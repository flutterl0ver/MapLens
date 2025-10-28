@php use App\Models\Result; @endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/result.css') }}">
    <script src="{{ asset('js/result.js') }}"></script>
</head>
<body>
    @include('components/header')

    <div class="darkBg" id="darkBg" onclick="closeDiff()"></div>
    <div class="diffPanel" id="diffPanel">
        <button class="close" onclick="closeDiff()"></button>
        <div class="diffInfo">
            <div class="diffImages">
                <div id="diffImg1" class="diffImage" style="background-image: url('../maps/{{ $uid }}-1.png')"></div>
                <div id="diffImg2" class="diffImage" style="background-image: url('../maps/{{ $uid }}-2.png')"></div>
            </div>
            <div class="diffText"></div>
        </div>
    </div>
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
                " onclick="openDiff({{ $rect[0][0] }}, {{ $rect[0][1] }}, {{ $rect[1][0] }}, {{ $rect[1][1] }})">
                </div>
            @endforeach
        @endif
    </div>
</body>
</html>
