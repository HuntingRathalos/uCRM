<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

class AnalysisService
{
  public static function perDay($subQuery)
  {
    $query =  $subQuery->where('status', true)->groupBy('id')
    ->selectRaw('SUM(subtotal) AS totalPerPurchase, DATE_FORMAT(created_at, "%Y%m%d") AS date')
    ->groupBy('date');

    $data = DB::table($query)
    ->groupBy('date')
    ->selectRaw('date, sum(totalPerPurchase) as total')
    ->get();

    // Chart.js用にデータを配列に加工
    $labels = $data->pluck('date');
    $totals = $data->pluck('total');

    //複数の変数を渡すので一旦配列に入れる
    return [$data, $labels, $totals ];
  }

  public static function perMonth($subQuery)
  {
    $query =  $subQuery->where('status', true)->groupBy('id')
    ->selectRaw('SUM(subtotal) AS totalPerPurchase, DATE_FORMAT(created_at, "%Y%m") AS date')
    ->groupBy('date');

    $data = DB::table($query)
    ->groupBy('date')
    ->selectRaw('date, sum(totalPerPurchase) as total')
    ->get();

    // Chart.js用にデータを配列に加工
    $labels = $data->pluck('date');
    $totals = $data->pluck('total');

    //複数の変数を渡すので一旦配列に入れる
    return [$data, $labels, $totals ];
  }

  public static function perYear($subQuery)
  {
    $query =  $subQuery->where('status', true)->groupBy('id')
    ->selectRaw('SUM(subtotal) AS totalPerPurchase, DATE_FORMAT(created_at, "%Y") AS date')
    ->groupBy('date');

    $data = DB::table($query)
    ->groupBy('date')
    ->selectRaw('date, sum(totalPerPurchase) as total')
    ->get();

    // Chart.js用にデータを配列に加工
    $labels = $data->pluck('date');
    $totals = $data->pluck('total');

    //複数の変数を渡すので一旦配列に入れる
    return [$data, $labels, $totals ];
  }
}
