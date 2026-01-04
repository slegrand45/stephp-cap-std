<?php

// (cd php/ && php -d extension=../target/debug/libstephp_cap_std.so test.php)

include_once('common.php');
include_once('ambient_authority.php');
include_once('open_ambient_dir.php');
include_once('dir/canonicalize.php');
include_once('dir/copy.php');
include_once('dir/create_dir.php');
include_once('dir/create_dir_all.php');
include_once('dir/dir_metadata.php');
include_once('dir/open_dir.php');
include_once('dir/open_with.php');
include_once('dir/read.php');
include_once('dir/read_dir.php');
include_once('dir/read_to_string.php');
include_once('dir/remove_dir.php');
include_once('dir/remove_dir_all.php');
include_once('dir/remove_file.php');
include_once('dir/rename.php');
include_once('dir/write.php');
include_once('file/read.php');
include_once('file/read_to_end.php');
include_once('file/read_to_string.php');
include_once('file/set_len.php');
include_once('file/set_permissions.php');
include_once('file/stream_position.php');
include_once('file/sync_all.php');
include_once('file/write.php');

$ROOT = '/tmp';
tests\ambient_authority();
tests\open_ambient_dir($ROOT);
tests\dir\canonicalize($ROOT);
tests\dir\copy($ROOT);
tests\dir\create_dir($ROOT);
tests\dir\create_dir_all($ROOT);
tests\dir\dir_metadata($ROOT);
tests\dir\open_dir($ROOT);
tests\dir\open_with($ROOT);
tests\dir\read($ROOT);
tests\dir\read_dir($ROOT);
tests\dir\read_to_string($ROOT);
tests\dir\remove_dir($ROOT);
tests\dir\remove_dir_all($ROOT);
tests\dir\remove_file($ROOT);
tests\dir\rename($ROOT);
tests\dir\write($ROOT);
tests\file\read($ROOT);
tests\file\read_to_end($ROOT);
tests\file\read_to_string($ROOT);
tests\file\set_len($ROOT);
tests\file\set_permissions($ROOT);
tests\file\stream_position($ROOT);
tests\file\sync_all($ROOT);
tests\file\write($ROOT);

result();
