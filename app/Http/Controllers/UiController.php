<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Libraries\CommonHelper;
use Carbon\Carbon;

class UiController extends Controller {
  public function showIndex(Request $request){
    $battle_records = DB::table('battle_record')
    ->select('battle_record.*')
    ->get();
    return view('index')->with('battle_records', $battle_records);
  }
  public function getBattleResult(Request $request){
    $data = $request->all();
    $chara1 = $data['chara1'];
    $chara2 = $data['chara2'];

    //进攻方
    $chara1_result = CommonHelper::getBattleResult($chara1, $chara2);
    //反击方
    $chara2_result = CommonHelper::getBattleResult($chara2, $chara1);

    $current_time = Carbon::now();
    $current_timestamp = $current_time->timestamp;

    $result_text = "{$chara1}攻击{$chara2}，物理伤害{$chara1_result['phyical_damage']}，魔法伤害{$chara1_result['magical_damage']}，命中率{$chara1_result['hit_rate']}，暴击率{$chara1_result['critical_rate']} <br/>";
    $result_text = $result_text . "反击，物理伤害{$chara2_result['phyical_damage']}，魔法伤害{$chara2_result['magical_damage']}，命中率{$chara2_result['hit_rate']}，暴击率{$chara2_result['critical_rate']}";

    $battle_result_fields = [
      'chara1' => $chara1,
      'chara2' => $chara2,
      'battle_result' => $result_text,
      'datetime' => $current_timestamp,
    ];

    $insert_result = DB::table('battle_record')
    ->insert($battle_result_fields);

    return redirect('/');
  }
}
