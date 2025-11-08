<?php
// Safe cleanup: backup missing receipt references then null/delete them
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

$timestamp = date('Ymd_His');
$backupDir = __DIR__ . "/missing_receipts_backup_{$timestamp}";
if (!is_dir($backupDir)) mkdir($backupDir, 0755, true);

echo "Backup dir: {$backupDir}\n";

// Collect transactions with non-null receipt_image_path
$transactions = DB::table('transactions')->select('id','receipt_image_path')->whereNotNull('receipt_image_path')->get();
$missingTx = [];
foreach ($transactions as $t) {
    $path = $t->receipt_image_path;
    $exists = false;
    try {
        if ($path && Storage::disk('public')->exists($path)) $exists = true;
    } catch (Exception $e) {
        // ignore
    }
    if (!$exists) {
        $missingTx[] = ['id' => $t->id, 'receipt_image_path' => $path];
    }
}

// Write backup CSV for missing transactions
$txCsv = fopen("{$backupDir}/missing_transactions.csv", 'w');
fputcsv($txCsv, ['id','receipt_image_path']);
foreach ($missingTx as $r) fputcsv($txCsv, [$r['id'], $r['receipt_image_path']]);
fclose($txCsv);

// Collect transaction_receipts rows with missing files
$receipts = DB::table('transaction_receipts')->select('id','transaction_id','path')->get();
$missingReceipts = [];
foreach ($receipts as $r) {
    $exists = false;
    try {
        if ($r->path && Storage::disk('public')->exists($r->path)) $exists = true;
    } catch (Exception $e) {
        // ignore
    }
    if (!$exists) {
        $missingReceipts[] = ['id' => $r->id, 'transaction_id' => $r->transaction_id, 'path' => $r->path];
    }
}

$rcCsv = fopen("{$backupDir}/missing_transaction_receipts.csv", 'w');
fputcsv($rcCsv, ['id','transaction_id','path']);
foreach ($missingReceipts as $r) fputcsv($rcCsv, [$r['id'], $r['transaction_id'], $r['path']]);
fclose($rcCsv);

// Summary
echo "Found " . count($missingTx) . " transactions with missing files.\n";
echo "Found " . count($missingReceipts) . " transaction_receipts rows with missing files.\n";

if (count($missingTx) === 0 && count($missingReceipts) === 0) {
    echo "Nothing to clean. Exiting.\n";
    exit(0);
}

// Perform cleanup: set transactions.receipt_image_path = null for missing
$txIds = array_map(fn($r)=> $r['id'], $missingTx);
if (count($txIds)) {
    DB::table('transactions')->whereIn('id', $txIds)->update(['receipt_image_path' => null]);
    echo "Set receipt_image_path = NULL for " . count($txIds) . " transactions.\n";
}

// Delete orphan transaction_receipts rows
$rcIds = array_map(fn($r)=> $r['id'], $missingReceipts);
if (count($rcIds)) {
    DB::table('transaction_receipts')->whereIn('id', $rcIds)->delete();
    echo "Deleted " . count($rcIds) . " orphan transaction_receipts rows.\n";
}

echo "Cleanup complete. Backups written to {$backupDir}\n";
