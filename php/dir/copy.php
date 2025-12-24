<?php

namespace tests\dir;

function copy(string $root) {
    $ambient_auth = stephp_cap_std_ambient_authority();
    $dir = stephp_cap_std_open_ambient_dir($ambient_auth, $root);
    $tmp = tempnam($root, 'test-stephp-cap-std');
    if ($tmp !== false) {
        $file = basename($tmp);
        $size = $dir->copy($file, $dir, "copy-$file");
        if ($size === 0 && is_file("$root/copy-$file")) {
            ok('dir: copy: copy of $tmp to copy-$file succeeds');
        }
        if ($size !== 0) {
            ko("dir: copy: copy of temporary file $tmp should have a size of zero");
        }
        if (! is_file("$root/copy-$file")) {
            ko("dir: copy: copy of temporary file $tmp fails, $tmp/copy-$file doesn't exist or is not a file");
        }
        if (is_file($tmp)) {
            @unlink($tmp);
        }
        if (is_file("$root/copy-$file")) {
            @unlink("$root/copy-$file");
        }
    } else {
        ko('dir: copy: unable to create temporary file');
    }
}