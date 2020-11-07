<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Register\Store;
use Illuminate\Support\Str;
use App\User;
use App\Model\Responsible;
use App\Model\Organization;
use App\Helper\Helper;
use App\Model\ManyToMany\User\UserSector;
use App\Model\ManyToMany\User\UserSubSector;
use App\Model\ManyToMany\User\UserQualification;
use App\Model\Sector;
use App\Model\SubSector;
use App\Model\Qualification;
use App\Model\Role;

//use Illuminate\Support\Facades\Redis;

class PassportController extends Controller
{
    /**
     * Handles Registration Request
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Store $request)
    {
        $user = User::create($request->all());

        $user->role_id = Role::where('type', 'employee')->first()->id;
        $user->save();

        $organization = Organization::create(
            [
                'organization_type_id' => $user->account_type_id,
                'organization_sub_type_id' => $user->account_sub_type_id,
            ]
        );

        $organization->setupOrganization();
        $organization->setupWallet();

        $responsible = Responsible::create([
            'organization_id' => $organization->id,
            'user_id' => $user->id,
        ]);

        $user->organization_id = $organization->id;
        $user->name  =  $request->first_name.' '. $request->last_name;
        $user->password = bcrypt($request->password);

        $user->createToken('TutsForWeb')->accessToken;

        if ($request->hasFile('cv')) {
            $user->uploadCv($request->file('cv'));
        }

        if ($request->hasFile('photo_path')) {
            $user->uploadCv($request->file('photo_path'));
        }

        $user->save();

        $sectors = $request->sectors;
        foreach ($sectors as &$sector) {
            $userSector = UserSector::create(
                [
                    'user_id' => $user->id,
                    'sector_id' => $sector,
                ]
            );
        }

        $subSectors = $request->sub_sectors;
        foreach ($subSectors as &$subSector) {
            $userSubSector = UserSubSector::create(
                [
                    'user_id' => $user->id,
                    'sub_sector_id' => $subSector,
                ]
            );
        }

        $qualifications = $request->qualifications;
        foreach ($qualifications as &$qualificationName) {
            $qualification = Qualification::where('name', $qualificationName)->first();
            if (!$qualification) {
                $qualification = new Qualification;
                $qualification->name = $qualificationName;
                $qualification->save();
            }

            $userQualification = UserQualification::create(
                [
                    'user_id' => $user->id,
                    'qualification_id' => $qualification->id,
                ]
            );
        }

        return response()->json([
                                    'error' => 0,
                                    'message' => 'User has been registered',
                                    'user' => $user
                                ]);
    }

    /**
     * Handles Login Request
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $credentials = [
            'email' => $request->email,
            'password' => $request->password
        ];

        if (auth()->attempt($credentials)) {
            $token = auth()->user()->createToken('TutsForWeb')->accessToken;

            $organization_info_exist = User::checkOrganizationInfo(auth()->user()->id);

            if (!$organization_info_exist)
                return response()->json(['user' => User::getDetail(auth()->user()->id),
                                         'token' => $token,
                                         'warn_msg' => 'you must fill info of your organization' ], 200);

            return response()->json(['user' => User::getDetail(auth()->user()->id), 'token' => $token], 200);
        }

        return response()->json(['error' => 'UnAuthorised'], 401);
    }

    /**
     * Returns Authenticated User Details
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function details()
    {
        $organization_info_existed = User::checkOrganizationInfo(auth()->user()->id);
        if (!$organization_info_existed)
            return response()->json(['user' => User::getDetail(auth()->user()->id),
                                     'warn_msg' => 'you must fill info of your organization'], 200);

        return response()->json(['user' => User::getDetail(auth()->user()->id)], 200);
    }

    public function logout(Request $request)
    {
        $token = $request->user()->token();
        $token->revoke();
        $response = ['error' => 0, 'message' => 'You have been successfully logged out!'];
        return response($response, 200);
    }

/*    public function activeAccount($code)
    {
        $email = Redis::get($code);

        if (!$email)
            return response()->json(['error' => 1, 'message' => 'activation error']);

        $user = User::where('email', $email)->first();
        $user->enabled = 1;

        return response()->json(['error' => 0, 'message' => 'account has been activated']);
    }
*/
}
