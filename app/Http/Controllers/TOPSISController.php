<?php

namespace App\Http\Controllers;

use App\Models\calculation_run;
use app\models\criteria;
use app\Models\Topsis_result;
use app\models\alternatif;
use app\services\TOPSISService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TOPSISController extends Controller
{
    protected TopsisService $topsis;

    public function __construct(TopsisService $topsis)
    {
        $this->topsis = $topsis;
    }

    public function index()
    {
        // Ambil run terakhir (kalau ada)
        $lastRun = CalculationRun::where('method', 'topsis')
            ->latest('run_at')
            ->first();

        $results = collect();

        if ($lastRun) {
            $results = TopsisResult::with('university')
                ->where('calculation_run_id', $lastRun->id)
                ->orderBy('rank')
                ->get();
        }

        return view('topsis.index', compact('lastRun', 'results'));
    }

    public function calculate()
    {
        $criteria = Criterion::where('is_active', true)
            ->whereNotNull('weight')
            ->get();

        if ($criteria->isEmpty()) {
            return redirect()->route('topsis.index')
                ->with('error', 'No criteria with weights. Run AHP first.');
        }

        $universities = University::orderBy('code')->get();

        if ($universities->isEmpty()) {
            return redirect()->route('topsis.index')
                ->with('error', 'No universities to evaluate.');
        }

        $results = $this->topsis->calculate($universities, $criteria);

        if (empty($results)) {
            return redirect()->route('topsis.index')
                ->with('error', 'No scores available for TOPSIS.');
        }

        DB::transaction(function () use ($results) {
            $run = CalculationRun::create([
                'method' => 'topsis',
                'note'   => 'Automatic run',
                'run_at' => now(),
            ]);

            foreach ($results as $universityId => $row) {
                TopsisResult::create([
                    'calculation_run_id' => $run->id,
                    'university_id'      => $universityId,
                    'score'              => $row['score'],
                    'rank'               => $row['rank'],
                ]);
            }
        });

        return redirect()->route('topsis.index')
            ->with('success', 'TOPSIS calculation completed.');
    }
}
