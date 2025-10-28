<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <title>Сравнить карты</title>
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
</head>
<body>
    @include('components/header')

    <form method="POST" action="/result" enctype="multipart/form-data">
        @csrf

        <div class="formContainer">
            <div class="imagesContainer">
                <div class="selectImg" onclick="chooseFile('map1')">
                    <span class="select" id="map1Hint">Загрузите изображение</span>
                    <img class="preview" id="map1Preview" alt src="#">
                    <button class="delete" type="button" onclick="deleteImage(1)">
                        <img src="{{ asset('img/delete.png') }}" style="height: 100%; width: 100%" alt>
                    </button>
                </div>

                <div class="selectImg" onclick="chooseFile('map2')">
                    <span class="select" id="map2Hint">Загрузите изображение</span>
                    <img class="preview" id="map2Preview" alt src="#">
                    <button class="delete" type="button" onclick="deleteImage(2)">
                        <img src="{{ asset('img/delete.png') }}" style="height: 100%; width: 100%" alt>
                    </button>
                </div>
            </div>

            <span class="legend">Легенда карты:</span>
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
