<?php

use Ray\Di\Injector;

error_reporting(E_ALL);
ini_set('display_errors', 'on');

require_once '../testclasses.php';
require_once __DIR__ . '/vendor/autoload.php';

$cache = __FILE__ . '.cache';
if (! file_exists($cache)) {
	$injector = new Injector;
	$injector->getInstance('A');
	file_put_contents($cache, serialize($injector));
	exit;
}

$t1 = microtime(true);

$di = unserialize(file_get_contents($cache));
for ($i = 0; $i < 10000; $i++) {
	$a = $di->getInstance('A');
}

$t2 = microtime(true);

echo ($t2 - $t1);

echo '<br /># Files: ' . count(get_included_files());
echo '<br />Memory usage:' . (memory_get_peak_usage()/1024/1024) . 'mb';
