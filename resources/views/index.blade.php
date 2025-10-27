<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
</head>
<body>
    @include('components/header')
    <form method="POST" action="/result" enctype="multipart/form-data">
        @csrf
        <input type="file" accept="image/*" name="map1"/>
        <input type="file" accept="image/*" name="map2"/>
        <input type="submit"/>
    </form>
</body>
</html>
