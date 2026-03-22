<?php

namespace tests\dir;

function is_file_test(string $root) {
    $ambient_auth = stephp_cap_std_ambient_authority();
    $dir = stephp_cap_std_open_ambient_dir($ambient_auth, $root);

    $filename = 'test-stephp-cap-std-is-file';
    $filepath = $root . '/' . $filename;
    if (! \is_file($filepath)) {
        file_put_contents($filepath, 'test');
    }

    if ($dir->is_file($filename)) {
        ok('dir: is_file: file path returns true');
    } else {
        ko('dir: is_file: file path should return true');
    }

    $subdir = 'test-stephp-cap-std-is-file-dir';
    $subdirpath = $root . '/' . $subdir;
    if (! \is_dir($subdirpath)) {
        mkdir($subdirpath);
    }
    if (! $dir->is_file($subdir)) {
        ok('dir: is_file: directory path returns false');
    } else {
        ko('dir: is_file: directory path should return false');
    }

    if (! $dir->is_file('nonexistent-' . uniqid())) {
        ok('dir: is_file: non-existent path returns false');
    } else {
        ko('dir: is_file: non-existent path should return false');
    }

    if (\is_file($filepath)) {
        unlink($filepath);
    }
    if (\is_dir($subdirpath)) {
        rmdir($subdirpath);
    }
}
