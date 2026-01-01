<?php

namespace tests\dir;

function write(string $root) {
    $filename = 'test-stephp-cap-std-file';
    $filepath = $root . '/' . $filename;
    $content = 'stephp-cap-std-file é 🐧  ù rust meets php';
    if (is_file($filepath)) {
        unlink($filepath);
    }
    $ambient_auth = stephp_cap_std_ambient_authority();
    $dir = stephp_cap_std_open_ambient_dir($ambient_auth, $root);
    $dir->write($filename, $content);
    $data = file_get_contents($filepath);
    if ($data === $content) {
        ok('dir: write (string): content is the same');
    } else {
        ko("dir: write (string): content should be '$content' but is '$data'");
    }
    if (is_file($filepath)) {
        unlink($filepath);
    }

    $refpath = __DIR__ . '/reference.png';
    $filename = 'test-stephp-cap-std-file-reference.png';
    $filepath = $root . '/' . $filename;
    if (is_file($filepath)) {
        unlink($filepath);
    }
    $content = file_get_contents($refpath);
    $dir->write($filename, $content);
    $checksum_ref = md5_file($refpath);
    $checksum_data = md5_file($filepath);
    if ($checksum_ref === $checksum_data) {
        ok('file: write (binary): checksum is the same');
    } else {
        ko("file: write (binary): checksum should be '$checksum_ref' but is '$checksum_data'");
    }
    if (is_file($filepath)) {
        unlink($filepath);
    }
}