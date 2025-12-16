<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();
$match = App\Models\MatchModel::find($argv[1] ?? 1);
$score = $argv[2] ?? '3-4';
if (!$match) {
    echo "no match\n";
    exit;
}
$match->update(['score' => $score]);
echo "updated to: " . $match->fresh()->score . "\n";
