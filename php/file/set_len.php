<?php

namespace tests\file;

function set_len(string $root) {
    $filename = 'test-stephp-cap-std-file';
    $filepath = $root . '/' . $filename;
    if (! file_exists($filepath)) {
        file_put_contents($filepath, '');
    }
    $ambient_auth = stephp_cap_std_ambient_authority();
    $dir = stephp_cap_std_open_ambient_dir($ambient_auth, $root);
    $fd = $dir->create($filename);
    $len = 123;
    $r = $fd->set_len($len);
    $size = filesize($filepath);
    if (file_exists($filepath)) {
        unlink($filepath);
    }
    if ($r === null) {
        ok('file: set_len: returned null');
    } else {
        ko('file: set_len: should have returned null, returned ' . var_export($r, false));
    }
    if ($size === $len) {
        ok('file: set_len: file size is right');
    } else {
        ko('file: set_len: file size is wrong, equal to ' . $size . ' but should be ' . $len);
    }
}