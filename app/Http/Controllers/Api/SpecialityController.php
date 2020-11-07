<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Speciality;

class SpecialityController extends Controller
{
    public function index()
    {
        $specialities = Speciality::with('qualifications')->get();
        return response()->json($specialities);
    }
}
