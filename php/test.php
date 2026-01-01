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
include_once('file/read.php');
include_once('file/set_len.php');
include_once('file/set_permissions.php');
include_once('file/sync_all.php');

$ROOT = '/tmp';
tests\ambient_authority();
tests\open_ambient_dir($ROOT);
tests\dir\create_dir($ROOT);
tests\dir\create_dir_all($ROOT);
tests\dir\dir_metadata($ROOT);
tests\dir\open_dir($ROOT);
tests\dir\read_dir($ROOT);
tests\dir\copy($ROOT);
tests\file\read($ROOT);
tests\file\set_len($ROOT);
tests\file\set_permissions($ROOT);
tests\file\sync_all($ROOT);

result();
