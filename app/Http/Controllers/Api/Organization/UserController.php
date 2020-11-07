<?php

namespace App\Http\Controllers\Api\Organization;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\DataGrids\UserDataGrid;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $users = User::with('country', 'role', 'userSectors.sector', 'accountType',
            'userSubSectors.subSector',
            'accountSubType', 'userQualifications.qualification',
            'organization', 'userCountryActivities.country')
            ->where('organization_id', auth()->user()->orgaization_id)->paginate(30);

        return response()->json($users);
    }

    /**
     * Display a listing of the resource.
     *
     * @param UserDataGrid $datagrid
     * @return Response
     */
    public function indexGrid(UserDataGrid $datagrid)
    {
        return $datagrid->resource();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Store $request
     * @return Response
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

        $user->organization_id = auth()->user()->organization_id;
        $user->save();

        return response()->json([
            'error' => 0,
            'message' => 'User has been registered',
            'data' => $user ]);
    }

    /**
     * Display the specified resource.
     *
     * @param $id
     * @return Response
     */
    public function show($id)
    {
        $user = User::with('country', 'role', 'userSectors.sector', 'accountType',
            'userSubSectors.subSector', 'accountSubType',
            'userCountryActivities.country',
            'userLanguages.language',
            'userQualifications.qualification',
            'organization')->where('organization_id', auth()->user()->orgaization_id)->find($id);

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
     * @param Update $request
     * @param  $id
     * @return Response
     */
    public function update(Update $request, $id)
    {
        $user = User::where('id', $id)->where('organization_id', auth()->user()->orgaization_id)->first();

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

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @return Response
     */
    public function destroy($id)
    {
        $user = User::where('id', $id)->where('organization_id', auth()->user()->orgaization_id);

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

    /**
     * @param $id
     * @return
     */
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
