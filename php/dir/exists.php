<?php

namespace tests\dir;

function exists(string $root) {
    $ambient_auth = stephp_cap_std_ambient_authority();
    $dir = stephp_cap_std_open_ambient_dir($ambient_auth, $root);

    $filename = 'test-stephp-cap-std-exists';
    $filepath = $root . '/' . $filename;
    if (! is_file($filepath)) {
        file_put_contents($filepath, 'test');
    }

    if ($dir->exists($filename)) {
        ok('dir: exists: existing file returns true');
    } else {
        ko('dir: exists: existing file should return true');
    }

    if (! $dir->exists('nonexistent-file-' . uniqid())) {
        ok('dir: exists: non-existent path returns false');
    } else {
        ko('dir: exists: non-existent path should return false');
    }

    $subdir = 'test-stephp-cap-std-exists-dir';
    $subdirpath = $root . '/' . $subdir;
    if (! is_dir($subdirpath)) {
        mkdir($subdirpath);
    }
    if ($dir->exists($subdir)) {
        ok('dir: exists: existing directory returns true');
    } else {
        ko('dir: exists: existing directory should return true');
    }

    if (is_file($filepath)) {
        unlink($filepath);
    }
    if (is_dir($subdirpath)) {
        rmdir($subdirpath);
    }
}
