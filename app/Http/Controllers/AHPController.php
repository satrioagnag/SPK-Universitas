<?php

namespace App\Http\Controllers;

use App\Models\criteria_pairwise;
use App\Models\Criteria;
use App\Services\AHPService;
use Illuminate\Http\Request;

class AHPController extends Controller
{
    protected AHPService $ahp;

    public function __construct(AHPService $ahp)
    {
        $this->ahp = $ahp;
    }

    public function index()
    {
        $criteria = Criteria::orderBy('Code')->get();

        // Ambil pairwise yang sudah ada
        $pairs = criteria_pairwise::all()
            ->keyBy(fn($p) => $p->criteria_row_id . '_' . $p->criteria_col_id);

        return view('ahp.index', compact('criteria', 'pairs'));
    }

    public function storeComparisons(Request $request)
    {
        $criteria = Criteria::orderBy('Code')->get();

        foreach ($criteria as $row) {
            foreach ($criteria as $col) {
                if ($row->id === $col->id) {
                    continue;
                }

                $field = "pair_{$row->id}_{$col->id}";
                $value = $request->input($field);

                if ($value === null || $value === '') {
                    continue;
                }

                $value = (float) $value;

                criteria_pairwise::updateOrCreate(
                    [
                        'criteria_row_id' => $row->id,
                        'criteria_col_id' => $col->id,
                    ],
                    ['value' => $value]
                );
            }
        }

        return redirect()->route('ahp.index')->with('success', 'Pairwise comparisons saved.');
    }

    public function calculate()
    {
        $criteria = Criteria::orderBy('Code')->get();

        if ($criteria->isEmpty()) {
            return redirect()->route('ahp.index')->with('error', 'No active criteria.');
        }

        $result = $this->ahp->calculateForCriteria($criteria);

        // Simpan bobot ke tabel criteria
        foreach ($criteria as $criterion) {
            if (isset($result['weights'][$criterion->id])) {
                $criterion->Weight = $result['weights'][$criterion->id];
                $criterion->save();
            }
        }

        $cr = $result['cr'];

        return redirect()->route('ahp.index')->with([
            'success' => 'AHP weights calculated. CR = ' . round($cr, 4),
        ]);
    }
}