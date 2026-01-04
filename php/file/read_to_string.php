<?php

namespace tests\file;

function read_to_string(string $root) {
    $filename = 'test-stephp-cap-std-file';
    $filepath = $root . '/' . $filename;
    $content = 'stephp-cap-std-file é 🐧  ù rust meets php';
    if (! file_exists($filepath)) {
        file_put_contents($filepath, $content);
    }
    $ambient_auth = stephp_cap_std_ambient_authority();
    $dir = stephp_cap_std_open_ambient_dir($ambient_auth, $root);
    $fd = $dir->open($filename);
    $data = $fd->read_to_string();
    if ($data === $content) {
        ok('file: read_to_string (string): content is the same');
    } else {
        ko("file: read_to_string (string): content should be '$content' but is '$data'");
    }
    if (is_file($filepath)) {
        unlink($filepath);
    }
}