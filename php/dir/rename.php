<?php

namespace tests\dir;

function rename(string $root) {
    $ambient_auth = stephp_cap_std_ambient_authority();
    $dir = stephp_cap_std_open_ambient_dir($ambient_auth, $root);
    $tmp = tempnam($root, 'test-stephp-cap-std');
    if ($tmp !== false) {
        $file = basename($tmp);
        $dir->rename($file, $dir, "rename-$file");
        if (is_file("$root/rename-$file")) {
            ok('dir: rename: rename of ' . $tmp . ' to rename-' . $file . ' succeeds');
        } else {
            ko("dir: rename: rename of temporary file $tmp fails, $tmp/rename-$file doesn't exist or is not a file");
        }
        if (is_file($tmp)) {
            @unlink($tmp);
        }
        if (is_file("$root/rename-$file")) {
            @unlink("$root/rename-$file");
        }
    } else {
        ko('dir: rename: unable to create temporary file');
    }
}