<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Api\Model\Organization;
use App\Http\Requests\Organisation\ChangeResponsible;

class OrganizationController extends Controller
{
    public function changeResponsible(ChangeResponsible $request, $id)
    {
        $organization = Organization::find($id);

        if (!$organization) {
            return response()->json([
                'error' => 1,
                'message' => 'organization with id ' . $id . ' not found'
            ], 400);
        }

        if (User::find($request->user_is)->organization_id != $id) {
            return response()->json([
                'error' => 1,
                'message' => 'user does not belong to this organization'
            ], 400);
        }

        $organization->changeResponsible($request->user_id);

        return response()->json([
            'error' => 0,
            'message' => 'responsible has been changed'
        ]);
    }
}
