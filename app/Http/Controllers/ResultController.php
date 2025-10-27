<?php

namespace App\Http\Controllers;

use App\Models\Result;
use Illuminate\Http\Request;
use phpDocumentor\Reflection\File;

class ResultController extends Controller
{
    public function __invoke(Request $request)
    {
        $img1 = $_FILES['map1'];
        $img2 = $_FILES['map2'];

        $result = Result::create();

        $this->writeImg($img1, $result->id, 1);
        $this->writeImg($img2, $result->id, 2);

        $pythonPath = dirname(getenv('AppData')) . '\Local\Programs\Python\Python314\python.exe';
        $filePath = dirname(getcwd()) . '\mapsComparingService\main.py';
        $output = shell_exec($pythonPath . ' ' . $filePath);

        $result->rects = $output;
        $result->save();

        return redirect('result/' . $result->id);
    }

    private function writeImg(array $img, string $uid, int $index)
    {
        $ext = pathinfo($img['name'], PATHINFO_EXTENSION);
        move_uploaded_file($img['tmp_name'], "maps/{$uid}-{$index}.{$ext}");
    }
}
