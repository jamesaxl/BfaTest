<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\AccountType;

class AccountTypeController extends Controller
{
    /**
     * @return mixed
     */
    public function index()
    {
        $accountType = AccountType::with('accountSubTypes')->get();
        return response()->json($accountType);
    }
}
