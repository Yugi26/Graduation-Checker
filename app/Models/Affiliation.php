<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Affiliation extends Model
{
    use HasFactory;
    // 仮の学群データ
    public static function getFaculties()
    {
        return [
            '理工情報生命学術院' => ['数理物質科学研究群', 'システム情報工学研究群', '生命地球科学研究群']
        ];
    }

    // 学群に紐づく学類を取得
    public static function getDepartments($faculty)
    {
        $data = self::getFaculties();

        return $data[$faculty] ?? [];
    }

    // 学類に紐づく専攻を取得
    public static function getMajors($department)
    {
        $data = [
            '数理物質科学研究群' => ['数学学位プログラム', '物理学位プログラム', '化学学位プログラム', '応用理工学位プログラム', '国際マテリアルズイノベーション学位プログラム'],
            'システム情報工学研究群' => ['社会工学学位プログラム', 'サービス工学学位プログラム', 'リスク・レジリエンス学位プログラム', '情報理工学位プログラム', '知識機能システム学位プログラム', '構造エネルギー学位プログラム', 'エンパワーメント学位プログラム', 'ライフイノベーション（生物情報）学位プログラム'],
            '生命地球科学研究群' => ['生物学学位プログラム', '生物資源科学学位プログラム', '農学学位プログラム', '生命農学学位プログラム', '生命産業科学学位プログラム', '地球科学学位プログラム', '環境科学学位プログラム', '環境学学位プログラム', '山岳科学学位プログラム', 'ライフイノベーション（食料革新）学位プログラム', 'ライフイノベーション（環境制御）学位プログラム', 'ライフイノベーション（生体分子材料）学位プログラム']
        ];

        return $data[$department] ?? [];
    }
}
