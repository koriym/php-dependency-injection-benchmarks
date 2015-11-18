<?php

$tmpDir = __DIR__ . '/tmp';
if (! file_exists($tmpDir)) {
	require_once __DIR__ . '/Module.php';
	mkdir($tmpDir);
	$compiler = new \Ray\Compiler\DiCompiler(new Module, $tmpDir);
	$compiler->compile();
}

$injector = new \Ray\Compiler\ScriptInjector($tmpDir);
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