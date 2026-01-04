<?php

namespace tests\dir;

function open_with(string $root) {
    $ambient_auth = stephp_cap_std_ambient_authority();
    $dir = stephp_cap_std_open_ambient_dir($ambient_auth, $root);
    $filename = 'test-stephp-cap-std-file-reference.png';
    $filepath = $root . '/' . $filename;
    if (! file_exists($filepath)) {
        \copy(__DIR__ . '/reference.png', $filepath);
    }
    $options = \StephpCapStdOpenOptions::new();
    $options->read(false);
    try {
        $fd = $dir->open_with($filename, $options);
        $data = $dir->read($filename);
        ko('dir: open_with (without read permission): should have thrown an exception');
    } catch (\Exception $e) {
        ok('dir: open_with (without read permission): throw an exception');
    }
    $options->read(true);
    $fd = $dir->open_with($filename, $options);
    try {
        $data = $dir->read($filename);
        ok('dir: open_with (with read permission): no exception');
    } catch (\Exception $e) {
        ko('dir: open_with (with read permission): should not throw an exception');
    }
    if (is_file($filepath)) {
        unlink($filepath);
    }
}