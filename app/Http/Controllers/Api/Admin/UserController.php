<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Http\Requests\Bfa\Store;
use App\Http\Requests\Bfa\Update;
use Illuminate\Http\Response;

class UserController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param Store $request
     * @return Response
     */
    public function store(Store $request)
    {
        $user = User::create($request->all());

        $user->name = $request->first_name.' '. $request->last_name;
        $user->account_type_id = auth()->user()->account_type_id;
        $user->account_sub_type_id = auth()->user()->account_sub_type_id;

        if ($request->has('role_id')) {
            $user->role_id = $request->role_id;
        }

        $user->createToken('Bfa')->accessToken;
        $user->save();

        if ($request->hasFile('cv')) {
            $user->uploadCv($request->file('cv'));
        }

        if ($request->hasFile('photo_path')) {
            $user->uploadPhoto($request->file('photo_path'));
        }

        return response()->json([ 'error' => 0,
            'message' => 'User has been registered',
            'user' => $user ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Update  $request
     * @param  Integer  $id
     * @return Response
     */
    public function update(Update $request, $id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'error' => 1,
                'message' => 'user with id ' . $id . ' not found'
            ], 400);
        }

        $updated = $user->fill($request->all())->save();

        if ($updated) {
            $user->name  =  $user->first_name.' '. $user->last_name;

            if ($request->hasFile('cv')) {
                if ($user->cv)
                    unlink(public_path().'/'.$user->cv);

                $user->uploadCv($request->file('cv'));
            }

            if ($request->hasFile('photo_path')) {
                if ($user->photo_path)
                    unlink(public_path().'/'.$user->photo_path);

                $user->uploadPhone($request->file('photo_path'));
            }

            $user->save();

            return response()->json([
                'error' => 0,
                'message' => 'user has been updated',
                'user' => $user,
            ]);
        }

        return response()->json([
            'error' => 1,
            'message' => 'user could not be updated'
        ], 500);
    }
}
