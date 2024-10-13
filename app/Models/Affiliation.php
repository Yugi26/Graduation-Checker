<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Affiliation extends Model
{
    use HasFactory;
    // 仮の学群データ
    public static function getFaculities()
    {
        return [
            '情報学群' => ['情報科学類', '知識情報・図書館学類'],
            '人文社会学群' => ['国際関係学類', '社会学類']
        ];
    }

    // 学群に紐づく学類を取得
    public static function getDepartments($faculity)
    {
        $data = self::getFaculities();

        return $data[$faculity] ?? [];
    }

    // 学類に紐づく専攻を取得
    public static function getMajors($department)
    {
        $data = [
            '情報科学類' => ['情報科学専攻', '情報システム専攻'],
            '知識情報・図書館学類' => ['知識情報・図書館学専攻'],
            '国際関係学類' => ['国際関係学専攻'],
            '社会学類' => ['社会学専攻']
        ];

        return $data[$department] ?? [];
    }
}
