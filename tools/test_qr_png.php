<?php
require __DIR__ . '/../vendor/autoload.php';
echo extension_loaded('gd') ? "gd ok\n" : "no gd\n";
try {
    $png = (new SimpleSoftwareIO\QrCode\Generator())->format('png')->size(100)->generate('test');
    echo 'png len=' . strlen($png) . "\n";
} catch (Throwable $e) {
    echo 'err: ' . $e->getMessage() . "\n";
}
