<?php

// (cd php/ && php -d extension=../target/debug/libstephp_cap_std.so test.php)

include_once('common.php');
include_once('ambient_authority.php');
include_once('open_ambient_dir.php');
include_once('permissions_extended.php');
include_once('dir/canonicalize.php');
include_once('dir/clone.php');
include_once('dir/copy.php');
include_once('dir/create_dir.php');
include_once('dir/create_dir_all.php');
include_once('dir/dir_metadata.php');
include_once('dir/entries.php');
include_once('dir/exists.php');
include_once('dir/hard_link.php');
include_once('dir/is_file.php');
include_once('dir/is_dir.php');
include_once('dir/metadata.php');
include_once('dir/open_dir.php');
include_once('dir/open_mode.php');
include_once('dir/open_options.php');
include_once('dir/open_with.php');
include_once('dir/read.php');
include_once('dir/read_dir.php');
include_once('dir/read_link.php');
include_once('dir/read_to_string.php');
include_once('dir/remove_dir.php');
include_once('dir/remove_dir_all.php');
include_once('dir/remove_file.php');
include_once('dir/rename.php');
include_once('dir/set_permissions.php');
include_once('dir/symlink_metadata.php');
include_once('dir/symlink.php');
include_once('dir/symlink_safety.php');
include_once('dir/traversal_blocked.php');
include_once('dir/write.php');
include_once('file/clone.php');
include_once('file/read.php');
include_once('file/read_to_end.php');
include_once('file/seek.php');
include_once('file/seek_extended.php');
include_once('file/stream_len.php');
include_once('file/flush.php');
include_once('file/read_to_string.php');
include_once('file/rewind.php');
include_once('file/set_len.php');
include_once('file/set_permissions.php');
include_once('file/set_times.php');
include_once('file/stream_position.php');
include_once('file/sync_all.php');
include_once('file/sync_data.php');
include_once('file/write.php');

$ROOT = sys_get_temp_dir() . '/php-cap-std-tests-' . uniqid();
if (! mkdir($ROOT)) {
    die("Unable to create test root directory: $ROOT\n");
}

try {
    tests\ambient_authority();
    tests\open_ambient_dir($ROOT);
    tests\permissions_extended($ROOT);
    tests\dir\canonicalize($ROOT);
    tests\dir\clone_test($ROOT);
    tests\dir\copy($ROOT);
    tests\dir\create_dir($ROOT);
    tests\dir\create_dir_all($ROOT);
    tests\dir\dir_metadata($ROOT);
    tests\dir\entries($ROOT);
    tests\dir\exists($ROOT);
    tests\dir\hard_link($ROOT);
    tests\dir\is_file_test($ROOT);
    tests\dir\is_dir_test($ROOT);
    tests\dir\metadata($ROOT);
    tests\dir\open_dir($ROOT);
    tests\dir\open_mode($ROOT);
    tests\dir\open_options($ROOT);
    tests\dir\open_with($ROOT);
    tests\dir\read($ROOT);
    tests\dir\read_dir($ROOT);
    tests\dir\read_link($ROOT);
    tests\dir\read_to_string($ROOT);
    tests\dir\remove_dir($ROOT);
    tests\dir\remove_dir_all($ROOT);
    tests\dir\remove_file($ROOT);
    tests\dir\rename($ROOT);
    tests\dir\set_permissions($ROOT);
    tests\dir\symlink_metadata($ROOT);
    tests\dir\symlink_test($ROOT);
    tests\dir\symlink_safety($ROOT);
    tests\dir\traversal_blocked($ROOT);
    tests\dir\write($ROOT);
    tests\file\clone_test($ROOT);
    tests\file\read($ROOT);
    tests\file\read_to_end($ROOT);
    tests\file\seek($ROOT);
    tests\file\seek_extended($ROOT);
    tests\file\stream_len($ROOT);
    tests\file\flush($ROOT);
    tests\file\read_to_string($ROOT);
    tests\file\rewind($ROOT);
    tests\file\set_len($ROOT);
    tests\file\set_permissions($ROOT);
    tests\file\set_times($ROOT);
    tests\file\stream_position($ROOT);
    tests\file\sync_all($ROOT);
    tests\file\sync_data($ROOT);
    tests\file\write($ROOT);
} finally {
    recursive_rmdir($ROOT);
}

result();
