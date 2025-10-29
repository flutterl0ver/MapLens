<head>
    <style>
        html {
            font-family: 'Bounded ExtraLight';
        }

        table {
            width: 90%;
            margin: 60px auto 0 auto;
            border-radius: 10px;
        }

        th {
            background-color: #7874E7;
            color: white;
            padding: 10px;
        }

        tr {
            background-color: #E5E2E6;
        }

        th.left {
            border-radius: 16px 0 0 16px;
        }

        th.right {
            border-radius: 0 16px 16px 0;
        }

        td {
            text-align: center;
        }
    </style>
</head>

<?php
    function cropImageForPdf($sourcePath, $destPath, $cropOptions) {
        $image = imagecreatefrompng($sourcePath);

        $newWidth = $cropOptions['width'];
        $newHeight = $cropOptions['height'];
        $x = $cropOptions['x'] ?? 0;
        $y = $cropOptions['y'] ?? 0;

        $cropped = imagecrop($image, [
            'x' => $x,
            'y' => $y,
            'width' => $newWidth,
            'height' => $newHeight
        ]);

        imagepng($cropped, $destPath);
        imagedestroy($image);
        imagedestroy($cropped);
    }
?>

@if($rects)
    <table>
        <tr style="height: 61px">
            <th style="width: 50px" class="left">№</th>
            <th style="width: 130px">Размер расхождения</th>
            <th class="right">Изображение</th>
        </tr>
        <?php $i = 0 ?>
        @foreach($rects as $diff)
            <tr style="height: 330px; @if($i % 2 == 1) background-color: #D7D2D8 @endif">
                <td>{{ $i + 1 }}</td>
                <td>{{ $diff[1] }} пикс.</td>
                    <?php
                    $rect = $diff[0];
                    $imgSize = getimagesize("maps/$uid-1.png");

                    $x = ($rect[0][0] + $rect[1][0]) / 2 - 150;
                    $y = ($rect[0][1] + $rect[1][1]) / 2 - 150;

                    $x = max($x, 0);
                    $y = max($y, 0);

                    $x = min($x, $imgSize[0] - 300);
                    $y = min($y, $imgSize[1] - 300);

                    if($isPdf) {
                        cropImageForPdf("maps/$uid-1.png", $i * 2 . '.png', [
                            'x' => $x,
                            'y' => $y,
                            'width' => 300,
                            'height' => 300
                        ]);
                        cropImageForPdf("maps/$uid-2.png", $i * 2 + 1 . '.png', [
                            'x' => $x,
                            'y' => $y,
                            'width' => 300,
                            'height' => 300
                        ]);
                    }
                    ?>
                <td style="display: flex; flex-direction: row; justify-content: space-evenly; padding: 15px">
                    @if($isPdf)
                        <img alt src="{{ $i * 2 }}.png" style="width: 300px; height: 300px; border-radius: 25px">
                        <img alt src="{{ $i * 2 + 1 }}.png" style="width: 300px; height: 300px; border-radius: 25px">
                    @else
                        <img alt src="../maps/{{ $uid }}-1.png" style="width: 300px; height: 300px; border-radius: 25px; object-fit: none; object-position: {{ -$x }}px {{ -$y }}px">
                        <img alt src="../maps/{{ $uid }}-2.png" style="width: 300px; height: 300px; border-radius: 25px; object-fit: none; object-position: {{ -$x }}px {{ -$y }}px">
                    @endif
                </td>
            </tr>
            <?php $i++ ?>
        @endforeach
    </table>
@endif
