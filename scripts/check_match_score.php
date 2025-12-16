<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();
$match = App\Models\MatchModel::find(1);
if (!$match) {
    echo "no match\n";
    exit;
}
echo $match->score ?? 'NULL';
