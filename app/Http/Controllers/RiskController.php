<?php

namespace App\Http\Controllers;

use App\Models\TRiskSubmit;
use Illuminate\Http\Request;
use App\Http\Requests\RiskRequest;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\RiskCollection;

class RiskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $user = Auth::user();
        $organizationIds = $user->r_user_divisions ? $user->r_user_divisions->pluck('organization_id') : [];

        $riskSubmits = TRiskSubmit::where('company_cd', $user->company_cd)
            ->whereIn('s_organization_id', $organizationIds)
            ->where('s_submit_type', 1)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return response()->json([
            'status' => 'success',
            'data' => $riskSubmits,
        ], 200);
    }

    public function create() {}

    /**
     * Store a newly created resource in storage.
     */
    public function store(RiskRequest $request)
    {

        $risk = TRiskSubmit::create([
            'company_cd' => $request->company_cd,
            'risk_seq' => $request->risk_seq ?? 1,
            's_organization_id' => $request->s_organization_id,
            's_submitted_by' => $request->s_submitted_by,
            's_huppened_on' => $request->s_huppened_on,
            's_location' => $request->s_location,
            's_detail' => $request->s_detail,
            ' s_ip_address' => $request->s_ip_address,
            's_device' => $request->s_device,
            's_submit_type' => 1,
            's_submitted_at' => $request->s_submitted_at,
            'created_by' => $request->created_by,
            'updated_by' => $request->updated_by,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
