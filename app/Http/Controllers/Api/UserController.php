<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Requests\User\Store;
use App\Http\Requests\User\Update;
use App\Model\Follower;
use App\Model\ManyToMany\User\UserSector;
use App\Model\ManyToMany\User\UserSubSector;
use App\Model\ManyToMany\User\UserQualification;
use App\Model\ManyToMany\User\UserLanguage;
use App\Model\ManyToMany\User\UserCountryActivity;
use App\Http\DataGrids\UserDataGrid;
use App\User;
use App\Model\Role;
use App\Model\Sector;
use App\Model\SubSector;
use App\Model\Qualification;
use App\Model\Country;

use App\Helper\Helper;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::with('country', 'role', 'userSectors.sector', 'accountType',
                            'userSubSectors.subSector',
                            'accountSubType', 'userQualifications.qualification',
                            'organization', 'userCountryActivities.country')->paginate(30);

        return response()->json($users);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexGrid(UserDataGrid $datagrid)
    {
        return $datagrid->resource();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Store $request)
    {
        $user = User::create($request->all());
        $user->name  =  $request->first_name.' '. $request->last_name;
        $user->password = bcrypt($request->password);

        $user->role_id = Role::where('type', 'employee')->first()->id;

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

        $countries = $request->countries;
        foreach ($countries as &$country) {
            $userCountryActivity = UserCountryActivity::create(
                [
                    'user_id' => $user->id,
                    'country_id' => $country,
                ]
            );
        }

        $languages = $request->languages;
        foreach ($languages as &$language) {
            $userLanguage = UserLanguage::create(
                [
                    'user_id' => $user->id,
                    'language_id' => $language,
                ]
            );
        }

        if ($request->has('organization_id')) {
            $user->organization_id = $request->organization_id;
            $user->save();
        }

        return response()->json([
            'error' => 0,
            'message' => 'User has been registered',
            'data' => $user ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Opportunity  $opportunity
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::with('country', 'role', 'userSectors.sector', 'accountType',
                            'userSubSectors.subSector', 'accountSubType',
                            'userCountryActivities.country',
                            'userLanguages.language',
                            'userQualifications.qualification',
                            'organization')->find($id);

        if (!$user) {
            return response()->json([
                'error' => 1,
                'message' => 'user with id ' . $id . ' not found'
            ], 400);
        }
        return response()->json( ['error' => 0, 'data' => $user ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Integer  $id
     * @return \Illuminate\Http\Response
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

                $user->uploadCv($request->file('photo_path'));
            }

            if($request->sectors) {
                $sectors = $request->sectors;
                $user->sectors()->allRelatedIds();
                $user->sectors()->sync($sectors);
                $user->sectors()->allRelatedIds();
            }

            if($request->sub_sectors) {
                $subSectors = $request->sub_sectors;
                $user->sub_sectors()->allRelatedIds();
                $user->sub_sectors()->sync($subSectors);
                $user->sub_sectors()->allRelatedIds();
            }

            if($request->qualifications) {

                $userQualifications = UserQualification::where('user_id', $user->id)->get();
                if ($userQualifications) {
                    foreach ($userQualifications as $userQualification) {
                        $userQualification->delete();
                    }
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
            }

            if($request->has('countries')) {
                $countries = $request->countries;
                $user->countries()->allRelatedIds();
                $user->countries()->sync($countries);
                $user->countries()->allRelatedIds();
            }

            if($request->has('languages')) {
                $languages = $request->languages;
                $user->languages()->allRelatedIds();
                $user->languages()->sync($languages);
                $user->languages()->allRelatedIds();
            }

            // admin can do it
            if ($request->has('organization_id')) {
                $user->organization_id = $request->organization_id;
            }

            $user->save();

            return response()->json([
                'error' => 0,
                'message' => 'user has been updated',
                'user' => $user,
                'redirect_path' => 'users-'.$user->accountType->name,
            ]);
        }

        return response()->json([
            'error' => 1,
            'message' => 'user could not be updated'
        ], 500);
    }

    public function follow($id)
    {
        $follower = auth()->user()->id;
        $followed = $id;

        if ( $follower == $followed )
        return response()->json( ['error' => 0, 'message' => 'you can not follow yourself']);

        $user = Follower::create([
            'follower' => $follower,
            'followed' => $followed,
        ]);

        return response()->json( ['error' => 0, 'message' => 'you have followed '. $followed]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'error' => 1,
                'message' => 'user with id ' . $id . ' not found'
            ], 400);
        }

        $user->delete();
        if ($user->photo_path)
            unlink(public_path().'/'.$user->photo_path);

        if ($user->cv)
            unlink(public_path().'/'.$user->cv);

        return response()->json([
                'error' => 0,
                'message' => 'user has been deleted'
            ]);
    }

    public function followers()
    {
        $followed = auth()->user()->id;

        $users = DB::table('users')
            ->join('followers', 'followers.followed', '=', $followed)
            ->select('users.*')
            ->paginate(30);

        return response()->json($users);
    }

    public function followeds()
    {
        $follower = auth()->user()->id;

        $users = DB::table('users')
            ->join('followers', 'followers.follower', '=', $follower)
            ->select('users.*')
            ->paginate(30);
        return response()->json($users);
    }
}
