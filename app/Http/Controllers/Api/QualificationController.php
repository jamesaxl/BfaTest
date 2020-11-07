<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Qualification;

class QualificationController extends Controller
{
    public function index()
    {
        $qualifications = Qualification::with('speciality')->get();
        return response()->json($qualifications);
    }
}
