<?php

namespace App\Http\Controllers;

use App\Models\calculation_Run;
use App\Models\Criteria;
use App\Models\topsis_result;
use App\Models\Alternatif;
use App\Services\TOPSISService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TOPSISController extends Controller
{
    protected TOPSISService $topsis;

    public function __construct(TOPSISService $topsis)
    {
        $this->topsis = $topsis;
    }

    public function index()
    {
        // Ambil run terakhir (kalau ada)
        $lastRun = calculation_Run::where('method', 'topsis')
            ->latest('run_at')
            ->first();

        $results = collect();

        if ($lastRun) {
            $results = topsis_result::with('alternative')
                ->where('calculation__run_id', $lastRun->id)
                ->orderBy('rank')
                ->get();
        }

        return view('topsis.index', compact('lastRun', 'results'));
    }

    public function calculate()
    {
        $criteria = Criteria::whereNotNull('Weight')
            ->get();

        if ($criteria->isEmpty()) {
            return redirect()->route('topsis.index')
                ->with('error', 'No criteria with weights. Run AHP first.');
        }

        $alternatives = Alternatif::orderBy('Code')->get();

        if ($alternatives->isEmpty()) {
            return redirect()->route('topsis.index')
                ->with('error', 'No alternatives to evaluate.');
        }

        $results = $this->topsis->calculate($alternatives, $criteria);

        if (empty($results)) {
            return redirect()->route('topsis.index')
                ->with('error', 'No scores available for TOPSIS.');
        }

        DB::transaction(function () use ($results) {
            $run = calculation_Run::create([
                'method' => 'topsis',
                'note'   => 'Automatic run',
                'run_at' => now(),
            ]);

            foreach ($results as $alternativeId => $row) {
                topsis_result::create([
                    'calculation__run_id' => $run->id,
                    'alternative_id' => $alternativeId,
                    'score' => $row['score'],
                    'rank' => $row['rank'],
                ]);
            }
        });

        return redirect()->route('topsis.index')
            ->with('success', 'TOPSIS calculation completed.');
    }
}