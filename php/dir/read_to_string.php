<?php

namespace tests\dir;

function read_to_string(string $root) {
    $filename = 'test-stephp-cap-std-file';
    $filepath = $root . '/' . $filename;
    $content = 'stephp-cap-std-file é 🐧  ù rust meets php';
    if (is_file($filepath)) {
        unlink($filepath);
    }
    $ambient_auth = stephp_cap_std_ambient_authority();
    $dir = stephp_cap_std_open_ambient_dir($ambient_auth, $root);
    $dir->write($filename, $content);
    $s = $dir->read_to_string($filename);
    if ($s === $content) {
        ok('dir: read_to_string: strings are the same');
    } else {
        ko("dir: read_to_string: string should be '$content' but is '$s'");
    }
    if (is_file($filepath)) {
        unlink($filepath);
    }
}