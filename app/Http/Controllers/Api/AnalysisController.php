<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Order;
use Illuminate\Support\Facades\DB;
use App\Services\AnalysisService;
use App\Services\DecileService;
use App\Services\RFMService;

class AnalysisController extends Controller
{
    public function index(Request $request)
    {
        $subQuery = Order::betweenDate($request->startDate, $request->endDate);
        if($request->type === 'perDay')
        {
            list($data, $labels, $totals) = AnalysisService::perDay($subQuery);
        }
        if($request->type === 'perMonth')
        {
            list($data, $labels, $totals) = AnalysisService::perMonth($subQuery);
        }
        if($request->type === 'perYear')
        {
            list($data, $labels, $totals) = AnalysisService::perYear($subQuery);
        }
        if($request->type === 'decile')
        {
            list($data, $labels, $totals) = AnalysisService::decile($subQuery);
        }
        if($request->type === 'rfm')
        {
            list($data, $totals, $eachCount) = RFMService::decile($subQuery, $request->rfmRrms);

            return response()->json([
                'data' => $data,
                'type' => $request->type,
                'eachCount' => $eachCount,
                'totals' => $totals,
            ],
        }


        return response()->json([
            'data' => $data,
            'type' => $request->type,
            'labels' => $labels,
            'totals' => $totals,
        ],
        Response::HTTP_OK);
    }
}
