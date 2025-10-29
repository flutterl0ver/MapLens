<?php

namespace App\Http\Controllers;

use App\Models\Legend;
use App\Models\Result;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

class ResultController extends Controller
{
    public function __invoke(Request $request)
    {
        $img1 = $_FILES['map1'];
        $img2 = $_FILES['map2'];

        $colorsCount = $request->post('colorsCount');
        $legend = [];
        for ($i = 0; $i < $colorsCount; $i++)
        {
            $firstColor = $request->post('legendFirstColor'.$i);
            $secondColor = $request->post('legendSecondColor'.$i);
            $name = $request->post('legendName'.$i);
            $legend[] = [$firstColor, $secondColor, $name];
        }
        $legendArg = json_encode($legend, JSON_UNESCAPED_UNICODE);

        $legend = Legend::create(['legend' => $legendArg]);
        $result = Result::create();

        file_put_contents('legends/' . $legend->id . '.txt', $legendArg);

        $this->writeImg($img1, $result->id, 1);
        $this->writeImg($img2, $result->id, 2);

        $pythonPath = Config::get('constants.PYTHONPATH');
        $filePath = dirname(getcwd()) . '\mapsComparingService\main.py';
        $output = shell_exec("$pythonPath $filePath $result->id $legend->id");

        $result->rects = $output;
        $result->legend = $legend->id;
        $result->save();

        return redirect('result/' . $result->id);
    }

    private function writeImg(array $img, string $uid, int $index)
    {
        $ext = pathinfo($img['name'], PATHINFO_EXTENSION);
        move_uploaded_file($img['tmp_name'], "maps/{$uid}-{$index}.{$ext}");
    }
}
