<?php

namespace App\Http\Controllers;

use App\Models\TImage;
use App\Models\TRiskSubmit;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Requests\RiskRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\ImageManager;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Drivers\Gd\Driver;

class RiskController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        $riskSubmits = TRiskSubmit::orderBy('created_at', 'desc')
            ->withCount('t_images')

            ->paginate(10);

        return response()->json([
            'status' => 'success',
            'data' => $riskSubmits,
        ], 200);
    }

    public function batchSubmit(Request $request)
    {
        $user = Auth::user();
        $risks = $request->input('risks'); // Nhận mảng risks từ frontend

        if (empty($risks)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Không có dữ liệu để lưu.',
            ], 422);
        }

        DB::beginTransaction();
        try {
            foreach ($risks as $riskData) {
                $maxRiskSeq = TRiskSubmit::where('company_cd', $user->company_cd)->max('risk_seq') ?? 0;
                $riskSeq = $maxRiskSeq + 1;

                $risk = TRiskSubmit::create([
                    'company_cd' => $user->company_cd,
                    'risk_seq' => $riskSeq,
                    's_organization_id' => $riskData['s_organization_id'],
                    's_submitted_by' => $riskData['s_submitted_by'] ?? $user->user_nm,
                    's_huppened_on' => $riskData['s_huppened_on'],
                    's_location' => $riskData['s_location'],
                    's_detail' => $riskData['s_detail'],
                    's_ip_address' => $request->ip(),
                    's_device' => 'PC',
                    's_submit_type' => 1,
                    's_submitted_at' => now(),
                    'created_by' => $user->user_id,
                    'updated_by' => $user->user_id,
                ]);

                if (!empty($riskData['images'])) {
                    $pictureSeq = 1;
                    foreach ($riskData['images'] as $image) {
                        TImage::create([
                            'risk_id' => $risk->risk_id,
                            'picture_seq' => $pictureSeq,
                            'file_path' => str_replace(url('/storage/'), '', $image['path']),
                            'file_nm' => $image['file_name'],
                            'thumbnail_path' => str_replace(url('/storage/'), '', $image['thumbnail_path']),
                            'thumbnail_nm' => $image['thumbnail_name'],
                            'took_at' => now(),
                            'created_by' => $user->user_id,
                            'updated_by' => $user->user_id,
                        ]);
                        $pictureSeq++;
                    }
                }
            }

            DB::commit();
            return response()->json([
                'status' => 'success',
                'message' => 'Dữ liệu đã được lưu thành công.',
                'data' => $risks,
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
