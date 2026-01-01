<?php

namespace tests\dir;

function read(string $root) {
    $ambient_auth = stephp_cap_std_ambient_authority();
    $dir = stephp_cap_std_open_ambient_dir($ambient_auth, $root);
    $filename = 'test-stephp-cap-std-file-reference.png';
    $filepath = $root . '/' . $filename;
    if (! file_exists($filepath)) {
        \copy(__DIR__ . '/reference.png', $filepath);
    }
    $checksum_file = md5_file($filepath);
    $data = $dir->read($filename);
    $checksum_data = md5($data);
    if ($checksum_file === $checksum_data) {
        ok('dir: read (binary): checksum is the same');
    } else {
        ko("dir: read (binary): checksum should be '$checksum_file' but is '$checksum_data'");
    }
    if (is_file($filepath)) {
        unlink($filepath);
    }
}