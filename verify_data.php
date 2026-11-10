<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$pdo = new PDO('mysql:host=127.0.0.1;dbname=spk_menu_gizi','root','');

echo "=== CRITERIAS ===" . PHP_EOL;
foreach ($pdo->query('SELECT id, code, name, attribute, weight FROM criterias') as $row) {
    echo implode(' | ', $row) . PHP_EOL;
}

echo PHP_EOL . "=== ALTERNATIVES (count) ===" . PHP_EOL;
$count = $pdo->query('SELECT COUNT(*) as cnt FROM alternatives')->fetch();
echo "Total: " . $count['cnt'] . PHP_EOL;

echo PHP_EOL . "=== ALTERNATIVE VALUES (count) ===" . PHP_EOL;
$count = $pdo->query('SELECT COUNT(*) as cnt FROM alternative_values')->fetch();
echo "Total: " . $count['cnt'] . PHP_EOL;
