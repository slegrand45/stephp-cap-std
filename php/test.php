<?php

// (cd php/ && php -d extension=../target/debug/libstephp_cap_std.so test.php)

include_once('common.php');
include_once('ambient_authority.php');
include_once('open_ambient_dir.php');
include_once('dir/copy.php');
include_once('dir/create_dir.php');
include_once('dir/create_dir_all.php');
include_once('dir/dir_metadata.php');
include_once('dir/open_dir.php');
include_once('dir/read_dir.php');

$ROOT = '/tmp';
tests\ambient_authority();
tests\open_ambient_dir($ROOT);
tests\dir\create_dir($ROOT);
tests\dir\create_dir_all($ROOT);
tests\dir\dir_metadata($ROOT);
tests\dir\open_dir($ROOT);
tests\dir\read_dir($ROOT);
tests\dir\copy($ROOT);

result();
