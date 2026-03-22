<?php

namespace tests\file;

function seek(string $root) {
    $filename = 'test-stephp-cap-std-seek';
    $content = '0123456789abcdef';
    $filepath = $root . '/' . $filename;
    if (! is_file($filepath)) {
        file_put_contents($filepath, $content);
    }
    $ambient_auth = stephp_cap_std_ambient_authority();
    $dir = stephp_cap_std_open_ambient_dir($ambient_auth, $root);
    $fd = $dir->open($filename);

    $pos = $fd->seek(5, SEEK_SET);
    if ($pos === 5) {
        ok('file: seek: SEEK_SET(5) returns position 5');
    } else {
        ko("file: seek: SEEK_SET(5) expected 5, got $pos");
    }

    $data = $fd->read(3);
    if ($data === '567') {
        ok('file: seek: read after seek returns correct bytes');
    } else {
        ko("file: seek: expected '567', got '$data'");
    }

    $pos = $fd->seek(-2, SEEK_CUR);
    if ($pos === 6) {
        ok('file: seek: SEEK_CUR(-2) returns position 6');
    } else {
        ko("file: seek: SEEK_CUR(-2) expected 6, got $pos");
    }

    $pos = $fd->seek(0, SEEK_END);
    if ($pos === strlen($content)) {
        ok('file: seek: SEEK_END(0) returns file length');
    } else {
        ko("file: seek: SEEK_END(0) expected " . strlen($content) . ", got $pos");
    }

    if (is_file($filepath)) {
        unlink($filepath);
    }
}
