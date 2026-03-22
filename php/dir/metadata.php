<?php

namespace tests\dir;

function metadata(string $root) {
    $ambient_auth = stephp_cap_std_ambient_authority();
    $dir = stephp_cap_std_open_ambient_dir($ambient_auth, $root);

    $filename = 'test-stephp-cap-std-metadata';
    $content = 'hello metadata test';
    $filepath = $root . '/' . $filename;
    if (is_file($filepath)) {
        unlink($filepath);
    }
    file_put_contents($filepath, $content);

    $meta = $dir->metadata($filename);
    if (! is_a($meta, 'StephpCapStdMetadata')) {
        ko('dir: metadata: should return StephpCapStdMetadata object');
    } else {
        ok('dir: metadata: returns StephpCapStdMetadata object');
    }

    if ($meta->is_file()) {
        ok('dir: metadata: is_file() returns true for file');
    } else {
        ko('dir: metadata: is_file() should return true for file');
    }

    if (! $meta->is_dir()) {
        ok('dir: metadata: is_dir() returns false for file');
    } else {
        ko('dir: metadata: is_dir() should return false for file');
    }

    $len = $meta->len();
    if ($len === strlen($content)) {
        ok("dir: metadata: len() returns correct size ($len)");
    } else {
        ko("dir: metadata: len() should be " . strlen($content) . ", got $len");
    }

    $subdir = 'test-stephp-cap-std-metadata-dir';
    $subdirpath = $root . '/' . $subdir;
    if (! is_dir($subdirpath)) {
        mkdir($subdirpath);
    }
    $dirmeta = $dir->metadata($subdir);
    if ($dirmeta->is_dir()) {
        ok('dir: metadata: is_dir() returns true for directory');
    } else {
        ko('dir: metadata: is_dir() should return true for directory');
    }

    if (is_file($filepath)) {
        unlink($filepath);
    }
    if (is_dir($subdirpath)) {
        rmdir($subdirpath);
    }
}
