<?php

namespace App\Services;

use App\Models\Criteria;
use App\Models\Alternative;
use App\Models\AlternativeValue;

/**
 * TopsisService
 *
 * Mengimplementasikan seluruh tahapan perhitungan TOPSIS
 * (Technique for Order of Preference by Similarity to Ideal Solution)
 * yang dipadukan dengan bobot AHP tetap.
 *
 * Langkah-langkah:
 *   1.  Baca matriks keputusan dari database
 *   2.  Normalisasi matriks (metode euclidean)
 *   3.  Pembobotan matriks ternormalisasi (bobot AHP)
 *   4.  Tentukan Solusi Ideal Positif (A+) dan Negatif (A-)
 *       berdasarkan atribut kriteria (benefit / cost)
 *   5.  Hitung jarak ke A+ (D+) dan A- (D-)
 *   6.  Hitung nilai preferensi Vi = D- / (D+ + D-)
 *   7.  Urutkan hasil dari Vi terbesar ke terkecil (Rank)
 */
class TopsisService
{
    private static ?array $cachedWeights = null;
    private static ?array $cachedRanking = null;

    private function getCachedWeights(): array
    {
        if (self::$cachedWeights !== null) {
            return self::$cachedWeights;
        }
        $criterias = Criteria::all()->keyBy('code');
        $weights = [];
        foreach ($criterias as $code => $crit) {
            $weights[$code] = $crit->weight > 0 ? (float) $crit->weight : 0.0;
        }
        $total = array_sum($weights);
        if ($total > 0) {
            foreach ($weights as $code => $w) {
                $weights[$code] = $w / $total;
            }
        }
        return self::$cachedWeights = $weights;
    }

    private function buildValueMap($alternatives, $criterias): array
    {
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
        return $valueMap;
    }

    public function calculate(bool $useStoredScores = true, $alternatives = null, $criterias = null): array
    {
        if ($useStoredScores && self::$cachedRanking !== null) {
            return self::$cachedRanking;
        }

        $criterias = $criterias ?? Criteria::all()->keyBy('code');
        $alternatives = $alternatives ?? Alternative::with('alternativeValues')->get();

        if ($alternatives->isEmpty() || $criterias->isEmpty()) {
            return ['rankingResults' => [], 'bestMenu' => null, 'weights' => [], 'steps' => []];
        }

        $weights = $this->getCachedWeights();
        $criteriaCodes = $criterias->keys()->toArray();
        $valueMap = $this->buildValueMap($alternatives, $criterias);

        $matrixX = $valueMap;

        $dividers = [];
        foreach ($criteriaCodes as $code) {
            $sumSq = 0.0;
            foreach ($alternatives as $alt) {
                $sumSq += ($matrixX[$alt->id][$code] ** 2);
            }
            $dividers[$code] = $sumSq > 0 ? sqrt($sumSq) : 1.0;
        }

        $matrixY = [];
        foreach ($alternatives as $alt) {
            foreach ($criteriaCodes as $code) {
                $matrixY[$alt->id][$code] = ($matrixX[$alt->id][$code] / $dividers[$code]) * $weights[$code];
            }
        }

        $idealPos = [];
        $idealNeg = [];
        foreach ($criteriaCodes as $code) {
            $colValues = array_column($matrixY, $code);
            $isBenefit = ($criterias[$code]->attribute !== 'cost');
            $idealPos[$code] = $isBenefit ? max($colValues) : min($colValues);
            $idealNeg[$code] = $isBenefit ? min($colValues) : max($colValues);
        }

        $rankingResults = [];
        foreach ($alternatives as $alt) {
            $sumSqPos = 0.0;
            $sumSqNeg = 0.0;
            foreach ($criteriaCodes as $code) {
                $y = $matrixY[$alt->id][$code];
                $sumSqPos += (($y - $idealPos[$code]) ** 2);
                $sumSqNeg += (($y - $idealNeg[$code]) ** 2);
            }

            $dPos = sqrt($sumSqPos);
            $dNeg = sqrt($sumSqNeg);
            $computedScore = ($dPos + $dNeg) > 0 ? ($dNeg / ($dPos + $dNeg)) : 0.0;
            $displayScore = ($useStoredScores && $alt->score !== null) ? (float) $alt->score : $computedScore;

            $rankingResults[] = [
                'id' => $alt->id, 'code' => $alt->code, 'name' => $alt->name,
                'score' => $displayScore, 'd_pos' => $dPos, 'd_neg' => $dNeg,
            ];
        }

        usort($rankingResults, static fn ($a, $b) => $b['score'] <=> $a['score']);

        foreach ($rankingResults as $index => &$res) {
            $res['rank'] = $index + 1;
        }
        unset($res);

        return [
            'rankingResults' => $rankingResults,
            'bestMenu' => $rankingResults[0] ?? null,
            'weights' => $weights,
            'steps' => ['matrixX' => $matrixX, 'dividers' => $dividers, 'matrixY' => $matrixY, 'idealPos' => $idealPos, 'idealNeg' => $idealNeg],
        ];
    }

