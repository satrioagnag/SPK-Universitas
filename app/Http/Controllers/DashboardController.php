<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Alternatif;
use App\Models\Criteria;
use App\Models\Topsis_result;

class DashboardController extends Controller
{
    public function index()
    {
        $alternativeCount = Alternatif::count();
        $totalCriteria = Criteria::count();
        $totalTopsisResults = Topsis_result::count();
        $lastresult = Topsis_result::latest()->first();

        return view('dashboard', compact(
            'alternativeCount',
            'totalCriteria',
            'totalTopsisResults',
            'lastresult'
        ));
    }
}
