<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">

</head>
<body>
    <?php
        $python = dirname(getenv('AppData')) . '\Local\Programs\Python\Python314\python.exe';
        $file = dirname(getcwd()) . '\mapsComparingService\main.py';
        $output = shell_exec($python . ' ' . $file);
        $result = json_decode($output);
        echo $output;
        ?>
</body>
</html>
