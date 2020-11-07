<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use App\Model\Role;
use App\Model\Responsible;
use App\Model\AccountType;
use App\Model\Company;
use App\Model\Consultant;
use App\Model\Government;
use App\Model\Supplier;
use App\Model\Investor;
use App\Model\Funder;
use App\Model\Ong;
use App\Model\Transporter;
use App\Model\FinancialInstitution;
use Illuminate\Support\Carbon;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [
                            'password_confirmation',
                            'sectors',
                            'sub_sectors',
                            'qualifications',
                            'photo_path',
                            'cv',
                            'organization_id',
                            'countries',
                            'languages',
                            'role_id',
                         ];

    /**
     * Get all of the owning organization models.
     */
    public function organization()
    {
        return $this->belongsTo('App\Model\Organization');
    }

    public function responsible()
    {
        return $this->hasOne('App\Model\Responsible');
    }

    public function walletLog()
    {
        return $this->hasMany('App\Model\WalletLog');
    }

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function role()
    {
        return $this->belongsTo('App\Model\Role');
    }

    public function opportunities()
    {
        return $this->hasMany('App\Model\Opportunity');
    }

    public function projects()
    {
        return $this->hasMany('App\Model\Project');
    }

    public function languages()
    {
        return $this->belongsToMany('App\Model\Language', 'user_languages');
    }

    public function userLanguages()
    {
        return $this->hasMany('App\Model\ManyToMany\User\UserLanguage');
    }

    public function qualifications()
    {
        return $this->belongsToMany('App\Model\Qualification', 'user_qualifications');
    }

    public function userQualifications()
    {
        return $this->hasMany('App\Model\ManyToMany\User\UserQualification');
    }

    public function sectors()
    {
        return $this->belongsToMany('App\Model\Sector', 'user_sectors');
    }

    public function userSectors()
    {
        return $this->hasMany('App\Model\ManyToMany\User\UserSector');
    }

    public function subSectors()
    {
        return $this->belongsToMany('App\Model\SubSector', 'user_sub_sectors');
    }

    public function userCountryActivities()
    {
        return $this->hasMany('App\Model\ManyToMany\User\UserCountryActivity');
    }

    public function countryActivities()
    {
        return $this->belongsToMany('App\Model\Country', 'user_country_activities');
    }

    public function userSubSectors()
    {
        return $this->hasMany('App\Model\ManyToMany\User\UserSubSector');
    }

    public function posts()
    {
        return $this->hasMany('App\Model\Post');
    }

    public function country()
    {
        return $this->belongsTo('App\Model\Country');
    }

    public function language()
    {
        return $this->belongsTo('App\Model\Language');
    }

    public function nationality()
    {
        return $this->belongsTo('App\Model\Country', 'nationality_id');
    }

    public function accountType()
    {
        return $this->belongsTo('App\Model\AccountType');
    }

    public function accountSubType()
    {
        return $this->belongsTo('App\Model\AccountSubType');
    }

    /*
     *
     *
     *
     * */

    public function getDatePath($createdAt)
    {
        $year = Carbon::createFromFormat('Y-m-d H:i:s', $createdAt)->year;
        $month = Carbon::createFromFormat('Y-m-d H:i:s', $createdAt)->month;
        $day = Carbon::createFromFormat('Y-m-d H:i:s', $createdAt)->day;

        return $year.'/'.$month.'/'.$day;
    }

    public function uploadCv($cv)
    {
        $path = 'storage/'.$this->accountType->name.'/'.$this->role->type.'/'.$this->getDatePath($this->created_at).'/'.md5($this->email).'/cv';
        $cv_path = $cv->store($path);
        $this->cv = $cv_path;
        $this->save();
    }

    public function uploadPhoto($photo)
    {
        $path = 'storage/'.$this->accountType->name.'/'.$this->role->type.'/'.$this->getDatePath($this->created_at).'/'.md5($this->email).'/photo';
        $photo_path = $photo->store($path);
        $this->photo_path = $photo_path;
        $this->save();
    }

    public function updateResponsible($id)
    {

    }

    public function isResponsible()
    {
        $role = Role::find(auth()->user()->role_id)->type;
        if ($role == 'responsible')
            return true;
        return false;
    }

    public static function getDetail($id)
    {
         $detail = self::with('country', 'role', 'userSectors.sector',
                               'accountType', 'userSubSectors.subSector',
                               'accountSubType', 'userQualifications.qualification',
                               'organization')->find($id);

         if ($detail->account_type_name != 'bfa')
             $detail['redirect_url'] = 'SomeWhere';

         return $detail;
    }

    public static function getAccountType($account_type_id)
    {
        return AccountType::find($account_type_id)->name;
    }

    // users that belong to organization
    public static function checkOwner($user_id, $organization_id)
    {
        $user = self::find($user_id);
        if($user->organization_id != $organization_id)
            return false;
        return true;
    }

    public static function checkOrganizationInfo($user_id)
    {
        $user = self::with('organization', 'accountType')->find($user_id);

        if ($user->accountType->name != 'bfa')
            if (!$user->organization_id)
                return false;
        return true;
    }
}
