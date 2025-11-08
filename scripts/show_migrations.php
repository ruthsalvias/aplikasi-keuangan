<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

$rows = DB::table('migrations')->orderBy('batch','asc')->orderBy('migration','asc')->get();
if ($rows->isEmpty()) {
    echo "(no migrations rows)\n";
    exit;
}
foreach ($rows as $r) {
    echo $r->id . ' | ' . $r->migration . ' | batch: ' . $r->batch . PHP_EOL;
}
