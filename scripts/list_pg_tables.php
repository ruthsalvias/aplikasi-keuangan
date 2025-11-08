<?php
// tiny helper to list tables using the app DB connection
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

$results = DB::select("SELECT tablename FROM pg_tables WHERE schemaname = current_schema() ORDER BY tablename");
foreach ($results as $row) {
    echo $row->tablename . PHP_EOL;
}

