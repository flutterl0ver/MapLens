<?php

namespace App\Http\Controllers;

use App\Models\Legend;
use Illuminate\Http\Request;

class LoadLegendController extends Controller
{
    public function __invoke(Request $request)
    {
        $legendId = $request->post('legendId');
        $legend = Legend::where('id', $legendId)->first();
        $legendDict = null;
        if ($legend) $legendDict = json_decode($legend->legend);

        return redirect('/')->with(['legend' => $legendDict]);
    }
}
