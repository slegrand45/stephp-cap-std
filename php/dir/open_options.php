<?php

namespace tests\dir;

function open_options(string $root) {
    $ambient_auth = stephp_cap_std_ambient_authority();
    $dir = stephp_cap_std_open_ambient_dir($ambient_auth, $root);

    $filename = 'test-open-options.txt';
    $filepath = $root . '/' . $filename;

    // Test: create_new(true)
    if (file_exists($filepath)) {
        unlink($filepath);
    }
    $options = \StephpCapStdOpenOptions::new();
    $options->write(true);
    $options->create_new(true);
    $fd = $dir->open_with($filename, $options);
    $fd->write('initial content');
    $fd->flush();
    if (file_get_contents($filepath) === 'initial content') {
        ok('dir: open_options: create_new(true) created new file');
    } else {
        ko('dir: open_options: create_new(true) failed to create file with content');
    }

    // Test: create_new(true) on existing file should fail
    $failed = false;
    try {
        $dir->open_with($filename, $options);
    } catch (\Throwable $e) {
        $failed = true;
    }
    if ($failed) {
        ok('dir: open_options: create_new(true) fails on existing file');
    } else {
        ko('dir: open_options: create_new(true) should fail on existing file');
    }

    // Test: truncate(true)
    $options = \StephpCapStdOpenOptions::new();
    $options->write(true);
    $options->truncate(true);
    $fd = $dir->open_with($filename, $options);
    $fd->write('new');
    $fd->flush();
    if (file_get_contents($filepath) === 'new') {
        ok('dir: open_options: truncate(true) truncated file');
    } else {
        ko('dir: open_options: truncate(true) failed to truncate file');
    }

    // Test: append(true)
    $options = \StephpCapStdOpenOptions::new();
    $options->write(true);
    $options->append(true);
    $fd = $dir->open_with($filename, $options);
    $fd->write(' appended');
    $fd->flush();
    if (file_get_contents($filepath) === 'new appended') {
        ok('dir: open_options: append(true) appended content');
    } else {
        $content = file_get_contents($filepath);
        ko("dir: open_options: append(true) failed, got '$content'");
    }

    // Cleanup
    if (file_exists($filepath)) {
        unlink($filepath);
    }
}
