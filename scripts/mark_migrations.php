<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

$toMark = [
    '2023_11_08_000001_create_transactions_table',
    '2023_11_08_000002_create_transaction_receipts_table',
];

$maxBatch = DB::table('migrations')->max('batch');
if ($maxBatch === null) $maxBatch = 0;
$batchToUse = $maxBatch + 1;

foreach ($toMark as $migration) {
    $exists = DB::table('migrations')->where('migration', $migration)->exists();
    if ($exists) {
        echo "skip: $migration already recorded\n";
        continue;
    }
    DB::table('migrations')->insert([
        'migration' => $migration,
        'batch' => $batchToUse,
    ]);
    echo "marked: $migration -> batch $batchToUse\n";
}

