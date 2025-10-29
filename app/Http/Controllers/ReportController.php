<?php

namespace App\Http\Controllers;

use App\Models\Result;

class ReportController extends Controller
{
    public static function constructReport(string $requestUid)
    {
        $result = Result::where('id', $requestUid)->first();
        $html = view('components.diffTable', ['rects' => json_decode($result->rects), 'uid' => $requestUid, 'isPdf' => true])->render();
        $fileName = "map_report_{$requestUid}.pdf}";

        $mpdf = new \Mpdf\Mpdf(['orientation' => 'L']);
        $mpdf->WriteHTML($html);
        $mpdf->Output();
    }
}
