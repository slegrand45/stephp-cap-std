<?php

namespace tests\file;

function rewind(string $root) {
    $filename = 'test-stephp-cap-std-rewind';
    $filepath = $root . '/' . $filename;
    $content = 'rewind test content';
    if (! is_file($filepath)) {
        file_put_contents($filepath, $content);
    }
    $ambient_auth = stephp_cap_std_ambient_authority();
    $dir = stephp_cap_std_open_ambient_dir($ambient_auth, $root);
    $fd = $dir->open($filename);

    $fd->read(5);
    $pos = $fd->stream_position();
    if ($pos !== 5) {
        ko("file: rewind: expected position 5 after read(5), got $pos");
    }
    $fd->rewind();
    $pos = $fd->stream_position();
    if ($pos === 0) {
        ok('file: rewind: rewind() resets position to 0');
    } else {
        ko("file: rewind: position should be 0 after rewind(), got $pos");
    }

    $data = $fd->read_to_string();
    if ($data === $content) {
        ok('file: rewind: can read full content after rewind');
    } else {
        ko("file: rewind: expected '$content', got '$data'");
    }

    if (is_file($filepath)) {
        unlink($filepath);
    }
}