    public function calculateWithTargets(array $targetValues, $alternatives = null, $criterias = null): array
    {
        $criterias = $criterias ?? Criteria::all()->keyBy('code');
        $alternatives = $alternatives ?? Alternative::with('alternativeValues')->get();

        if ($alternatives->isEmpty() || $criterias->isEmpty()) {
            return ['rankingResults' => [], 'bestMenu' => null];
        }

        $weights = $this->getCachedWeights();
        $criteriaCodes = $criterias->keys()->toArray();
        $codeById = [];
        foreach ($criterias as $code => $crit) {
            $codeById[$crit->id] = $code;
        }

        $valueMap = [];
        foreach ($alternatives as $alt) {
            $valueMap[$alt->id] = array_fill_keys($criteriaCodes, 0.0);
            foreach ($alt->alternativeValues as $av) {
                $code = $codeById[$av->criteria_id] ?? null;
                if ($code) {
                    $valueMap[$alt->id][$code] = (float) $av->value;
                }
            }
        }

        $dividers = [];
        foreach ($criteriaCodes as $code) {
            $sumSq = 0.0;
            foreach ($alternatives as $alt) {
                $sumSq += ($valueMap[$alt->id][$code] ** 2);
            }
            $dividers[$code] = $sumSq > 0 ? sqrt($sumSq) : 1.0;
        }

        $matrixY = [];
        foreach ($alternatives as $alt) {
            foreach ($criteriaCodes as $code) {
                $matrixY[$alt->id][$code] = ($valueMap[$alt->id][$code] / $dividers[$code]) * $weights[$code];
            }
        }

        $idealPos = [];
        $idealNeg = [];
        foreach ($criteriaCodes as $code) {
            $colValues = array_column($matrixY, $code);
            $isBenefit = ($criterias[$code]->attribute !== 'cost');
            if (isset($targetValues[$code])) {
                $idealPos[$code] = (float) $targetValues[$code] * $weights[$code];
                $idealNeg[$code] = $isBenefit ? min($colValues) : max($colValues);
            } else {
                $idealPos[$code] = $isBenefit ? max($colValues) : min($colValues);
                $idealNeg[$code] = $isBenefit ? min($colValues) : max($colValues);
            }
        }

        $rankingResults = [];
        foreach ($alternatives as $alt) {
            $sumSqPos = 0.0;
            $sumSqNeg = 0.0;
            foreach ($criteriaCodes as $code) {
                $y = $matrixY[$alt->id][$code];
                $sumSqPos += (($y - $idealPos[$code]) ** 2);
                $sumSqNeg += (($y - $idealNeg[$code]) ** 2);
            }
            $dPos = sqrt($sumSqPos);
            $dNeg = sqrt($sumSqNeg);
            $score = ($dPos + $dNeg) > 0 ? ($dNeg / ($dPos + $dNeg)) : 0.0;
            $rankingResults[] = ['id' => $alt->id, 'code' => $alt->code, 'name' => $alt->name, 'score' => $score, 'd_pos' => $dPos, 'd_neg' => $dNeg];
        }

        usort($rankingResults, static fn ($a, $b) => $b['score'] <=> $a['score']);
        foreach ($rankingResults as $index => &$res) {
            $res['rank'] = $index + 1;
        }
        unset($res);

        return ['rankingResults' => $rankingResults, 'bestMenu' => $rankingResults[0] ?? null];
    }

    public function persistAll(array $rankingResults): void
    {
        foreach ($rankingResults as $res) {
            Alternative::where('id', $res['id'])->update(['score' => $res['score']]);
        }
    }

    public function getWeights(): array
    {
        return $this->getCachedWeights();
    }

    public static function clearCache(): void
    {
        self::$cachedWeights = null;
    }
}
