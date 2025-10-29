<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <title>Сравнить карты</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
</head>
<body>
    @include('components/header')

    <div class="body">
        <?php
            $baseLegend = [
                ['#FF5500', '#FF5500', 'Зона застройки среднеэтажными домами'],
                ['#FFAA01', '#FFAA01', 'Зона застройки малоэтажными домами'],
                ['#FFE131', '#FFE131', 'Зона застройки индивидуальными жилыми домами']
            ];
            if(session()->get('legend')) $baseLegend = session()->get('legend');

            $colorsCount = count($baseLegend);
        ?>
        <script>let colorsCount = {{ $colorsCount }}</script>

        <span id="loading">Загрузка...</span>

        <form method="POST" action="/legend" onsubmit="startSearch()" id="legendForm">
            @csrf
            <input class="legend" type="text" name="legendId" placeholder="Введите ID легенды...">
        </form>

        <form method="POST" action="/result" enctype="multipart/form-data" id="form" onsubmit="startSearch()">
            @csrf

            <div class="formContainer">
                <div style="display: flex; flex-direction: column; align-items: center">
                    <input class="compare" type="submit" value="Сравнить"/>
                </div>
                <div class="imagesContainer">
                    <div class="selectImg" onclick="chooseFile('map1')">
                        <div class="hint" id="map1Hint">
                            <img class="upload" src="{{ asset('img/upload.png') }}" alt>
                            <span>Загрузите изображение в формате .png или .jpg</span>
                        </div>
                        <img class="preview" id="map1Preview" alt src="#">
                        <button class="delete" type="button" onclick="deleteImage(1)">
                            <img src="{{ asset('img/delete.png') }}" style="height: 100%; width: 100%" alt>
                        </button>
                    </div>

                    <div class="selectImg" onclick="chooseFile('map2')">
                        <div class="hint" id="map2Hint">
                            <img class="upload" src="{{ asset('img/upload.png') }}" alt>
                            <span>Загрузите изображение в формате .png или .jpg</span>
                        </div>
                        <img class="preview" id="map2Preview" alt src="#">
                        <button class="delete" type="button" onclick="deleteImage(2)">
                            <img src="{{ asset('img/delete.png') }}" style="height: 100%; width: 100%" alt>
                        </button>
                    </div>
                </div>

                <span class="legend">Добавьте значения для легенды карты</span>

                <div class="legend" id="legendContainer">
                    <?php $i = 0 ?>
                    @foreach($baseLegend as $entry)
                        <div class="legendEntry">
                            <div class="color" id="firstColor{{ $i }}" style="background-color: {{ $entry[0] }}" onclick="startChangingColor('legendFirstColor{{ $i }}')"></div>
                            <input value="{{ $entry[0] }}" type="text" hidden name="legendFirstColor{{ $i }}" id="legendFirstColor{{ $i }}" onfocusout="applyColor('legendFirstColor{{ $i }}', 'firstColor{{ $i }}')">

                            <textarea name="legendName{{ $i }}">{{ $entry[2] }}</textarea>

                            <input value="{{ $entry[1] }}" type="text" hidden name="legendSecondColor{{ $i }}" id="legendSecondColor{{ $i }}" onfocusout="applyColor('legendSecondColor{{ $i }}', 'secondColor{{ $i }}')">
                            <div class="color" id="secondColor{{ $i }}" style="background-color: {{ $entry[1] }}" onclick="startChangingColor('legendSecondColor{{ $i }}')"></div>
                        </div>
                            <?php $i++ ?>
                    @endforeach
                </div>
                <button type="button" class="add" onclick="addLegendEntry()"></button>

                <input type="hidden" value="{{ $colorsCount }}" name="colorsCount" id="colorsCount">
            </div>

            <input type="file" accept="image/*" name="map1" id="map1" hidden/>
            <input type="file" accept="image/*" name="map2" id="map2" hidden/>
        </form>
    </div>

    <script src="{{ asset('js/index.js') }}"></script>
</body>
</html>
