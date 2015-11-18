<?php

$t1 = microtime(true);
$tmpDir = __DIR__ . '/tmp/4';
if (! file_exists($tmpDir)) {
	class Module extends \Ray\Di\AbstractModule
	{
		protected function configure()
		{
			$this->bind('A')->in(\Ray\Di\Scope::SINGLETON);
			$this->bind('B');
		}
	}
	mkdir($tmpDir);
	$compiler = new \Ray\Compiler\DiCompiler(new Module, $tmpDir);
	$compiler->compile();
	die('Complied. Run Again !');
}

$injector = new \Ray\Compiler\ScriptInjector($tmpDir);
$instance = $injector->getInstance('A');

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