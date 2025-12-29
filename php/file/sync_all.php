<?php

namespace tests\file;

function sync_all(string $root) {
    $filename = 'test-stephp-cap-std-file';
    $filepath = $root . '/' . $filename;
    if (! file_exists($filepath)) {
        file_put_contents($filepath, '');
    }
    $ambient_auth = stephp_cap_std_ambient_authority();
    $dir = stephp_cap_std_open_ambient_dir($ambient_auth, $root);
    $fd = $dir->open($filename);
    $r = $fd->sync_all();
    if (file_exists($filepath)) {
        unlink($filepath);
    }
    if ($r === null) {
        ok('file: sync_all: returned null');
    } else {
        ko('file: sync_all: should have returned null, returned ' . var_export($r, false));
    }
}