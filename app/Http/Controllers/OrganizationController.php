<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MOrganization;
use Illuminate\Support\Facades\Auth;

class OrganizationController extends Controller
{
    public function getOrganizationTree()
    {
        $user = Auth::user();

        // Kiểm tra user đã đăng nhập
        if (!$user) {
            return response()->json(['status' => 'error', 'error' => 'Unauthorized'], 401);
        }

        // Kiểm tra m_user_type
        if (!$user->m_user_type) {
            return response()->json(['status' => 'error', 'error' => 'User type not found'], 403);
        }

        $query = MOrganization::select('organization_nm');

        // Kiểm tra quyền can_check_another_division
        if ($user->m_user_type->can_check_another_division) {
            // Nếu true, lấy toàn bộ tổ chức
            $organizations = MOrganization::with('children')
                ->whereNull('parent_organization_id')
                ->where('is_deleted', false)
                ->select('organization_id', 'organization_nm')
                ->get();
        } else {
            // Nếu false, chỉ lấy tổ chức của user từ r_user_division
            $userOrganizationIds = $user->r_user_divisions->pluck('organization_id');
            $organizations = $query->whereIn('organization_id', $userOrganizationIds)->get();
        }

        return response()->json(['data' => $organizations], 200);
    }
}
