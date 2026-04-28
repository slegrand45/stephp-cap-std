<?php

namespace tests\file;

function seek_extended(string $root) {
    $filename = 'test-seek-extended.txt';
    $content = 'abcdefghijklmnopqrstuvwxyz'; // 26 bytes
    $filepath = $root . '/' . $filename;
    file_put_contents($filepath, $content);

    $ambient_auth = stephp_cap_std_ambient_authority();
    $dir = stephp_cap_std_open_ambient_dir($ambient_auth, $root);
    $fd = $dir->open($filename);

    // Test seek_relative
    if (method_exists($fd, 'seek_relative')) {
        $fd->seek(5, SEEK_SET);
        $fd->seek_relative(2);
        $pos = $fd->stream_position();
        if ($pos === 7) {
            ok('file: seek_extended: seek_relative(2) from 5 reaches 7');
        } else {
            ko("file: seek_extended: seek_relative(2) from 5 reached $pos instead of 7");
        }

        $fd->seek_relative(-3);
        $pos = $fd->stream_position();
        if ($pos === 4) {
            ok('file: seek_extended: seek_relative(-3) from 7 reaches 4');
        } else {
            ko("file: seek_extended: seek_relative(-3) from 7 reached $pos instead of 4");
        }
    } else {
        warning('file: seek_extended: seek_relative() not available');
    }

    // Test seek beyond EOF
    $pos = $fd->seek(10, SEEK_END);
    if ($pos === 36) {
        ok('file: seek_extended: seek(10, SEEK_END) allowed beyond EOF');
    } else {
        ko("file: seek_extended: seek(10, SEEK_END) expected 36, got $pos");
    }

    // Cleanup
    if (file_exists($filepath)) {
        unlink($filepath);
    }
}
