<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Model\AccountSubType;

class AccountSubTypeController extends Controller
{
    /**
     * @return Response
     *
     */
    public function index()
    {
        $accountSubTypes = AccountSubType::with('accountType')->get();
        return response()->json($accountSubTypes);
    }

    /**
     * @param $accountTypeId
     * @return Response
     */
    public function inAccountType($accountTypeId)
    {
        $accountSubTypes = AccountSubType::where('account_type_id', $accountTypeId)->get();
        return response()->json($accountSubTypes);
    }
}
