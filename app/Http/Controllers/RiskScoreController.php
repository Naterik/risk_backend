<?php

namespace App\Http\Controllers;

use App\Models\MRiskScore;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RiskScoreController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $companyCd = $user->company_cd;


        $riskScores = MRiskScore::where('company_cd', $companyCd)
            ->where('is_deleted', false)
            ->whereIn('score_type', [0, 1, 2])
            ->select('score_type', 'score', 'score_nm', 'score_detail')
            ->orderBy('score', 'asc')
            ->get();


        $result = [
            'frequency' => [],
            'injury_possibility' => [],
            'injury_severity' => [],
        ];

        foreach ($riskScores as $score) {
            $data = [
                'score' => $score->score,
                'score_nm' => $score->score_nm,
                'score_detail' => $score->score_detail,
            ];

            if ($score->score_type === 0) {
                $result['frequency'][] = $data;
            } elseif ($score->score_type === 1) {
                $result['injury_possibility'][] = $data;
            } elseif ($score->score_type === 2) {
                $result['injury_severity'][] = $data;
            }
        }

        return response()->json([
            'status' => 'success',
            'data' => $result,
        ], 200);
    }
}
