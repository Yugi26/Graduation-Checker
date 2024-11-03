<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    /**
     * 科目コードを分類して、卒業要件に合致するかを判定
     */
    public static function classifyAndCountUnits($courseCode, $units)
    {
        $requirements = Requirement::getRequirements();

        // 必修科目の判定
        foreach ($requirements['必修']['科目'] as $name => $requirement) {
            if (preg_match($requirement['pattern'], $courseCode)) {
                error_log("必修科目に該当: $name | 科目コード: $courseCode");
                return ['category' => '必修', 'name' => $name, 'units' => $requirement['units']];
            }
        }

        // 選択科目の判定
        foreach ($requirements['選択'] as $key => $requirement) {
            if (preg_match($requirement['pattern'], $courseCode)) {
                error_log("選択科目に該当: $key | 科目コード: $courseCode");
                return ['category' => '選択', 'name' => $key, 'units' => $units];
            }
        }

        // 該当なしの場合
        error_log("該当なし | 科目コード: $courseCode");
        return ['category' => '該当なし', 'name' => '', 'units' => 0];
    }
}
