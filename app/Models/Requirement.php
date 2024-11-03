<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Requirement extends Model
{
    // 卒業要件を定義
    public static function getRequirements()
    {
        return [
            '必修' => [
                '科目' => [
                    '社会工学修士基礎演習I' => ['pattern' => '/^0ALA502$/', 'units' => 2],
                    '社会工学修士基礎演習II' => ['pattern' => '/^0ALA503$/', 'units' => 2],
                    '社会工学修士特別演習I' => ['pattern' => '/^0ALA504$/', 'units' => 2],
                    '社会工学修士特別演習II' => ['pattern' => '/^0ALA505$/', 'units' => 2],
                    '社会工学修士特別研究I' => ['pattern' => '/^0ALA506$/', 'units' => 2],
                    '社会工学修士特別研究II' => ['pattern' => '/^0ALA507$/', 'units' => 2],
                ],
                'required_units' => 12,
            ],
            '選択' => [
                '(1)大学院共通科目など' => [
                    'pattern' => '/^0A0.*$|^0AH.*$|^0AL[0-4][0,2-9A-Z].*$/',
                    'required_units' => 2,
                ],
                '(2)研究群共通科目群・専門基礎・社会工学関連' => [
                    'pattern' => '/^0AL[0-4]1.*$/',
                    'required_units' => 6,
                ],
                '(3)研究群共通科目群・専門・社会工学関連' => [
                    'pattern' => '/^0AL[5-9]1.*$/',
                    'required_units' => 10,
                ],
                '(4)研究群共通科目群・専門・その他' => [
                    'pattern' => '/^0AL[5-9][0,2-9A-Z].*$/',
                    'required_units' => 0,
                ],
                '(5)学位プログラム科目群・専門基礎・社会工学関連' => [
                    'pattern' => '/^0ALA[0-4].*$/',
                    'required_units' => 0,
                ],
                '(6)学位プログラム科目群・専門・社会工学関連' => [
                    'pattern' => '/^0ALA[5-9].*$/',
                    'required_units' => 0,
                ],
            ],
            '選択合計' => 24,
        ];
    }
}
