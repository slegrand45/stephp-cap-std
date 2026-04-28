<?php

namespace tests\dir;

function open_mode(string $root) {
    if (PHP_OS_FAMILY === 'Windows') {
        warning('dir: open_mode: skipped on Windows');
        return;
    }

    $ambient_auth = stephp_cap_std_ambient_authority();
    $dir = stephp_cap_std_open_ambient_dir($ambient_auth, $root);

    $filename = 'test-open-mode.txt';
    $filepath = $root . '/' . $filename;
    if (file_exists($filepath)) {
        unlink($filepath);
    }

    $options = \StephpCapStdOpenOptions::new();
    $options->write(true);
    $options->create(true);
    $options->mode(0600); // Only owner can read/write
    
    $fd = $dir->open_with($filename, $options);
    $fd->write('mode test');
    $fd->flush();

    clearstatcache();
    $perms = fileperms($filepath) & 0777;
    if ($perms === 0600) {
        ok('dir: open_mode: file created with correct mode 0600');
    } else {
        ko("dir: open_mode: expected mode 0600, got " . sprintf('%o', $perms));
    }

    if (file_exists($filepath)) {
        unlink($filepath);
    }
}
