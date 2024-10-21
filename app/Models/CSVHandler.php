<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CSVHandler extends Model
{
    /**
     * CSVファイルを解析し、履修科目のリストを返す
     */
    public static function parseCSV($file)
    {
        $courses = [];
        if (($handle = fopen($file->getRealPath(), 'r')) !== false) {
            while (($data = fgetcsv($handle, 1000, ',')) !== false) {
                // CSVの1行ごとに科目情報を追加
                $courses[] = [
                    'code' => $data[0], // 科目コード
                    'units' => $data[1], // 単位数
                    'is_social_engineering' => strpos($data[0], '1') !== false, // 社会工学関連かどうかを判定
                ];
            }
            fclose($handle);
        }
        return $courses;
    }
}
