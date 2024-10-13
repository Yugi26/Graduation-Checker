<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Affiliation;

class AffiliationController extends Controller
{
    // 学群・学類・専攻を選択するフォームの表示
    public function showForm()
    {
        $faculities = Affiliation::getFaculities(); // 学群の一覧を取得
        return view('affiliation', compact('faculities'));
    }

    // 選択された学群に紐づく学類を取得
    public function getDepartments(Request $request)
    {
        $departments = Affiliation::getDepartment($request->faculity); // 学類の一覧を取得
        return response()->json($departments);
    }

    // 選択された学類に紐づく専攻を取得
    public function getMajors(Request $request)
    {
        $majors = Affiliation::getMajor($request->department); // 専攻の一覧を取得
        return response()->json($majors);
    }
}
