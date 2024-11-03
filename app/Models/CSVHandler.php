<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CSVHandler extends Model
{
    public static function parseCSV($file)
    {
        $courses = [];

        // シフトJISエンコーディングでファイルを読み込み
        if (($handle = fopen($file->getRealPath(), 'r')) !== false) {
            while (($data = fgetcsv($handle, 1000, ',', '"')) !== false) {
                $data = array_map(function ($value) {
                    return mb_convert_encoding($value, 'UTF-8', 'SJIS-win');
                }, $data);

                // 必要な列から科目コードと単位数を取得
                $courseCode = $data[2] ?? '';   // 3列目: 科目コード
                $units = isset($data[4]) ? (float)$data[4] : 0;   // 5列目: 単位数
                $evaluation = $data[7] ?? '';   // 8列目: 総合評価

                // 評価がA+, A, B, C, P, 認の場合、取得単位として認定
                if (in_array($evaluation, ['A+', 'A', 'B', 'C', 'P', '認'])) {
                    $courses[] = ['code' => $courseCode, 'units' => $units];
                    error_log("取得単位として追加: 科目コード: $courseCode, 単位: $units, 評価: $evaluation");
                } else {
                    error_log("単位未取得の科目: 科目コード: $courseCode, 評価: $evaluation");
                }
            }
            fclose($handle);
        } else {
            error_log("ファイルを開けませんでした。");
        }

        return $courses;
    }
}
