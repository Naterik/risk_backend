<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\MUser;
use App\Models\MCompany;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request; // Fixed import

class AuthController extends Controller
{

    private function getCompanyByCode($companyCd)
    {
        if (!$companyCd) {
            return null;
        }

        return MCompany::select('company_nm', 'company_cd')
            ->where('company_cd', $companyCd)
            ->first();
    }
    public function login(LoginRequest $request)
    {
        $companyCd = $request->query('company_cd');
        $company = $this->getCompanyByCode($companyCd);
        if (!$company || !$companyCd) {
            return response()->json(['message' => '会社コードが不正です。'], 401);
        }
        $credentials = $request->validated();
        $user = MUser::with('m_user_type')
            ->where('company_cd', $companyCd)
            ->where('user_login_id', $credentials['user_login_id'])
            ->first();

        if (!$user || md5($credentials['login_pw']) !== $user->login_pw) {
            return response()->json(['message' => '社員 ID、またはパスワードが間違っています。'], 401);
        }

        $token = Auth::guard('api')->login($user);

        return response()->json([
            'status' => '201',
            'message' => 'Login',
            'data' => [
                'user' => $user,
                'company_cd' => $company->company_cd,
                'company_nm' => $company->company_nm
            ],
            'token' => $token,
        ], 200);
    }


    public function logout()
    {
        Auth::guard('api')->logout();
        return response()->json(['message' => 'ログアウトしました'], 200);
    }
}
