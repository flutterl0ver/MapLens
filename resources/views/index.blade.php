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

    <?php
        $baseLegend = [
            ['#FF5500', 'Зона застройки среднеэтажными домами'],
            ['#FFAA01', 'Зона застройки малоэтажными домами'],
            ['#FFE131', 'Зона застройки индивидуальными жилыми домами']
        ];

        $colorsCount = count($baseLegend);
    ?>

    <form method="POST" action="/result" enctype="multipart/form-data">
        @csrf

        <div class="formContainer">
            <div class="imagesContainer">
                <div class="selectImg" onclick="chooseFile('map1')">
                    <div class="hint" id="map1Hint">
                        <span>Загрузите изображение в формате .png или .jpg</span>
                        <img class="upload" src="{{ asset('img/upload.png') }}" alt>
                    </div>
                    <img class="preview" id="map1Preview" alt src="#">
                    <button class="delete" type="button" onclick="deleteImage(1)">
                        <img src="{{ asset('img/delete.png') }}" style="height: 100%; width: 100%" alt>
                    </button>
                </div>

                <div class="selectImg" onclick="chooseFile('map2')">
                    <div class="hint" id="map2Hint">
                        <span>Загрузите изображение в формате .png или .jpg</span>
                        <img class="upload" src="{{ asset('img/upload.png') }}" alt>
                    </div>
                    <img class="preview" id="map2Preview" alt src="#">
                    <button class="delete" type="button" onclick="deleteImage(2)">
                        <img src="{{ asset('img/delete.png') }}" style="height: 100%; width: 100%" alt>
                    </button>
                </div>
            </div>

            <span class="legend">Легенда карты:</span>
            <div class="legend">
                <?php $i = 0 ?>
                @foreach($baseLegend as $entry)
                    <div class="legendEntry">
                        <div class="color" id="firstColor{{ $i }}" style="background-color: {{ $entry[0] }}" onclick="startChangingColor('legendFirstColor{{ $i }}')"></div>
                        <input value="{{ $entry[0] }}" type="text" hidden name="legendFirstColor{{ $i }}" id="legendFirstColor{{ $i }}" onfocusout="applyColor('legendFirstColor{{ $i }}', 'firstColor{{ $i }}')">

                        <textarea name="legendName{{ $i }}">{{ $entry[1] }}</textarea>

                        <div class="color" id="secondColor{{ $i }}" style="background-color: {{ $entry[0] }}" onclick="startChangingColor('legendSecondColor{{ $i }}')"></div>
                        <input value="{{ $entry[0] }}" type="text" hidden name="legendSecondColor{{ $i }}" id="legendSecondColor{{ $i }}" onfocusout="applyColor('legendSecondColor{{ $i }}', 'secondColor{{ $i }}')">
                    </div>
                    <?php $i++ ?>
                @endforeach
            </div>

            <input type="hidden" value="{{ $colorsCount }}" name="colorsCount" id="colorsCount">
        </div>

        <input type="file" accept="image/*" name="map1" id="map1" hidden/>
        <input type="file" accept="image/*" name="map2" id="map2" hidden/>

        <div style="display: flex; flex-direction: column; align-items: flex-end">
            <input type="submit" value="Сравнить"/>
        </div>
    </form>

    <script src="{{ asset('js/index.js') }}"></script>
</body>
</html>
