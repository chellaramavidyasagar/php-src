--TEST--
Phar: opendir test, subdirectory
--SKIPIF--
<?php if (!extension_loaded("phar")) die("skip"); ?>
--INI--
phar.require_hash=0
--FILE--
<?php

$fname = dirname(__FILE__) . '/' . basename(__FILE__, '.php') . '.phar.php';
$pname = 'phar://' . $fname;
$file = "<?php
Phar::mapPhar('hio');
__HALT_COMPILER(); ?>";

$files = array();
$files['a'] = 'a';
$files['b/a'] = 'b';
$files['b/c/d'] = 'c';
$files['bad/c'] = 'd';

include 'files/phar_test.inc';
include $fname;

$dir = opendir('phar://hio/b');

if ($dir) {
	while (false !== ($a = readdir($dir))) {
		var_dump($a);
		var_dump(is_dir('phar://hio/b/' . $a));
	}
}

?>
--CLEAN--
<?php unlink(dirname(__FILE__) . '/' . basename(__FILE__, '.clean.php') . '.phar.php'); ?>
--EXPECTF--
%s(1) "a"
bool(false)
%s(1) "c"
bool(true)
