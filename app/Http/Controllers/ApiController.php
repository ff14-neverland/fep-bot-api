<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Libraries\BattleHelper;

class ApiController extends Controller {

  /* Show Status, Item and Spt */
  public function showStatus(Request $request){
    $chara = $request->get('chara');
    $status_info = BattleHelper::loadCharaStatus($chara);
    return response()->json($status_info);
  }

  public function startBattle(Request $request){
    $chara1 = $request->get('chara1');
    $chara2 = $request->get('chara2');

    //进攻方
    $chara1_result = BattleHelper::getBattleResult($chara1, $chara2);
    //反击方
    $chara2_result = BattleHelper::getBattleResult($chara2, $chara1);
    
    $battle_result = [
      'chara1' => $chara1_result,
      'chara2' => $chara2_result,
    ];

    return response()->json($battle_result);
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
