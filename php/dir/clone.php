<?php

namespace tests\dir;

function clone_test(string $root) {
    $ambient_auth = stephp_cap_std_ambient_authority();
    $dir = stephp_cap_std_open_ambient_dir($ambient_auth, $root);
    
    $clone = $dir->try_clone();
    if (is_a($clone, 'StephpCapStdDir')) {
        ok('dir: clone: try_clone() returned a StephpCapStdDir object');
    } else {
        ko('dir: clone: try_clone() should return a StephpCapStdDir object');
        return;
    }

    $filename = 'test-clone-dir.txt';
    $clone->write($filename, 'cloned dir write');
    
    if (file_exists($root . '/' . $filename)) {
        ok('dir: clone: write through clone works');
        unlink($root . '/' . $filename);
    } else {
        ko('dir: clone: write through clone failed');
    }
}
