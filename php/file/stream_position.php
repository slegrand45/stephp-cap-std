<?php

namespace tests\file;

function stream_position(string $root) {
    $filename = 'test-stephp-cap-std-file';
    $filepath = $root . '/' . $filename;
    $content = 'stephp-cap-std-file é 🐧  ù rust meets php';
    if (! file_exists($filepath)) {
        file_put_contents($filepath, $content);
    }
    $ambient_auth = stephp_cap_std_ambient_authority();
    $dir = stephp_cap_std_open_ambient_dir($ambient_auth, $root);
    $fd = $dir->open($filename);
    $data = $fd->read(10);
    $pos = $fd->stream_position();
    if ($pos === 10) {
        ok('file: stream_position: position is ok');
    } else {
        ko("file: stream_position: position should be 10 but is $pos");
    }
    if (is_file($filepath)) {
        unlink($filepath);
    }
}