<?php

namespace tests\dir;

function symlink_test(string $root) {
    if (PHP_OS_FAMILY === 'Windows') {
        warning('dir: symlink: skipped on Windows');
        return;
    }

    if (! method_exists('StephpCapStdDir', 'symlink')) {
        warning('dir: symlink: StephpCapStdDir::symlink not available');
        return;
    }

    $ambient_auth = stephp_cap_std_ambient_authority();
    $dir = stephp_cap_std_open_ambient_dir($ambient_auth, $root);

    $target = 'test-stephp-cap-std-symlink-target';
    $targetpath = $root . '/' . $target;
    if (is_file($targetpath)) {
        unlink($targetpath);
    }
    file_put_contents($targetpath, 'symlink target');

    $linkname = 'test-stephp-cap-std-symlink-created';
    $linkpath = $root . '/' . $linkname;
    if (file_exists($linkpath)) {
        unlink($linkpath);
    }

    $dir->symlink($target, $linkname);

    if (is_link($linkpath)) {
        ok('dir: symlink: symlink created successfully');
    } else {
        ko('dir: symlink: symlink should have been created');
    }

    if (file_exists($linkpath) && file_get_contents($linkpath) === 'symlink target') {
        ok('dir: symlink: symlink resolves to target content');
    } else {
        ko('dir: symlink: symlink should resolve to target');
    }

    unlink($linkpath);
    if (is_file($targetpath)) {
        unlink($targetpath);
    }
}
