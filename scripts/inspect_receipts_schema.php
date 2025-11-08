<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

function printCols($table) {
    echo "Columns for $table:\n";
    try {
        $cols = Schema::getColumnListing($table);
        foreach ($cols as $c) echo " - $c\n";
    } catch (Exception $e) {
        echo "  (cannot get columns: " . $e->getMessage() . ")\n";
    }
}

printCols('transactions');
printCols('transaction_receipts');

echo "\nSample transactions rows (id, receipt_image_path):\n";
$tx = DB::table('transactions')->select('id','receipt_image_path')->limit(20)->get();
foreach ($tx as $r) {
    echo "id={$r->id} receipt_image_path={$r->receipt_image_path}\n";
}

echo "\nSample transaction_receipts rows (id,transaction_id,path):\n";
$rows = DB::table('transaction_receipts')->select('id','transaction_id','path')->limit(20)->get();
foreach ($rows as $r) {
    echo "id={$r->id} tx={$r->transaction_id} path={$r->path}\n";
}

// Check existence of files listed
$paths = collect(DB::table('transaction_receipts')->pluck('path')->toArray())->unique()->filter();
if ($paths->isEmpty()) {
    echo "\nNo receipt paths found to check.\n";
} else {
    echo "\nChecking file existence on storage/app/public (public disk) for some paths:\n";
    foreach ($paths as $p) {
        $exists = file_exists(__DIR__ . '/../storage/app/public/' . $p) ? 'exists' : 'missing';
        echo " - $p => $exists\n";
    }
}

echo "\nAlso check public/storage/receipts directory listing (if symlink exists):\n";
$dir = __DIR__ . '/../public/storage/receipts';
if (is_dir($dir)) {
    $files = scandir($dir);
    foreach ($files as $f) {
        if ($f === '.' || $f === '..') continue;
        echo " - $f\n";
    }
} else {
    echo " public/storage/receipts not found or symlink missing.\n";
}

