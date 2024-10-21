<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Requirement extends Model
{
    /**
     * 卒業要件を取得
     */
    public static function getRequirements()
    {
        return [
            '必修' => [
                '専門科目' => [
                    'required_units' => 12,  // 必修科目の単位数
                    'category' => '学位プログラム科目群・専門科目',
                ],
            ],
            '選択' => [
                '大学院共通科目_社会工学以外' => [
                    'required_units' => 2,
                    'category' => '大学院共通科目・学術院共通専門基盤科目・研究群共通科目群・専門基礎科目',
                    'social_engineering' => false,
                ],
                '研究群共通科目_専門基礎_社会工学' => [
                    'required_units' => 6,
                    'category' => '研究群共通科目群・専門基礎科目',
                    'social_engineering' => true,
                ],
                '研究群共通科目_専門_社会工学' => [
                    'required_units' => 10,
                    'category' => '研究群共通科目群・専門科目',
                    'social_engineering' => true,
                ],
                '研究群共通科目_専門_社会工学以外' => [
                    'required_units' => 0,
                    'category' => '研究群共通科目群・専門科目',
                    'social_engineering' => false,
                ],
                '学位プログラム科目_専門基礎_社会工学' => [
                    'required_units' => 0,
                    'category' => '学位プログラム科目群・専門基礎科目',
                    'social_engineering' => true,
                ],
                '学位プログラム科目_専門_社会工学' => [
                    'required_units' => 0,
                    'category' => '学位プログラム科目群・専門科目',
                    'social_engineering' => true,
                ],
            ],
            '総修得単位数' => 24,  // 選択科目の合計単位数
        ];
    }

    /**
     * 履修科目と卒業要件を照合し、判定を行う
     */
    public static function checkCompletion($courses)
    {
        $requirements = self::getRequirements();
        $result = [
            '必修' => 0,
            '選択' => [
                '大学院共通科目_社会工学以外' => 0,
                '研究群共通科目_専門基礎_社会工学' => 0,
                '研究群共通科目_専門_社会工学' => 0,
                '研究群共通科目_専門_社会工学以外' => 0,
                '学位プログラム科目_専門基礎_社会工学' => 0,
                '学位プログラム科目_専門_社会工学' => 0,
            ],
            '総修得単位数' => 0,
        ];

        foreach ($courses as $course) {
            $category = Course::classifyCourse($course['code']);
            $units = $course['units'];

            // 必修科目の単位数を計算
            if ($category === '学位プログラム科目群・専門科目') {
                $result['必修'] += $units;
            }

            // 選択科目の単位数を分類して計算
            foreach ($requirements['選択'] as $requirementKey => $requirement) {
                if ($category === $requirement['category'] && $requirement['social_engineering'] === $course['is_social_engineering']) {
                    $result['選択'][$requirementKey] += $units;
                    $result['総修得単位数'] += $units;
                }
            }
        }

        // 判定結果の評価
        $status = [];
        foreach ($requirements['選択'] as $key => $requirement) {
            if ($result['選択'][$key] >= $requirement['required_units']) {
                $status[$key] = '達成済';
            } else {
                $status[$key] = '未達成';
            }
        }

        // 総単位数の判定
        $status['総修得単位数'] = ($result['総修得単位数'] >= $requirements['総修得単位数']) ? '達成済' : '未達成';

        return ['result' => $result, 'status' => $status];
    }
}
