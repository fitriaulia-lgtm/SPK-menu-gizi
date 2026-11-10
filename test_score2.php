<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

$row = DB::table('alternatives')->where('code', 'A8')->first(['code', 'score']);
echo "Raw DB score for A8: " . var_export($row->score, true) . PHP_EOL;

$row2 = DB::table('alternatives')->where('code', 'A8')->first();
echo "Raw DB score (all cols): " . var_export($row2->score, true) . PHP_EOL;
