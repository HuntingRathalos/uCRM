<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

class DecileService
{
  public static function decile($subQuery)
  {
      // 1. 購買ID毎にまとめる
      $subQuery = $subQuery->groupBy('id')
      ->selectRaw('id, customer_id, customer_name, SUM(subtotal) as
      totalPerPurchase');

      // 2. 会員毎にまとめて購入金額順にソートする
      $subQuery = DB::table($subQuery)
      ->groupBy('customer_id')
      ->selectRaw('customer_id, customer_name, sum(totalPerPurchase)
      as total')
      ->orderBy('total', 'desc');

      // 一部のデータベース操作文は値を返しません。こうしたタイプの操作では、DBファサードでstatementメソッドを使用します。
      // set @変数名 = 値 (mysqlの書き方)
      // 3. 購入順に連番を振る
      DB::statement('set @row_num = 0;');
      $subQuery = DB::table($subQuery)
      ->selectRaw('
      @row_num:= @row_num+1 as row_num,
      customer_id,
      customer_name,
      total');

      // 4. 全体の件数を数え、1/10の値や合計金額を取得
      $count = DB::table($subQuery)->count();
      $total = DB::table($subQuery)->selectRaw('sum(total) as total')->get();
      $total = $total[0]->total;
      $decile = ceil($count / 10);

      $bindValues = [];
      $tempValue = 0;
      for($i = 1; $i <= 10; $i++)
      {
      array_push($bindValues, 1 + $tempValue);
      $tempValue += $decile;
      array_push($bindValues, 1 + $tempValue);
      }

      // 5 10分割しグループ毎に数字を振る
      DB::statement('set @row_num = 0;');
      $subQuery = DB::table($subQuery)
      ->selectRaw("
          row_num,
          customer_id,
          customer_name,
          total,
          case
              when ? <= row_num and row_num < ? then 1
              when ? <= row_num and row_num < ? then 2
              when ? <= row_num and row_num < ? then 3
              when ? <= row_num and row_num < ? then 4
              when ? <= row_num and row_num < ? then 5
              when ? <= row_num and row_num < ? then 6
              when ? <= row_num and row_num < ? then 7
              when ? <= row_num and row_num < ? then 8
              when ? <= row_num and row_num < ? then 9
              when ? <= row_num and row_num < ? then 10
          end as decile
          ", $bindValues); // SelectRaw第二引数にバインドしたい数値(配列)をいれる

      // 6. グループ毎の合計・平均
      $subQuery = DB::table($subQuery)
      ->groupBy('decile')
      ->selectRaw('decile,
      round(avg(total)) as average,
      sum(total) as totalPerGroup');

      // 構成比を出すために変数を使う
      // 7 構成比
      DB::statement("set @total = ${total} ;");
      $data = DB::table($subQuery)
      ->selectRaw('decile,
      average,
      totalPerGroup,
      round(100 * totalPerGroup / @total, 1) as
      totalRatio
      ')
      ->get();

       // Chart.js用にデータを配列に加工
      $labels = $data->pluck('decile');
      $totals = $data->pluck('totalPerGroup');

      //複数の変数を渡すので一旦配列に入れる
      return [$data, $labels, $totals ];
  }
}
