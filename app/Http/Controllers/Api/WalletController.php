<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class WalletController extends Controller
{
    public function update(Request $request, $id)
    {
        $wallet = Wallet::find($id);
        
        if(!$wallet) {
            return response()->json(
            [
                'error' => 1,
                'message' => 'wallet with id '.$id.' not found',
            ], 400);
        }
        
        $updated = $wallet->fill(
            [
                'amount' => $request->amount,
            ]
        )->save();
        
        if ($updated) {
            return response()->json([
                'error' => 0,
                'message' => 'wallet has been updated'
            ]);
        }

        return response()->json([
            'error' => 1,
            'message' => 'wallet could not be updated'
        ], 500);
    }
}
