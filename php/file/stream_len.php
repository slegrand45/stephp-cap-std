<?php

namespace tests\file;

function stream_len(string $root) {
    $filename = 'test-stephp-cap-std-stream-len';
    $content = 'stream length test data';
    $filepath = $root . '/' . $filename;
    if (! is_file($filepath)) {
        file_put_contents($filepath, $content);
    }
    $ambient_auth = stephp_cap_std_ambient_authority();
    $dir = stephp_cap_std_open_ambient_dir($ambient_auth, $root);
    $fd = $dir->open($filename);

    $len = $fd->stream_len();
    if ($len === strlen($content)) {
        ok('file: stream_len: returns correct file length');
    } else {
        ko("file: stream_len: expected " . strlen($content) . ", got $len");
    }

    $fd->read(5);
    $len_after_read = $fd->stream_len();
    if ($len_after_read === strlen($content)) {
        ok('file: stream_len: length unchanged after read');
    } else {
        ko("file: stream_len: length should remain " . strlen($content) . " after read");
    }

    if (is_file($filepath)) {
        unlink($filepath);
    }
}
