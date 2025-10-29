@php use App\Models\Legend;use App\Models\Result; @endphp

    <!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <title>Результаты сравнения</title>
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
        <div class="diffText" id="diffText">Размер изменения: 0 пикс.</div>
    </div>
</div>

<div class="body">
    <?php
    $result = Result::where('id', $uid)->first();

    if ($result) {
        $rects = json_decode($result->rects);
        $legend = Legend::where('id', $result->legend)->first();
    }
    ?>

    @if($legend)
        <div style="margin-left: 40px; margin-bottom: 20px">
            ID легенды: {{ $legend->id }}
        </div>
    @endif
    <div style="display: flex; flex-direction: column; align-items: center">
        <div class="mapContainer">
            <div id="map">
                <img class="map" src="{{ asset("maps/$uid-2.png") }}" alt/>

                @if($rects)
                    @foreach($rects as $diff)
                            <?php $rect = $diff[0]; $area = $diff[1] ?>
                        <div class="diff" style="
                    left: {{ $rect[0][0] }}px;
                    top: {{ $rect[0][1] }}px;
                    width: {{ $rect[1][0] - $rect[0][0] }}px;
                    height: {{ $rect[1][1] - $rect[0][1] }}px;
                    "
                             onclick="openDiff({{ $rect[0][0] }}, {{ $rect[0][1] }}, {{ $rect[1][0] }}, {{ $rect[1][1] }}, {{ $area }})">
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
    <br>

    @if(count($rects) > 0)
        <span style="font-size: 36px; margin-top: 20px; margin-left: 40px">Результаты сравнения</span>
        <button class="pdf" onclick="window.location.replace('/report/{{ $uid }}')">Сохранить результат</button>

        <?php $isPdf = false ?>
        @include('components/diffTable')
    @endif
</div>
</body>
</html>
