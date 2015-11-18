<?php

class Module extends \Ray\Di\AbstractModule
{
	protected function configure()
	{
		$this->bind('A');
	}
}

$cache = __DIR__ . '/tmp/cached_injector2';
if (file_exists($cache)) {
	$injector = unserialize(file_get_contents($cache));
} else {
	$injector = new \Ray\Di\Injector(new Module, __DIR__ . '/tmp');
	file_put_contents($cache, serialize($injector));
}
//trigger autoloaders
$a = $injector->getInstance('A');
unset($a);

$t1 = microtime(true);

for ($i = 0; $i < 10000; $i++) {
	$a = $injector->getInstance('A');
}

$t2 = microtime(true);

$results = [
'time' => $t2 - $t1,
'files' => count(get_included_files()),
'memory' => memory_get_peak_usage()/1024/1024
];

echo json_encode($results);