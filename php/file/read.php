<?php

namespace tests\file;

function read(string $root) {
    $filename = 'test-stephp-cap-std-file';
    $filepath = $root . '/' . $filename;
    $content = 'stephp-cap-std-file é 🐧  ù rust meets php';
    if (! file_exists($filepath)) {
        file_put_contents($filepath, $content);
    }
    $ambient_auth = stephp_cap_std_ambient_authority();
    $dir = stephp_cap_std_open_ambient_dir($ambient_auth, $root);
    $fd = $dir->open($filename);
    $data = $fd->read(1024);
    if ($data === $content) {
        ok('file: read (string): content is the same');
    } else {
        ko("file: read (string): content should be '$content' but is '$data'");
    }
    $filename = 'test-stephp-cap-std-file-reference.png';
    $filepath = $root . '/' . $filename;
    if (! file_exists($filepath)) {
        copy(__DIR__ . '/reference.png', $filepath);
    }
    $checksum_file = md5_file($filepath);
    $fd = $dir->open($filename);
    $data = $fd->read(1024);
    $checksum_data = md5($data);
    if ($checksum_file === $checksum_data) {
        ok('file: read (binary): checksum is the same');
    } else {
        ko("file: read (binary): checksum should be '$checksum_file' but is '$checksum_data'");
    }
}