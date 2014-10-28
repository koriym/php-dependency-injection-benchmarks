<?php

use Ray\Di\Injector;

error_reporting(E_ALL);
ini_set('display_errors', 'on');

require_once '../testclasses.php';
require_once __DIR__ . '/vendor/autoload.php';

use Ray\Di\Scope;
use Ray\Di\AbstractModule;

class TestModule extends AbstractModule
{
	protected function configure()
	{
		$this->bind('A')->to('A')->in(Scope::SINGLETON);
	}
}

$cache = __FILE__ . '.cache';
if (! file_exists($cache)) {
	$injector = new Injector(new TestModule);
	$injector->getInstance('A');
	file_put_contents($cache, serialize($injector));
	exit;
}
$di = unserialize(file_get_contents($cache));
//Trigger the autoloader before measuring execution time
$di->getInstance('A');

$t1 = microtime(true);

for ($i = 0; $i < 10000; $i++) {
	$a = $di->getInstance('A');
}

$t2 = microtime(true);

echo ($t2 - $t1);

echo '<br />' . ($t2 - $t1);

echo '<br /># Files: ' . count(get_included_files());
echo '<br />Memory usage:' . (memory_get_peak_usage()/1024/1024) . 'mb';
