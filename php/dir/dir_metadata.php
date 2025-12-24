<?php

namespace tests\dir;

function dir_metadata(string $root) {
    $ambient_auth = stephp_cap_std_ambient_authority();
    $dir = stephp_cap_std_open_ambient_dir($ambient_auth, $root);
    $metadata = $dir->dir_metadata();
    if (is_a($metadata, 'StephpCapStdMetadata')) {
        ok('dir: dir_metadata: dir_metadata() returned an StephpCapStdMetadata object');
    } else {
        ko('dir: dir_metadata: dir_metadata() should return an StephpCapStdMetadata object');
    }
    if ($metadata->file_type()->is_dir()) {
        ok('dir: dir_metadata: file_type() is dir');
    } else {
        ko('dir: dir_metadata: file_type() should be dir');
    }
}