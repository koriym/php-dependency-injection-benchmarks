<?php

$cache = __DIR__ . '/tmp/cached_injector6';
if (file_exists($cache)) {
	$injector = unserialize(file_get_contents($cache));
} else {
	$injector = new \Ray\Di\Injector(new Module, __DIR__ . '/tmp');
	file_put_contents($cache, serialize($injector));
}
//trigger autoloaders
$j = $injector->getInstance('J');

for ($i = 0; $i < 10000; $i++) {
	$a = $injector->getInstance('J');
}

$results = [
'time' => 0,
'files' => count(get_included_files()),
'memory' => memory_get_peak_usage()/1024/1024
];

echo json_encode($results);