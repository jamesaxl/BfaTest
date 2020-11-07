<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\City;

class CityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return mixed
     */
    public function index()
    {
        $cities = City::paginate(30);
        return response()->json($cities);
    }

    /**
     * Display a listing of the resource.
     *
     * @param $countryId
     * @return mixed
     */
    public function indexInCountry($countryId)
    {
        $cities = City::where('country_id',$countryId )->get();
        return response()->json($cities);
    }
}
