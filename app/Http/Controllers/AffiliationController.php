<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Affiliation;

class AffiliationController extends Controller
{
    // 学群・学類・専攻を選択するフォームの表示
    public function showForm()
    {
        $faculity = Affiliation::getFaculity(); // 学群の一覧を取得
        return view('affiliation', compact('faculity'));
    }

    // 選択された学群に紐づく学類を取得
    public function getDepartment(Request $request)
    {
        $department = Affiliation::getDepartment($request->faculity); // 学類の一覧を取得
        return response()->json($department);
    }

    // 選択された学類に紐づく専攻を取得
    public function getMajor(Request $request)
    {
        $major = Affiliation::getMajor($request->department); // 専攻の一覧を取得
        return response()->json($major);
    }
}
