<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Model\Speciality;
use App\Model\ManyToMany\OrganizationsSpecialities;
use App\Model\Qualification;
use App\Model\ManyToMany\OrganizationsQualifications;
use App\Model\ManyToMany\OrganizationsSectors;
use App\Model\ManyToMany\OrganizationsSubSectors;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class Organization extends Model
{
    protected $fillable = [
        'name',
        'organization_type_id',
        'organization_sub_type_id',
        'evaluation',
        'continent_id',
        'country_id',
        'nationality_id',
        'email',
        'address',
        'postal_code',
        'city_id',
        'phone',
        'fax',
        'preview',
        'biography',
        'status',
        'is_enabled',
        'language_id',
        'currency_id',
    ];

    public function users()
    {
        return $this->hasMany('App\User');
    }

    public function responsible()
    {
        return $this->hasOne('App\Model\Responsible');
    }

    public function wallet()
    {
        return $this->hasOne('App\Model\Wallet');
    }

    public function WalletLogs()
    {
        return $this->hasMany('App\Model\ManyToMany\WalletLogs');
    }

    public function sectors()
    {
        return $this->belongsToMany('App\Model\Sector', 'organizations_sectors');
    }

    public function organizationSectors()
    {
        return $this->hasMany('App\Model\ManyToMany\OrganizationSector');
    }

    public function subSectors()
    {
        return $this->belongsToMany('App\Model\SubSector', 'organizations_sub_sectors');
    }

    public function organizationSubSectors()
    {
        return $this->hasMany('App\Model\ManyToMany\OrganizationSubSector');
    }

    public function specialities()
    {
        return $this->belongsToMany('App\Model\Speciality', 'organizations_specialities');
    }

    public function organizationSpecialities()
    {
        return $this->hasMany('App\Model\ManyToMany\OrganizationSpeciality');
    }

    public function country()
    {
        return $this->belongsTo('App\Model\Country');
    }

    public function city()
    {
        return $this->belongsTo('App\Model\City');
    }

    public function organizationType()
    {
        return $this->belongsTo('App\Model\AccountType', 'organization_type_id');
    }

    public function organizationSubType()
    {
        return $this->belongsTo('App\Model\AccountSubType', 'organization_sub_type_id');
    }

    public function company()
    {
        return $this->hasOne('App\Model\Company');
    }

    public function consultant()
    {
        return $this->hasOne('App\Model\Consultant');
    }

    public function supplier()
    {
        return $this->hasOne('App\Model\Supplier');
    }

    public function ong()
    {
        return $this->hasOne('App\Model\Ong');
    }

    public function government()
    {
        return $this->hasOne('App\Model\Government');
    }

    public function transporter()
    {
        return $this->hasOne('App\Model\Transporter');
    }

    public function firmConsultant()
    {
        return $this->hasOne('App\Model\FirmConsultant');
    }

    public function financialInstitution()
    {
        return $this->hasOne('App\Model\FinancialInstitution');
    }

    public function insurance()
    {
        return $this->hasOne('App\Model\Insurance');
    }

    public function investor()
    {
        return $this->hasOne('App\Model\Investor');
    }

    public function funder()
    {
        return $this->hasOne('App\Model\Investor');
    }

    public function setupOrganization()
    {
        if ($this->organizationType->name == 'company') {
            Company::create(
                [
                    'id' => $this->id,
                    'organization_id' => $this->id,
                ]
            );
        }

        $this->setupWallet();
        return $this;
    }

    public function setupWallet()
    {
        $wallet = Wallet::create(
            [
                'ref' => (string) Str::uuid(),
                'organization_id' => $this->id,
            ]
        );
    }

    /*
     * For organizations that select an opportunity
     */
    public function opportunities()
    {
        return $this->belongsToMany('App\Model\Organization', 'organizations_opportunities');
    }

    /*
     * For organizations that select an opportunity
     */
    public function organizationsOpportunities()
    {
        return $this->hasMany('App\Model\ManyToMany\OrganizationsOpportunities');
    }

    // for consultant
    public function jobs()
    {
        return $this->belongsToMany('App\Model\Job', 'organizations_jobs');
    }

    // for consultant
    public function organizationsJobs()
    {
        return $this->hasMany('App\Model\ManyToMany\OrganizationsJobs');
    }

    //

    public function changeResponsible($user_id)
    {
        $this->responsible->user_id = $user_id;
    }

    public function getDatePath($createdAt)
    {
        $year = Carbon::createFromFormat('Y-m-d H:i:s', $createdAt)->year;
        $month = Carbon::createFromFormat('Y-m-d H:i:s', $createdAt)->month;
        $day = Carbon::createFromFormat('Y-m-d H:i:s', $createdAt)->day;

        return $year.'/'.$month.'/'.$day;
    }

    public function uploadLogo($photo_path)
    {
        $path = 'storage/'.$this->organizationType->name.'/'.$this->organizationSubType->name.'/'.$this->getDatePath($this->created_at).'/'.md5($this->name).'/logo';
        $this->photo_path = $photo_path->store($path);
        $this->save();
    }

    public function uploadDocument($document)
    {
        $path = 'storage/'.$this->organizationType->name.'/'.$this->organizationSubType->name.'/'.$this->getDatePath($this->created_at).'/'.md5($this->name).'/document';
        $this->document = $document->store($path);
        $this->save();
    }

    public function StoreSector($sectors)
    {
        foreach ($sectors as &$sector) {
            $organizationsSectors = OrganizationsSectors::create(
                [
                    'organization_id' => $this->id,
                    'sector_id' => $sector,
                ]
            );
        }
    }

    public function StoreSubSector($subSectors)
    {
        foreach ($subSectors as &$subSector) {
            $organizationsSubSectors = OrganizationsSectors::create(
                [
                    'organization_id' => $this->id,
                    'sub_sector_id' => $subSectors,
                ]
            );
        }
    }

    public function storeQualification($qualifications)
    {
        foreach ($qualifications as &$qualificationName) {
            $qualification = Speciality::where('name', $qualificationName)->first();
            if (!$qualification) {
                $qualification = new Qualification;
                $qualification->name = $qualificationName;
                $qualification->save();
            }

            $organizationsQualifications = OrganizationsQualifications::create(
                [
                    'organization_id' => $this->id,
                    'qualification_id' => $qualification->id,
                ]
            );
        }
    }

    public function updateQualification($qualifications)
    {
        $organizationsQualifications = OrganizationsQualifications::where('organization_id', $this->id)->get();
        if ($organizationsQualifications) {
            foreach ($organizationsQualifications as $organizationQualification) {
                $organizationQualification->delete();
            }
        }

        $this->storeQualification($qualifications);
    }

    public function storeSpeciality($specialities)
    {
        foreach ($specialities as &$specialityName) {
            $speciality = Speciality::where('name', $specialityName)->first();
            if (!$speciality) {
                $speciality = new Speciality;
                $speciality->name = $specialityName;
                $speciality->save();
            }

            $organizationSpeciality = OrganizationsSpecialities::create(
                [
                    'organization_id' => $this->id,
                    'speciality_id' => $speciality->id,
                ]
            );
        }
    }

    public function updateSpeciality($specialities)
    {
        $organizationSpecialities = OrganizationsSpecialities::where('organization_id', $this->id)->get();
        if ($organizationSpecialities) {
            foreach ($organizationSpecialities as $organizationSpeciality) {
                $organizationSpeciality->delete();
            }
        }

        $this->storeSpeciality($specialities);
    }
}
