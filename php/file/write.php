<?php

namespace tests\file;

function write(string $root) {
    $filename = 'test-stephp-cap-std-file';
    $filepath = $root . '/' . $filename;
    $content = 'stephp-cap-std-file é 🐧  ù rust meets php';
    if (is_file($filepath)) {
        unlink($filepath);
    }
    $ambient_auth = stephp_cap_std_ambient_authority();
    $dir = stephp_cap_std_open_ambient_dir($ambient_auth, $root);
    $fd = $dir->create($filename);
    $nb = $fd->write($content);
    if ($nb === strlen($content)) {
        ok('file: write (string): write() returns ' . $nb);
    } else {
        ko("file: write (string): write() returned $nb but should have returned " . strlen($content));
    }
    $data = file_get_contents($filepath);
    if ($data === $content) {
        ok('file: write (string): content is the same');
    } else {
        ko("file: write (string): content should be '$content' but is '$data'");
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
    $fd = $dir->create($filename);
    $nb = $fd->write($content);
    if ($nb === strlen($content)) {
        ok('file: write (binary): write() returns ' . $nb);
    } else {
        ko("file: write (binary): write() returned $nb but should have returned " . strlen($content));
    }
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