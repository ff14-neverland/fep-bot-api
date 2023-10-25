<?php
namespace App\Libraries;
use Illuminate\Support\Facades\DB;

class BattleHelper {
  public static function loadCharaStatus($chara){
    $chara_status = DB::table('zh')
    ->select('zh.*')
    ->where('zh.zh', $chara)
    ->first();
    $status_info = [
      '名称' => $chara_status->zh,
      'HP' => $chara_status->hp,
      '力量' => $chara_status->ll,
      '魔力' => $chara_status->ml,
      '技巧' => $chara_status->jq,
      '幸运' => $chara_status->xy,
      '速度' => $chara_status->sd,
      '防御' => $chara_status->fy,
      '魔防' => $chara_status->mf,
      '支援' => $chara_status->zy,
      '其他' => $chara_status->qtxx,
    ];
    return $status_info;
  }

  public static function getBattleResult($chara1, $chara2){
    $chara1_status = DB::table('zh')
    ->select('zh.*')
    ->where('zh.zh', $chara1)
    ->first();

    $chara2_status = DB::table('zh')
    ->select('zh.*')
    ->where('zh.zh', $chara2)
    ->first();

    //物理伤害：A力量-B防御，最小0
    $phyical_damage = $chara1_status->ll - $chara2_status->fy;
    if($phyical_damage < 0){
      $phyical_damage = 0;
    }
    //魔法伤害：A魔力-B魔防，最小0
    $magical_damage = $chara1_status->ml - $chara2_status->mf;
    if($magical_damage < 0){
      $magical_damage = 0;
    }
    //命中率：（A技巧-B速度）*10 +80，最大100，最小0
    $hit_rate = ($chara1_status->jq - $chara2_status->sd) * 10 + 80;
    if($hit_rate < 0){
      $hit_rate = 0;
    }elseif($hit_rate > 100){
      $hit_rate = 100;
    }
    //暴击率：（A技巧*5 + A幸运*3 - B幸运*10 + 10），最大100，最小0
    $critical_rate = (($chara1_status->jq * 5) + ($chara1_status->xy * 3)) - ($chara2_status->xy * 10) + 10;
    if($critical_rate < 0){
      $critical_rate = 0;
    }elseif($critical_rate > 100){
      $critical_rate = 100;
    }

    //追击：如果A速度-B速度≥5 不追击：如果A速度-B速度＜5，这两条只选择显示一种。
    $pursue = FALSE;
    if($chara1_status->sd - $chara2_status->sd >= 5){
      $pursue = TRUE;
    }

    $battle_result = [
      'phyical_damage' => $phyical_damage,
      'magical_damage' => $magical_damage,
      'hit_rate' => $hit_rate,
      'critical_rate' => $critical_rate,
      'pursue' => $pursue,
    ];
    return $battle_result;
  }
}
