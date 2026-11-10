<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$pdo = new PDO('mysql:host=127.0.0.1;dbname=spk_menu_gizi','root','');
foreach ($pdo->query('SELECT * FROM criterias') as $row) {
    echo implode(' | ', $row) . PHP_EOL;
}
