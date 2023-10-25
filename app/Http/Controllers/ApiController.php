<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ApiController extends Controller {

  /* Show Status, Item and Spt */
  public function showStatus(Request $request){
    $chara = $request->get('chara');
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

    return response()->json($status_info);
  }

  public function startBattle(Request $request){
    $chara1 = $request->get('chara1');
    $chara2 = $request->get('chara2');

    $chara1_status = DB::table('zh')
    ->select('zh.*')
    ->where('zh.zh', $chara1)
    ->first();

    $chara2_status = DB::table('zh')
    ->select('zh.*')
    ->where('zh.zh', $chara2)
    ->first();

    //$phyical_damage =
    return response()->json($chara1_status);
  }

  public function updateIngredient($id, Request $request){
    $data = $request->json();
    $token = $data->get('token');

    $tokenStatus = AuthHelper::getTokenStatus($token);

    //If the token is not ok, return error
    if($tokenStatus['code'] !== 200){
      return response()->json($tokenStatus, $tokenStatus['code']);
    }

    $updated_ingredient_info = $data->get('ingredientInfo');

    $updated_ingredient_fields = [
      'name' => $updated_ingredient_info['ingredientName'],
      'description' => $updated_ingredient_info['ingredientDescription'],
      'image' => $updated_ingredient_info['ingredientPhoto'],
      'category' => implode(',', $updated_ingredient_info['categories']),
      'status' => $updated_ingredient_info['published'],
      'regular_price' => $updated_ingredient_info['regularPrice'],
    ];

    $updated_ingredient = DB::table('ingredient')
    ->where('id', $id)
    ->update($updated_ingredient_fields);

    $updated_result = [
      'result' =>'Success',
      'updated_object' => $updated_ingredient_info,
    ];
    return response()->json($updated_result, 200);
  }
}
