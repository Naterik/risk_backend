<?php

namespace App\Http\Controllers;

use App\Models\MCompany;
use Illuminate\Http\Request;


use App\Http\Resources\company\CompanyCollection;


class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        return new CompanyCollection(MCompany::all());
    }
    public function create()
    {
        //
    }
    public function show($id)
    {
        $check = MCompany::where('company_cd', $id)->first();
        if ($check) {
            return response()->json(['success' => true], status: 200);
        } else {
            return response()->json(['error' => 'Not exsit'], 404);
        }
    }
}
