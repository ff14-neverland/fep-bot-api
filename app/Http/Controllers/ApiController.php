<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Libraries\CommonHelper;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ApiController extends Controller {

  public function exportData(Request $request){
    $charas = CommonHelper::loadAllChara();
    $rows = [];
    $header = [
      '名称' => 'string',
      'HP' =>'string',
      '力量' =>'string',
      '魔力' =>'string',
      '技巧' =>'string',
      '幸运' =>'string',
      '速度' =>'string',
      '防御' =>'string',
      '魔防' =>'string',
      '支援' =>'string',
      '其他' =>'string'
    ];

    foreach($charas as $chara){
      $row = [
        $chara['名称'],
        $chara['HP'],
        $chara['力量'],
        $chara['魔力'],
        $chara['幸运'],
        $chara['速度'],
        $chara['防御'],
        $chara['魔防'],
        $chara['支援'],
        $chara['其他'],
      ];
      $rows[] = $row;
    }

    $sheet = array(
      'header' => $header,
      'rows' => $rows,
    );
    $sheet_name = 'FEP_EXPORT';
    $writer = new \XLSXWriter();
    $writer->writeSheetHeader(
      $sheet_name,
      $sheet['header'],
      [],
    );
    foreach ($sheet['rows'] as $row) {
      $writer->writeSheetRow($sheet_name, $row);
    }
    $filename = 'FEP匯出數據.xlsx';
    $xlsx_string = $writer->writeToString();
    header('Content-disposition: attachment; filename="'. $filename .'"');
    header('Content-type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Length: ' . strlen($xlsx_string));
    header('Content-Transfer-Encoding: binary');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    exit($xlsx_string);
    //return response()->json($charas);
  }

  /* Show Status, Item and Spt */
  public function showStatus(Request $request){
    $chara = $request->get('chara');
    $status_info = CommonHelper::loadCharaStatus($chara);
    return response()->json($status_info);
  }

  public function startBattle(Request $request){
    $chara1 = $request->get('chara1');
    $chara2 = $request->get('chara2');

    //进攻方
    $chara1_result = CommonHelper::getBattleResult($chara1, $chara2);
    //反击方
    $chara2_result = CommonHelper::getBattleResult($chara2, $chara1);

    $battle_result = [
      'chara1' => $chara1_result,
      'chara2' => $chara2_result,
    ];
    return response()->json($battle_result);
  }

  public function levelUp(Request $request){
    $chara = $request->get('chara');
    $level_up_result = CommonHelper::getLevelUpResult($chara);

    return response()->json($level_up_result);
  }

  public function updateCharaInfo(Request $request){
    $data = $request->json();
    //角色名
    $chara = $data->get('chara');
    //類型
    $type = $data->get('type');
    //文字
    $text = $data->get('text');

    $update_result = CommonHelper::updateInfo($chara, $type, $text);

    return response()->json($update_result);
  }
}
