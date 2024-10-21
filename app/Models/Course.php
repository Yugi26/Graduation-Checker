<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    /**
     * 科目コードに基づいて分類を行う
     */
    public static function classifyCourse($courseCode)
    {
        // 1桁目: 大学院区分 (固定で '0')
        if ($courseCode[0] !== '0') {
            return '大学院課程外';
        }

        // 2桁目: 博士前期課程かどうかの確認
        if ($courseCode[1] !== 'A') {
            return '博士前期課程外';
        }

        // 3桁目: 研究群区分または共通科目の確認
        $category = $courseCode[2];
        switch ($category) {
            case '0':
                return '大学院共通科目';  // 細分なし
            case 'A':
                return '学術院共通専門基盤科目';  // 細分なし
            case 'L':
                return self::classifySystemInfoEngineering($courseCode);  // システム情報工学研究群の場合
            default:
                return '不明な科目区分';
        }
    }

    /**
     * システム情報工学研究群の科目分類
     */
    private static function classifySystemInfoEngineering($courseCode)
    {
        // 4桁目: 科目群分類
        $subjectGroup = $courseCode[3];
        if (preg_match('/[0-4]/', $subjectGroup)) {
            return self::classifyCommonSubject($courseCode);
        } elseif (preg_match('/[A-F]/', $subjectGroup)) {
            return self::classifyProgramSubject($courseCode);
        }

        return '予備科目';
    }

    /**
     * 研究群共通科目群の分類を行う
     */
    private static function classifyCommonSubject($courseCode)
    {
        $category = $courseCode[4];
        switch ($category) {
            case '0':
                return '共通';
            case '1':
                return '社会工学関連科目';
            case '2':
                return 'サービス工学関連科目';
            case '3':
                return 'リスク・レジリエンス工学関連科目';
            case '4':
                return '情報理工関連科目';
            case '5':
                return '知能機能システム関連科目';
            case '6':
                return '構造エネルギー工学関連科目';
            case '7':
                return 'エンパワーメント情報学関連科目';
            default:
                return '予備';
        }
    }

    /**
     * 学位プログラム科目群の分類を行う
     */
    private static function classifyProgramSubject($courseCode)
    {
        $category = $courseCode[4];
        if (preg_match('/[0-4]/', $category)) {
            return '専門基礎科目';
        } elseif (preg_match('/[5-9]/', $category)) {
            return '専門科目';
        }

        return '予備';
    }
}
