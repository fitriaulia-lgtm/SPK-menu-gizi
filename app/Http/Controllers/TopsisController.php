<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Alternative;
use App\Models\Criteria;
use App\Models\AlternativeValue;
use App\Services\TopsisService;

class TopsisController extends Controller
{
    protected $topsisService;

    public function __construct(TopsisService $topsisService)
    {
        $this->topsisService = $topsisService;
    }

    public function index()
    {
        $alternatives = Alternative::all();
        $topsisData = $this->topsisService->calculate();
        $bestMenu   = $topsisData['bestMenu'];
        $weights    = $topsisData['weights'] ?? [];

        $criterias = Criteria::all()->keyBy('code');
        $ahpWeights = [];
        foreach ($criterias as $code => $crit) {
            $weight = $weights[$code] ?? 0.0;
            $ahpWeights[$code] = [
                'label' => $crit->name,
                'weight' => $weight,
                'pct' => (int) round($weight * 100),
            ];
        }

        return view('user.dashboard', compact('alternatives', 'ahpWeights', 'bestMenu'));
    }

    public function calculate()
    {
        $topsisData = $this->topsisService->calculate();

        $rankingResults = $topsisData['rankingResults'];
        $bestMenu       = $topsisData['bestMenu'];
        $steps          = $topsisData['steps'];
        $rawWeights     = $topsisData['weights'] ?? [];
        $criterias      = Criteria::all()->keyBy('code');

        $ahpWeights = [];
        foreach ($rawWeights as $code => $weight) {
            $crit = $criterias[$code] ?? null;
            $ahpWeights[$code] = [
                'label' => $crit ? $crit->name : $code,
                'weight' => (float) $weight,
                'pct' => (int) round($weight * 100),
            ];
        }

        $this->topsisService->persistAll($rankingResults);

        return view('user.result', compact('rankingResults', 'bestMenu', 'steps', 'criterias', 'ahpWeights'));
    }

    public function recommendation(Request $request)
    {
        $criterias = Criteria::orderBy('id')->get()->keyBy('code');

        $alternatives = Alternative::with('alternativeValues')->get();

        $codeById = [];
        foreach ($criterias as $code => $crit) {
            $codeById[$crit->id] = $code;
        }

        $valueMap = [];
        foreach ($alternatives as $alt) {
            $valueMap[$alt->id] = array_fill_keys($criterias->keys()->toArray(), 0.0);
            foreach ($alt->alternativeValues as $av) {
                $code = $codeById[$av->criteria_id] ?? null;
                if ($code) {
                    $valueMap[$alt->id][$code] = (float) $av->value;
                }
            }
        }

        $ranges = [];
        foreach ($criterias->keys() as $code) {
            $values = array_column($valueMap, $code);
            $ranges[$code] = [
                'min' => !empty($values) ? min($values) : 0,
                'max' => !empty($values) ? max($values) : 100,
            ];
        }

        $targetValues = $request->input('target_values', []);
        $isSubmitted = $request->has('process');

        $rankingResults = [];
        $bestMenu = null;
        $displayCriteriaCodes = $criterias->keys()->toArray();

        if ($isSubmitted) {
            $topsisData = $this->topsisService->calculate(true, $alternatives, $criterias);
            $rankingResults = $topsisData['rankingResults'];
            $bestMenu = $topsisData['bestMenu'];

            $targetValues = [];
            foreach ($criterias as $code => $crit) {
                $val = (float) ($request->input("target_values.$code") ?? 0);
                if ($val > 0) {
                    $targetValues[$code] = $val;
                }
            }

            foreach ($rankingResults as &$res) {
                $vals = $valueMap[$res['id']] ?? [];
                foreach ($vals as $code => $val) {
                    $res[$code] = $val;
                }
                $res['distance'] = 0;
                if (!empty($targetValues)) {
                    $sumSq = 0;
                    foreach ($targetValues as $code => $target) {
                        $actual = $vals[$code] ?? 0;
                        $sumSq += ($actual - $target) ** 2;
                    }
                    $res['distance'] = sqrt($sumSq);
                }
            }
            unset($res);

            usort($rankingResults, function ($a, $b) use ($targetValues) {
                if (!empty($targetValues)) {
                    $da = $a['distance'] ?? 0;
                    $db = $b['distance'] ?? 0;
                    if ($da !== $db) {
                        return $da <=> $db;
                    }
                }
                return ($b['score'] ?? 0) <=> ($a['score'] ?? 0);
            });

            foreach ($rankingResults as $index => &$res) {
                $res['rank'] = $index + 1;
                if ($index === 0) {
                    $res['is_best'] = true;
                }
            }
            unset($res);
            $bestMenu = $rankingResults[0] ?? null;
        }

        return view('user.recommendation', compact(
            'rankingResults',
            'criterias',
            'ranges',
            'targetValues',
            'displayCriteriaCodes',
            'isSubmitted',
            'bestMenu'
        ));
    }
}
