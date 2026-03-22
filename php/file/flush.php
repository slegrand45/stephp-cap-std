<?php

namespace tests\file;

function flush(string $root) {
    $filename = 'test-stephp-cap-std-flush';
    $filepath = $root . '/' . $filename;
    if (is_file($filepath)) {
        unlink($filepath);
    }
    $ambient_auth = stephp_cap_std_ambient_authority();
    $dir = stephp_cap_std_open_ambient_dir($ambient_auth, $root);
    $fd = $dir->create($filename);
    $content = 'flush test content';
    $fd->write($content);
    $fd->flush();

    clearstatcache();
    if (is_file($filepath) && file_get_contents($filepath) === $content) {
        ok('file: flush: flush() persists data to disk');
    } else {
        ko('file: flush: data should be persisted after flush()');
    }

    if (is_file($filepath)) {
        unlink($filepath);
    }
}
