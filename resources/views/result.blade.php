@php use App\Models\Result; @endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="{{ asset('css/result.css') }}">
</head>
<body onfocus="console.log('aaa')">
    <div style="display: inline-block; position: relative">
        <img src="{{ asset("maps/$uid-1.png") }}" alt/>

        <?php
            $result = Result::where('id', $uid)->first();
            $rects = json_decode($result->rects);
        ?>

        @foreach($rects as $rect)
            <div class="diff" style="
            left: {{ $rect[0][0][0] }}px;
            top: {{ $rect[0][0][1] }}px;
            width: {{ $rect[0][1][0] - $rect[0][0][0] }}px;
            height: {{ $rect[0][1][1] - $rect[0][0][1] }}px;
            " onmouseenter="">
            </div>
        @endforeach
    </div>
</body>
</html>
