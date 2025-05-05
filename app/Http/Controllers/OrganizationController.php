<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MOrganization;
use Illuminate\Support\Facades\Auth;

class OrganizationController extends Controller

{

    public function index()
    {
        $organization = MOrganization::all('organization_nm', 'organization_id');
        return response()->json(['data' => $organization], 200);
    }
    public function getOrganizationTree()
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['status' => 'error', 'error' => 'Unauthorized'], 401);
        }
        if (!$user->m_user_type) {
            return response()->json(['status' => 'error', 'error' => 'User type not found'], 403);
        }

        $query = MOrganization::select('organization_nm');
        if ($user->m_user_type->can_check_another_division) {
            $organizations = MOrganization::with('children')
                ->whereNull('parent_organization_id')
                ->where('is_deleted', false)
                ->select('organization_id', 'organization_nm')
                ->get();
        } else {
            $userOrganizationIds = $user->r_user_divisions->pluck('organization_id');
            $organizations = $query->whereIn('organization_id', $userOrganizationIds)->get();
        }

        return response()->json(['data' => $organizations], 200);
    }
}
