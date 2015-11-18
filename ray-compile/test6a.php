<?php

$tmpDir = __DIR__ . '/tmp/6';
if (! file_exists($tmpDir)) {
	require __DIR__ . '/Module.php';
	mkdir($tmpDir);
	$compiler = new \Ray\Compiler\DiCompiler(new Module, $tmpDir);
	$compiler->compile();
}

$injector = new \Ray\Compiler\ScriptInjector($tmpDir);
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