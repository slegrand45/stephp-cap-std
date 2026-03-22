<?php

namespace tests\dir;

function is_dir_test(string $root) {
    $ambient_auth = stephp_cap_std_ambient_authority();
    $dir = stephp_cap_std_open_ambient_dir($ambient_auth, $root);

    $subdir = 'test-stephp-cap-std-is-dir';
    $subdirpath = $root . '/' . $subdir;
    if (! \is_dir($subdirpath)) {
        mkdir($subdirpath);
    }

    if ($dir->is_dir($subdir)) {
        ok('dir: is_dir: directory path returns true');
    } else {
        ko('dir: is_dir: directory path should return true');
    }

    $filename = 'test-stephp-cap-std-is-dir-file';
    $filepath = $root . '/' . $filename;
    if (! \is_file($filepath)) {
        file_put_contents($filepath, 'test');
    }
    if (! $dir->is_dir($filename)) {
        ok('dir: is_dir: file path returns false');
    } else {
        ko('dir: is_dir: file path should return false');
    }

    if (! $dir->is_dir('nonexistent-' . uniqid())) {
        ok('dir: is_dir: non-existent path returns false');
    } else {
        ko('dir: is_dir: non-existent path should return false');
    }

    if (\is_dir($subdirpath)) {
        rmdir($subdirpath);
    }
    if (\is_file($filepath)) {
        unlink($filepath);
    }
}
