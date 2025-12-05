<?php

namespace App\Http\Controllers;

use app\Models\criteria_pairwise;
use app\Models\Criteria;
use app\services\AHPService;
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
        $criteria = Criterion::where('is_active', true)->orderBy('code')->get();

        // Ambil pairwise yang sudah ada
        $pairs = CriteriaPairwise::all()
            ->keyBy(fn($p) => $p->criterion_row_id . '_' . $p->criterion_col_id);

        return view('ahp.index', compact('criteria', 'pairs'));
    }

    public function storeComparisons(Request $request)
    {
        $criteria = Criterion::where('is_active', true)->orderBy('code')->get();

        foreach ($criteria as $row) {
            foreach ($criteria as $col) {
                if ($row->id === $col->id) {
                    // diagonal ⇒ tidak perlu disimpan (anggap 1)
                    continue;
                }

                $field = "pair_{$row->id}_{$col->id}";
                $value = $request->input($field);

                if ($value === null || $value === '') {
                    continue;
                }

                $value = (float) $value;

                CriteriaPairwise::updateOrCreate(
                    [
                        'criterion_row_id' => $row->id,
                        'criterion_col_id' => $col->id,
                    ],
                    ['value' => $value]
                );
            }
        }

        return redirect()->route('ahp.index')->with('success', 'Pairwise comparisons saved.');
    }

    public function calculate()
    {
        $criteria = Criterion::where('is_active', true)->orderBy('code')->get();

        if ($criteria->isEmpty()) {
            return redirect()->route('ahp.index')->with('error', 'No active criteria.');
        }

        $result = $this->ahp->calculateForCriteria($criteria);

        // Simpan bobot ke tabel criteria
        foreach ($criteria as $criterion) {
            if (isset($result['weights'][$criterion->id])) {
                $criterion->weight = $result['weights'][$criterion->id];
                $criterion->save();
            }
        }

        $cr = $result['cr'];

        return redirect()->route('ahp.index')->with([
            'success' => 'AHP weights calculated. CR = ' . round($cr, 4),
        ]);
    }
}
