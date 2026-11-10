<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Alternative;
use App\Services\TopsisService;

$alt = Alternative::with('alternativeValues')->where('code', 'A8')->first();
echo "Model score for A8: " . $alt->score . PHP_EOL;

$svc = new TopsisService();
$result = $svc->calculate();
$a8 = collect($result['rankingResults'])->firstWhere('code', 'A8');
echo "Service score for A8: " . $a8['score'] . PHP_EOL;
