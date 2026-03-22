<?php

namespace tests\dir;

function read_link(string $root) {
    if (PHP_OS_FAMILY === 'Windows') {
        warning('dir: read_link: skipped on Windows (no symlinks)');
        return;
    }

    $ambient_auth = stephp_cap_std_ambient_authority();
    $dir = stephp_cap_std_open_ambient_dir($ambient_auth, $root);

    $target = 'test-stephp-cap-std-readlink-target';
    $targetpath = $root . '/' . $target;
    if (is_file($targetpath)) {
        unlink($targetpath);
    }
    file_put_contents($targetpath, 'target content');

    $linkname = 'test-stephp-cap-std-readlink';
    $linkpath = $root . '/' . $linkname;
    if (file_exists($linkpath)) {
        unlink($linkpath);
    }
    symlink($target, $linkpath);

    $read = $dir->read_link($linkname);
    $expected = $target;
    if ($read === $expected || basename($read) === $expected) {
        ok('dir: read_link: returns correct symlink target');
    } else {
        ko("dir: read_link: expected '$expected', got '$read'");
    }

    unlink($linkpath);
    if (is_file($targetpath)) {
        unlink($targetpath);
    }
}
