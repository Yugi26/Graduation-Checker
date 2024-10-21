<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CSVHandler;
use App\Models\Requirement;

class GraduationController extends Controller
{
    public function checkRequirements(Request $request)
    {
        // ファイルのバリデーション
        $request->validate([
            'csv_file' => 'required|file|mimes:csv,txt',
        ]);

        // CSVファイルを解析
        $courses = CSVHandler::parseCSV($request->file('csv_file'));

        // 卒業要件の取得とチェック
        $result = Requirement::checkCompletion($courses);

        // 判定結果をビューに渡す
        return view('result', ['result' => $result['result'], 'status' => $result['status']]);
    }
}
