<?php

namespace tests\dir;

function open_dir(string $root) {
    $ambient_auth = stephp_cap_std_ambient_authority();
    $dir = stephp_cap_std_open_ambient_dir($ambient_auth, $root);
    $newdir = 'test-stephp-cap-std';
    $newdir_path = $root . '/' . $newdir;
    if (! is_dir($newdir_path)) {
        $dir->create_dir($newdir);
    }
    $testdir = $dir->open_dir($newdir);
    if (is_a($testdir, 'StephpCapStdDir')) {
        ok('dir: open_dir() returned an StephpCapStdDir object');
    } else {
        ko('dir: open_dir() should return an StephpCapStdDir object');
    }
}