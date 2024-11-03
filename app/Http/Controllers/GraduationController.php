<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CSVHandler;
use App\Models\Requirement;
use App\Models\Course;

class GraduationController extends Controller
{
    public function checkRequirements(Request $request)
    {
        // CSVファイルのアップロードが必須
        $request->validate([
            'csv_file' => 'required|file|mimes:csv,txt',
        ]);

        // CSVファイルの解析
        $courses = CSVHandler::parseCSV($request->file('csv_file'));

        // 結果の初期化
        $requirements = Requirement::getRequirements();
        $result = [
            '必修' => 0,
            '選択' => [
                '(1)大学院共通科目など' => 0,
                '(2)研究群共通科目群・専門基礎・社会工学関連' => 0,
                '(3)研究群共通科目群・専門・社会工学関連' => 0,
                '(4)研究群共通科目群・専門・その他' => 0,
                '(5)学位プログラム科目群・専門基礎・社会工学関連' => 0,
                '(6)学位プログラム科目群・専門・社会工学関連' => 0,
            ],
            '総修得単位数' => 0,
        ];

        // 各コースの判定と単位集計
        foreach ($courses as $course) {
            $classification = Course::classifyAndCountUnits($course['code'], $course['units']);
            $category = $classification['category'];
            $name = $classification['name'];
            $units = $classification['units'];

            if ($category === '必修') {
                $result['必修'] += $units;
            } elseif ($category === '選択') {
                $result['選択'][$name] += $units;
                $result['総修得単位数'] += $units;
            }
        }

        // 達成状況の確認
        $status = [
            '必修' => $result['必修'] >= $requirements['必修']['required_units'] ? '達成済' : '未達成',
        ];

        foreach ($requirements['選択'] as $key => $requirement) {
            $status[$key] = $result['選択'][$key] >= $requirement['required_units'] ? '達成済' : '未達成';
        }
        $status['総修得単位数'] = $result['総修得単位数'] >= $requirements['選択合計'] ? '達成済' : '未達成';

        return view('result', [
            'result' => $result,
            'status' => $status,
            'requirements' => $requirements,
        ]);
    }
}
