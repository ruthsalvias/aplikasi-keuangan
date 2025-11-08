<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();
use Illuminate\Support\Facades\DB;

$rows = DB::table('transaction_receipts')->limit(10)->get();
if ($rows->isEmpty()) {
    echo "No rows in transaction_receipts\n";
} else {
    foreach ($rows as $r) {
        echo "receipt id={$r->id} transaction_id={$r->transaction_id} path={$r->path} uploaded_by={$r->uploaded_by}\n";
    }
}

$tx = DB::table('transactions')->whereNotNull('receipt_image_path')->orWhereExists(function($q){$q->select(DB::raw(1))->from('transaction_receipts')->whereColumn('transaction_receipts.transaction_id','transactions.id');})->limit(10)->get();
if ($tx->isEmpty()) {
    echo "No transactions with receipt paths found\n";
} else {
    foreach ($tx as $t) {
        echo "transaction id={$t->id} receipt_image_path={$t->receipt_image_path}\n";
    }
}
